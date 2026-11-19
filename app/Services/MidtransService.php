<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MidtransService
{
    /**
     * Check whether Midtrans API credentials are configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->serverKey()) && ! empty($this->clientKey());
    }

    public function isProduction(): bool
    {
        return (bool) config('services.midtrans.is_production', false);
    }

    public function serverKey(): ?string
    {
        return config('services.midtrans.server_key') ?: null;
    }

    public function clientKey(): ?string
    {
        return config('services.midtrans.client_key') ?: null;
    }

    public function snapScriptUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    private function snapApiUrl(): string
    {
        return $this->isProduction()
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    private function coreApiBaseUrl(): string
    {
        return $this->isProduction()
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    /**
     * Create or reuse a Midtrans Snap transaction for an unpaid order.
     */
    public function createSnapTransaction(Order $order, bool $forceNew = false): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Midtrans belum dikonfigurasi.',
            ];
        }

        if (! $forceNew && ! empty($order->snap_token) && ! empty($order->payment_reference)) {
            return [
                'success' => true,
                'snap_token' => $order->snap_token,
                'redirect_url' => $order->snap_redirect_url,
                'payment_reference' => $order->payment_reference,
            ];
        }

        $midtransOrderId = $forceNew || ! empty($order->payment_reference)
            ? $order->order_number . '-' . strtoupper(Str::random(5))
            : $order->order_number;

        $payload = $this->buildSnapPayload($order, $midtransOrderId);
        $response = $this->postSnapTransaction($payload);

        // Retry without enabled_payments filter if a merchant channel is not active yet
        if (! $response->successful() && isset($payload['enabled_payments'])) {
            unset($payload['enabled_payments']);
            $response = $this->postSnapTransaction($payload);
        }

        if (! $response->successful()) {
            return [
                'success' => false,
                'message' => $response->json('error_messages.0') ?? 'Gagal membuat sesi pembayaran Midtrans.',
            ];
        }

        $data = $response->json();

        $order->update([
            'payment_gateway' => 'midtrans',
            'payment_reference' => $midtransOrderId,
            'snap_token' => $data['token'] ?? null,
            'snap_redirect_url' => $data['redirect_url'] ?? null,
        ]);

        return [
            'success' => true,
            'snap_token' => $order->snap_token,
            'redirect_url' => $order->snap_redirect_url,
            'payment_reference' => $order->payment_reference,
        ];
    }

    private function postSnapTransaction(array $payload)
    {
        return Http::withBasicAuth((string) $this->serverKey(), '')
            ->acceptJson()
            ->timeout(15)
            ->post($this->snapApiUrl(), $payload);
    }

    private function buildSnapPayload(Order $order, string $midtransOrderId): array
    {
        $order->loadMissing(['items', 'user']);
        $grossAmount = (int) round((float) $order->total_amount);

        $payload = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name ?: ($order->user->name ?? 'Pelanggan Toon Burger'),
                'email' => $order->user->email ?? 'customer@toonburger.com',
                'phone' => $order->customer_phone ?: '',
            ],
            'callbacks' => [
                'finish' => route('orders.show', $order->order_number),
            ],
        ];

        $itemDetails = $this->buildItemDetails($order, $grossAmount);
        if (! empty($itemDetails)) {
            $payload['item_details'] = $itemDetails;
        }

        $enabledPayments = $this->resolveEnabledPayments($order->payment_method);
        if (! empty($enabledPayments)) {
            $payload['enabled_payments'] = $enabledPayments;
        }

        return $payload;
    }

    private function buildItemDetails(Order $order, int $grossAmount): array
    {
        $items = [];
        $sum = 0;

        foreach ($order->items as $item) {
            $qty = max(1, (int) $item->quantity);
            $unitPrice = (int) round(((float) $item->subtotal) / $qty);
            $items[] = [
                'id' => (string) ($item->product_id ?? $item->id),
                'price' => $unitPrice,
                'quantity' => $qty,
                'name' => Str::limit($item->product_name, 50, ''),
            ];
            $sum += $unitPrice * $qty;
        }

        $tax = (int) round((float) $order->tax_amount);
        if ($tax > 0) {
            $items[] = [
                'id' => 'PB1-TAX',
                'price' => $tax,
                'quantity' => 1,
                'name' => 'Pajak Restoran PB1',
            ];
            $sum += $tax;
        }

        $discount = (int) round((float) $order->discount_amount);
        if ($discount > 0) {
            $items[] = [
                'id' => 'DISCOUNT',
                'price' => -$discount,
                'quantity' => 1,
                'name' => 'Diskon Promo',
            ];
            $sum -= $discount;
        }

        return $sum === $grossAmount ? $items : [];
    }

    private function resolveEnabledPayments(?string $method): array
    {
        return match ($method) {
            'qris' => ['other_qris', 'gopay', 'shopeepay'],
            'bank_transfer' => ['bca_va', 'bni_va', 'bri_va', 'permata_va', 'echannel'],
            'ewallet' => ['gopay', 'shopeepay', 'dana'],
            default => [],
        };
    }

    /**
     * Verify Midtrans webhook SHA-512 signature.
     */
    public function verifySignature(array $payload): bool
    {
        $serverKey = $this->serverKey();
        if (empty($serverKey)) {
            return false;
        }

        $orderId = (string) ($payload['order_id'] ?? '');
        $statusCode = (string) ($payload['status_code'] ?? '');
        $grossAmount = (string) ($payload['gross_amount'] ?? '');
        $signatureKey = (string) ($payload['signature_key'] ?? '');

        if ($orderId === '' || $statusCode === '' || $grossAmount === '' || $signatureKey === '') {
            return false;
        }

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expected, $signatureKey);
    }

    /**
     * Fetch live transaction status directly from Midtrans Core API.
     */
    public function fetchTransactionStatus(string $midtransOrderId): ?array
    {
        if (! $this->isConfigured() || $midtransOrderId === '') {
            return null;
        }

        $response = Http::withBasicAuth((string) $this->serverKey(), '')
            ->acceptJson()
            ->timeout(15)
            ->get("{$this->coreApiBaseUrl()}/{$midtransOrderId}/status");

        return $response->successful() ? $response->json() : null;
    }

    /**
     * Resolve local Order by Midtrans reference or base order number.
     */
    public function findOrderForReference(string $midtransOrderId): ?Order
    {
        $order = Order::where('payment_reference', $midtransOrderId)->first();
        if ($order) {
            return $order;
        }

        $baseOrderNumber = preg_replace('/-[A-Z0-9]{5}$/', '', $midtransOrderId);
        return Order::where(function ($q) use ($midtransOrderId, $baseOrderNumber) {
                $q->where('order_number', $midtransOrderId)
                  ->orWhere('order_number', $baseOrderNumber);
            })
            ->where(function ($q) use ($midtransOrderId) {
                $q->whereNull('payment_reference')
                  ->orWhere('payment_reference', '')
                  ->orWhere('payment_reference', $midtransOrderId);
            })
            ->first();
    }

    /**
     * Apply verified Midtrans status payload to an Order cleanly.
     */
    public function applyGatewayStatus(Order $order, array $payload): string
    {
        $expectedAmount = (int) round((float) $order->total_amount);
        $receivedAmount = (int) round((float) ($payload['gross_amount'] ?? 0));
        if ($receivedAmount <= 0 || $receivedAmount !== $expectedAmount) {
            return 'amount_mismatch';
        }

        if ($order->status === 'cancelled') {
            return 'cancelled';
        }

        $txStatus = (string) ($payload['transaction_status'] ?? '');
        $fraudStatus = (string) ($payload['fraud_status'] ?? 'accept');

        if ($txStatus === 'settlement' || ($txStatus === 'capture' && $fraudStatus === 'accept')) {
            if ($order->payment_status !== 'paid') {
                $this->markOrderAsPaid($order, $payload);
            }
            return 'paid';
        }

        if (in_array($txStatus, ['expire', 'cancel', 'deny'], true)) {
            $order->update([
                'snap_token' => null,
                'snap_redirect_url' => null,
            ]);
            return 'expired';
        }

        return 'pending';
    }

    private function markOrderAsPaid(Order $order, array $payload): void
    {
        DB::transaction(function () use ($order, $payload) {
            $order->update([
                'payment_status' => 'paid',
                'payment_gateway' => 'midtrans',
                'paid_at' => now(),
                'status' => $order->status === 'pending' ? 'confirmed' : $order->status,
            ]);

            if (Schema::hasTable('payments')) {
                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'transaction_code' => $payload['transaction_id'] ?? ($order->payment_reference ?? 'PAY-' . strtoupper(Str::random(10))),
                        'payment_method' => $order->payment_method,
                        'amount' => $order->total_amount,
                        'status' => 'success',
                        'payment_details' => $payload,
                        'paid_at' => now(),
                    ]
                );
            }
        });
    }
}

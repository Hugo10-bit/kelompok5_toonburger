@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Toon Burger')
@section('footer_bg', 'orders-dot-bg')

@section('content')
@php
    $stepperSteps = [
        1 => 'Menunggu',
        2 => 'Dimasak',
        3 => 'Siap Saji',
        4 => 'Selesai',
    ];
    $currentStep = match ($order->status) {
        'pending' => 1,
        'confirmed', 'preparing' => 2,
        'ready' => 3,
        'completed' => 4,
        default => 0,
    };
    $progressPercent = $currentStep >= 1 ? (($currentStep - 1) / (count($stepperSteps) - 1)) * 100 : 0;

    $paymentMethodLabel = match (strtolower((string) $order->payment_method)) {
        'qris' => 'Qris',
        'cash' => 'Cash',
        'transfer', 'bank_transfer' => 'Transfer Bank',
        'ewallet', 'e_wallet' => 'E-Wallet',
        default => ucwords(str_replace('_', ' ', (string) $order->payment_method)),
    };

    $orderTypeLabel = match (strtolower((string) $order->order_type)) {
        'takeaway', 'pickup', 'pickup_order' => 'Pickup Order',
        'delivery', 'delivery_order' => 'Delivery Order',
        'dine_in' => 'Dine In' . ($order->table ? ' (' . $order->table->table_number . ')' : ''),
        default => ucwords(str_replace('_', ' ', (string) $order->order_type)),
    };

    $statusMeta = match ($order->status) {
        'pending' => [
            'dot' => 'bg-[#F4BD22]',
            'text' => 'Menunggu Konfirmasi Dapur',
        ],
        'confirmed', 'preparing' => [
            'dot' => 'bg-[#EF4444]',
            'text' => 'Pesanan Sedang Dimasak',
        ],
        'ready' => [
            'dot' => 'bg-[#22C55E]',
            'text' => $order->order_type === 'delivery' ? 'Pesanan Siap Diantar!' : 'Pesanan Siap Diambil di Kasir!',
        ],
        'completed' => [
            'dot' => 'bg-[#3B82F6]',
            'text' => 'Pesanan Selesai & Telah Diambil',
        ],
        'cancelled' => [
            'dot' => 'bg-[#DC2626]',
            'text' => 'Pesanan Dibatalkan',
        ],
        default => [
            'dot' => 'bg-gray-400',
            'text' => ucfirst((string) $order->status),
        ],
    };

    $orderLevelNote = trim((string) ($order->notes ?? ''));
    $itemNoteList = $order->items
        ->pluck('notes')
        ->map(fn ($n) => trim((string) $n))
        ->filter()
        ->unique()
        ->values()
        ->all();
    $displayOrderNote = $orderLevelNote !== '' ? $orderLevelNote : implode('; ', $itemNoteList);
    $showIndividualItemNotes = $orderLevelNote !== '';

    $isUnpaidActive = $order->payment_status !== 'paid' && $order->status !== 'cancelled';
    $shouldPollStatus = !in_array($order->status, ['completed', 'cancelled'], true) || $isUnpaidActive;
@endphp

<div class="orders-dot-bg min-h-screen -mt-[88px] sm:-mt-[96px] pt-[112px] sm:pt-[124px] pb-14 sm:pb-20 print:mt-0 print:pt-4">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    @if($shouldPollStatus)
        <div id="midtrans-payment-config"
             class="hidden"
             data-order-number="{{ $order->order_number }}"
             data-order-status="{{ $order->status }}"
             data-payment-status="{{ $order->payment_status }}"
             data-payment-method="{{ $order->payment_method }}"
             data-proof-state="{{ $order->hasPaymentProof() ? 'uploaded' : (!empty($order->payment_proof_rejected_reason) ? 'rejected' : 'none') }}"
             data-midtrans-configured="{{ !empty($midtransConfigured) ? 'true' : 'false' }}"
             data-snap-script-url="{{ $snapScriptUrl ?? '' }}"
             data-client-key="{{ $midtransClientKey ?? '' }}"
             data-snap-token="{{ $order->snap_token ?? '' }}"
             data-snap-redirect-url="{{ $order->snap_redirect_url ?? '' }}"
             data-token-url="{{ route('orders.midtrans.token', $order->order_number) }}"
             data-sync-url="{{ route('orders.payment.sync', $order->order_number) }}"
             data-status-url="{{ route('orders.payment.status', $order->order_number) }}"></div>
    @endif

    <!-- Top Header Row -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
        <div>
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="bg-[#2B302E] text-white font-mono text-[11px] font-semibold px-3 py-1 rounded-md tracking-wide">
                    {{ $order->order_number }}
                </span>
                <span class="text-xs text-[#6B7280] font-normal">
                    {{ $order->created_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA
                </span>
            </div>
            <h1 class="font-brand text-[26px] sm:text-[34px] lg:text-[38px] text-[#3B5954] uppercase tracking-wide leading-[1.08] mt-1.5"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                STATUS &amp; BUKTI PESANAN
            </h1>
        </div>

        <!-- Single Context-Aware Action Button (Tampilkan Qris / Simpan/cetak struk) -->
        <div class="flex items-center gap-2 self-start sm:self-end no-print">
            @if($isUnpaidActive && !empty($midtransConfigured) && $order->payment_method !== 'cash')
                <button type="button"
                        id="btn-midtrans-pay"
                        onclick="window.payWithMidtrans(false)"
                        class="border border-[#6B7280]/80 bg-transparent hover:bg-white/80 text-[#2B302E] font-medium text-xs sm:text-[13px] px-4 py-2.5 rounded-lg inline-flex items-center gap-2.5 transition cursor-pointer active:scale-[0.98] whitespace-nowrap">
                    <span>Tampilkan {{ $paymentMethodLabel }}</span>
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <path d="M14 14h3v3h-3zM20 14v3h-1M14 20h3M20 20h1"/>
                    </svg>
                </button>
            @elseif($isUnpaidActive && $order->payment_method === 'qris')
                <button type="button"
                        onclick="window.openQrisModal()"
                        class="border border-[#6B7280]/80 bg-transparent hover:bg-white/80 text-[#2B302E] font-medium text-xs sm:text-[13px] px-4 py-2.5 rounded-lg inline-flex items-center gap-2.5 transition cursor-pointer active:scale-[0.98] whitespace-nowrap">
                    <span>Tampilkan Qris</span>
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <path d="M14 14h3v3h-3zM20 14v3h-1M14 20h3M20 20h1"/>
                    </svg>
                </button>
            @elseif($isUnpaidActive && $order->payment_method !== 'cash')
                <button type="button"
                        onclick="window.openPaymentProofModal()"
                        class="border border-[#6B7280]/80 bg-transparent hover:bg-white/80 text-[#2B302E] font-medium text-xs sm:text-[13px] px-4 py-2.5 rounded-lg inline-flex items-center gap-2.5 transition cursor-pointer active:scale-[0.98] whitespace-nowrap">
                    <span>{{ $order->hasPaymentProof() ? 'Ganti Bukti Bayar' : 'Upload Bukti Bayar' }}</span>
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="17 8 12 3 7 8"/>
                        <line x1="12" y1="3" x2="12" y2="15"/>
                    </svg>
                </button>
            @else
                <button type="button"
                        onclick="window.print()"
                        class="border border-[#6B7280]/80 bg-transparent hover:bg-white/80 text-[#2B302E] font-medium text-xs sm:text-[13px] px-4 py-2.5 rounded-lg inline-flex items-center gap-2.5 transition cursor-pointer active:scale-[0.98] whitespace-nowrap">
                    <span>Simpan/cetak struk</span>
                    <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M6 9V3h12v6"/>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                        <rect x="6" y="14" width="12" height="7" rx="1"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    @if($errors->any())
        <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-2xl flex items-center justify-between shadow-2xs" role="alert">
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    @if($isUnpaidActive && !empty($order->payment_proof_rejected_reason) && !$order->hasPaymentProof())
        <div class="mb-5 p-4 sm:p-5 bg-red-50 border border-red-200 text-red-900 rounded-2xl shadow-2xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 no-print" role="alert">
            <div class="space-y-1">
                <span class="inline-block bg-red-100 text-red-800 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                    Bukti Pembayaran Perlu Diunggah Ulang
                </span>
                <p class="text-xs text-red-800 font-medium">
                    {{ $order->payment_proof_rejected_reason }}
                </p>
            </div>
            <button type="button"
                    onclick="window.openPaymentProofModal()"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-4 py-2.5 rounded-xl transition shadow-xs whitespace-nowrap cursor-pointer">
                Upload Ulang Bukti
            </button>
        </div>
    @endif

    <!-- CARD 1: LIVE KITCHEN STATUS & 4-STEP PROGRESS STEPPER -->
    <div class="bg-white rounded-[22px] sm:rounded-[26px] px-5 py-6 sm:px-8 sm:py-7 border border-[#E5E0D4] shadow-[0_6px_24px_rgba(30,46,43,0.04)] mb-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <span class="text-[11px] sm:text-xs text-[#9CA3AF] font-normal block">Status Dapur</span>
                <div class="mt-1 flex items-center gap-2 text-sm sm:text-[15px] font-bold text-[#1F2937]">
                    <span class="w-2 h-2 rounded-full {{ $statusMeta['dot'] }} shrink-0"></span>
                    <span>{{ $statusMeta['text'] }}</span>
                </div>
            </div>

            <!-- Payment Status Pill -->
            <div class="text-right shrink-0">
                <span class="text-[11px] sm:text-xs text-[#9CA3AF] font-normal block mb-1">Status Pembayaran</span>
                @if($order->payment_status === 'paid')
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#E1F3E8] text-[#2F855A] font-semibold text-[11px]">
                        Lunas ({{ $paymentMethodLabel }})
                    </span>
                @elseif($order->isAwaitingPaymentVerification())
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#FEF3C7] text-[#B45309] font-semibold text-[11px]">
                        Menunggu Verifikasi
                    </span>
                @elseif($order->status === 'cancelled')
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#FEE2E2] text-[#B91C1C] font-semibold text-[11px]">
                        Dibatalkan
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full bg-[#F5C6C6] text-[#B93838] font-semibold text-[11px]">
                        Belum Bayar ({{ $paymentMethodLabel }})
                    </span>
                @endif
            </div>
        </div>

        <!-- 4-Step Progress Stepper -->
        <div class="mt-8 sm:mt-10 px-2 sm:px-10 pb-1">
            <div class="relative">
                <!-- Background Connector Track -->
                <div class="absolute top-[20px] sm:top-[24px] left-[20px] right-[20px] sm:left-[24px] sm:right-[24px] h-[3.5px] sm:h-1 bg-[#D4D4D4] rounded-full z-0"></div>
                <!-- Active Gold Progress Bar -->
                <div class="absolute top-[20px] sm:top-[24px] left-[20px] right-[20px] sm:left-[24px] sm:right-[24px] h-[3.5px] sm:h-1 z-0">
                    <div class="h-full bg-[#F4BD22] rounded-full transition-all duration-500"
                         style="width: {{ $progressPercent }}%;"></div>
                </div>

                <!-- Step Nodes -->
                <div class="relative z-10 flex items-start justify-between">
                    @foreach($stepperSteps as $stepNum => $stepLabel)
                        @php
                            $isCompleted = $currentStep >= $stepNum;
                            $isCurrent = $currentStep === $stepNum;
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center text-base sm:text-lg font-semibold transition-all duration-300 {{ $isCurrent ? 'bg-[#F4BD22] text-[#1F2937] ring-[5px] ring-[#F4BD22]/30' : ($isCompleted ? 'bg-[#F4BD22] text-[#1F2937]' : 'bg-[#B7B7B7] text-[#3F3F46]') }}">
                                {{ $stepNum }}
                            </div>
                            <span class="mt-2.5 text-[11px] sm:text-xs text-center whitespace-nowrap {{ $isCurrent ? 'font-semibold text-[#3B5954]' : ($isCompleted ? 'font-semibold text-[#1F2937]' : 'font-medium text-[#9CA3AF]') }}">
                                {{ $stepLabel }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- COMPACT UPLOADED PROOF CARD (Shown only while awaiting admin verification) -->
    @if($order->isAwaitingPaymentVerification())
        <div class="bg-white rounded-[22px] sm:rounded-[26px] px-5 py-4 sm:px-7 sm:py-5 border border-[#E5E0D4] shadow-[0_6px_24px_rgba(30,46,43,0.04)] mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 no-print">
            <div class="flex items-center gap-3.5">
                <button type="button"
                        onclick="window.openProofLightbox()"
                        class="w-14 h-14 rounded-xl border border-gray-200 bg-gray-50 overflow-hidden shrink-0 hover:opacity-90 transition cursor-pointer"
                        title="Klik untuk memperbesar bukti pembayaran">
                    <img src="{{ $order->payment_proof }}"
                         alt="Bukti Pembayaran {{ $order->order_number }}"
                         class="w-full h-full object-cover">
                </button>
                <div>
                    <div class="flex items-center gap-2">
                        <div class="text-xs font-bold text-[#1F2937]">Bukti Pembayaran Terkirim</div>
                        <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 font-extrabold text-[10.5px] px-2.5 py-0.5 rounded-full">
                            MENUNGGU VERIFIKASI ADMIN
                        </span>
                    </div>
                    <p class="text-[11px] text-[#737373] mt-0.5">
                        @if($order->payment_proof_uploaded_at)
                            Dikirim pada {{ $order->payment_proof_uploaded_at->timezone('Asia/Makassar')->format('d M Y, H:i') }} WITA •
                        @endif
                        Menunggu konfirmasi Admin / Kasir.
                    </p>
                    @if($order->payment_proof_note)
                        <p class="text-xs text-gray-700 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 mt-1">
                            Catatan: {{ $order->payment_proof_note }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                <button type="button"
                        onclick="window.openProofLightbox()"
                        class="bg-[#F0F0F0] hover:bg-gray-200 text-[#2B302E] font-medium text-xs px-3.5 py-2 rounded-lg transition cursor-pointer">
                    Lihat Foto
                </button>
                <button type="button"
                        onclick="window.openPaymentProofModal()"
                        class="bg-[#3B5954] hover:bg-[#2F4844] text-white font-medium text-xs px-3.5 py-2 rounded-lg transition cursor-pointer">
                    Ganti Bukti
                </button>
            </div>
        </div>
    @endif

    <!-- CARD 2: INVOICE RECEIPT DETAILS -->
    <div class="bg-white rounded-[22px] sm:rounded-[26px] px-5 py-6 sm:px-8 sm:py-7 border border-[#E5E0D4] shadow-[0_6px_24px_rgba(30,46,43,0.04)] space-y-5">

        <!-- 4-Column Order Meta Info -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div class="text-left">
                <span class="text-[11px] text-[#9CA3AF] font-normal block">Tipe Pesanan</span>
                <span class="text-xs sm:text-[13px] font-bold text-[#1F2937] mt-0.5 block">
                    {{ $orderTypeLabel }}
                </span>
            </div>
            <div class="sm:text-center">
                <span class="text-[11px] text-[#9CA3AF] font-normal block">Nama Pemesan</span>
                <span class="text-xs sm:text-[13px] font-bold text-[#1F2937] mt-0.5 block">
                    {{ $order->customer_name }}
                </span>
            </div>
            <div class="sm:text-center">
                <span class="text-[11px] text-[#9CA3AF] font-normal block">No. Telepon</span>
                <span class="text-xs sm:text-[13px] font-bold text-[#1F2937] mt-0.5 block">
                    {{ $order->customer_phone }}
                </span>
            </div>
            <div class="sm:text-right">
                <span class="text-[11px] text-[#9CA3AF] font-normal block">Metode Pembayaran</span>
                <span class="text-xs sm:text-[13px] font-bold text-[#1F2937] mt-0.5 block">
                    {{ $paymentMethodLabel }}
                </span>
            </div>
        </div>

        <!-- Catatan Pesanan Box -->
        <div class="bg-[#F0F0F0] rounded-xl px-4 py-3.5 text-left">
            <span class="block text-xs font-bold text-[#1F2937]">Catatan Pesanan</span>
            <p class="text-xs text-[#737373] mt-1 leading-relaxed">
                {{ $displayOrderNote !== '' ? $displayOrderNote : 'Tidak ada catatan pesanan' }}
            </p>
        </div>

        @if($order->delivery_address)
            <div class="bg-[#F0F0F0] rounded-xl px-4 py-3.5 text-left">
                <span class="block text-xs font-bold text-[#1F2937]">Alamat Pengiriman</span>
                <p class="text-xs text-[#737373] mt-1 leading-relaxed">{{ $order->delivery_address }}</p>
            </div>
        @endif

        <!-- Rincian Pesanan -->
        <div>
            <h4 class="text-xs font-semibold text-[#1F2937] mb-2.5">Rincian Pesanan</h4>
            <div class="space-y-2.5">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between gap-4 px-4 py-3.5 rounded-xl bg-[#F0F0F0] text-xs">
                        <div class="flex-1 min-w-0">
                            <h5 class="font-bold text-[#1F2937] text-xs sm:text-[13px] leading-snug">{{ $item->product_name }}</h5>
                            <span class="text-[11px] sm:text-xs text-[#8C8C8C] font-normal block mt-0.5">
                                {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>

                            @if($item->options->isNotEmpty())
                                <div class="mt-1.5 flex flex-wrap gap-1">
                                    @foreach($item->options as $opt)
                                        <span class="bg-white px-2 py-0.5 rounded border border-gray-200 text-[10px] text-gray-600">
                                            + {{ $opt->option_value_name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            @if($showIndividualItemNotes && $item->notes)
                                <div class="text-[11px] text-[#737373] italic mt-1">Catatan: "{{ $item->notes }}"</div>
                            @endif

                            @if($order->status === 'completed' && $item->product_id)
                                <div class="mt-2 no-print">
                                    <button type="button"
                                            data-product-name="{{ $item->product_name }}"
                                            onclick="openReviewModal({{ (int) $item->product_id }}, this.dataset.productName)"
                                            class="text-[11px] font-semibold text-[#3B5954] hover:underline inline-flex items-center gap-1 cursor-pointer">
                                        Beri Ulasan Menu Ini
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div class="font-bold text-[#1F2937] text-xs sm:text-[13px] whitespace-nowrap shrink-0">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Totals Breakdown -->
        <div class="pt-2 space-y-2 text-xs sm:text-[13px]">
            <div class="flex items-center justify-between text-[#737373]">
                <span>Subtotal Menu:</span>
                <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="flex items-center justify-between text-[#2F855A] font-medium">
                    <span>Diskon Promo / Kupon:</span>
                    <span>- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                </div>
            @endif
            <div class="flex items-center justify-between text-[#737373]">
                <span>Pajak PPN (11%):</span>
                <span class="font-medium">Rp {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex items-center justify-between pt-3.5 mt-3 border-t border-[#E5E7EB] text-sm sm:text-[15px] font-bold text-[#1F2937]">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

    </div>

</div>

<!-- QRIS PAYMENT MODAL (Static fallback when Midtrans gateway keys are not configured) -->
<div id="qris-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs hidden" data-auto-open-qris="{{ (empty($midtransConfigured) && $order->payment_method === 'qris' && $order->payment_status !== 'paid' && $order->status !== 'cancelled' && !$order->hasPaymentProof()) ? 'true' : 'false' }}">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 text-center shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
            <div class="text-left">
                <span class="font-black text-sm text-gray-900 block">Pembayaran QRIS</span>
                <span class="text-[11px] text-gray-500 font-medium">Merchant: Hugo (NMID: ID1026551937497)</span>
            </div>
            <button type="button" onclick="document.getElementById('qris-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center font-medium text-lg transition cursor-pointer">&times;</button>
        </div>
        
        <!-- 5 MINUTE COUNTDOWN TIMER BADGE -->
        <div class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-700 px-4 py-1.5 rounded-full text-xs font-bold shadow-xs">
            <svg class="w-4 h-4 text-red-600 animate-spin" style="animation-duration: 3s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="32" stroke-dashoffset="10"></circle>
            </svg>
            <span>Sisa Waktu Pembayaran: <strong id="qris-timer-display" class="font-mono text-red-800 text-sm">05:00</strong></span>
        </div>

        <!-- QRIS IMAGE BOX -->
        <div class="relative bg-white p-2 rounded-2xl border-2 border-gray-200 inline-block shadow-sm w-full max-w-[270px] mx-auto">
            <img id="qris-barcode-img" src="{{ asset('images/qris.png') }}" alt="QRIS Hugo" class="w-full h-auto max-h-[280px] mx-auto object-contain rounded-xl">
            <div id="qris-expired-overlay" class="absolute inset-0 bg-white/90 backdrop-blur-xs rounded-2xl flex-col items-center justify-center p-4 hidden">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-xl mb-2">!</div>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Waktu Pembayaran Habis</h4>
                <p class="text-xs text-gray-500 mb-3">Sesi pembayaran QRIS 5 menit telah berakhir.</p>
                <button type="button" onclick="restartQrisTimer()" class="bg-gray-900 text-white font-medium text-xs px-4 py-2 rounded-xl cursor-pointer">Muat Ulang Timer</button>
            </div>
        </div>

        <div class="bg-amber-50 rounded-2xl p-3 border border-amber-200/70 text-left space-y-1">
            <div class="flex justify-between items-center text-xs">
                <span class="text-gray-600 font-medium">Total yang harus dibayar:</span>
                <span class="text-bites-red font-black text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <p class="text-[11px] text-gray-500">
                Buka aplikasi m-Banking (BCA, Mandiri, BRI, BNI) atau E-Wallet (GoPay, OVO, Dana, ShopeePay), scan QRIS di atas, lalu unggah bukti transfer di bawah ini.
            </p>
        </div>

        <div class="space-y-2.5">
            @include('orders.partials.payment-proof-form', [
                'order' => $order,
                'prefix' => 'qris',
                'submitLabel' => 'Kirim Bukti Pembayaran',
            ])
            <p class="text-[11px] text-gray-500">
                Status pesanan akan otomatis berubah menjadi <strong>LUNAS</strong> setelah diverifikasi oleh Admin / Kasir.
            </p>
        </div>
    </div>
</div>

<!-- DIRECT PAYMENT PROOF UPLOAD MODAL (Non-QRIS methods & re-upload) -->
<div id="payment-proof-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-xs hidden" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between pb-2 border-b border-gray-100">
            <div class="text-left">
                <span class="font-black text-sm text-gray-900 block">Upload Bukti Pembayaran</span>
                <span class="text-[11px] text-gray-500 font-medium">Pesanan {{ $order->order_number }} • {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</span>
            </div>
            <button type="button" onclick="document.getElementById('payment-proof-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center font-medium text-lg transition cursor-pointer">&times;</button>
        </div>

        <div class="bg-amber-50 rounded-2xl p-3 border border-amber-200/70 text-left space-y-1">
            <div class="flex justify-between items-center text-xs">
                <span class="text-gray-600 font-medium">Total Pembayaran:</span>
                <span class="text-bites-red font-black text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <p class="text-[11px] text-gray-500">
                Bukti transfer akan langsung masuk ke sistem Admin Toon Burger tanpa perlu mengirim lewat WhatsApp.
            </p>
        </div>

        @include('orders.partials.payment-proof-form', [
            'order' => $order,
            'prefix' => 'modal',
            'submitLabel' => 'Kirim Bukti Pembayaran',
        ])
    </div>
</div>

@if($order->hasPaymentProof())
<!-- PROOF IMAGE LIGHTBOX -->
<div id="proof-lightbox-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-xs hidden" onclick="if(event.target === this) this.classList.add('hidden')">
    <div class="relative max-w-lg w-full bg-white rounded-3xl p-4 shadow-2xl space-y-3">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-gray-900">Bukti Pembayaran #{{ $order->order_number }}</span>
            <button type="button" onclick="document.getElementById('proof-lightbox-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 flex items-center justify-center text-lg font-medium cursor-pointer">&times;</button>
        </div>
        <img src="{{ $order->payment_proof }}" alt="Bukti Pembayaran" class="w-full max-h-[75vh] object-contain rounded-2xl bg-gray-50 border border-gray-100">
    </div>
</div>
@endif

<!-- REVIEW MODAL -->
<div id="review-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="font-black text-sm text-gray-900">Beri Ulasan Menu</h3>
            <button type="button" onclick="document.getElementById('review-modal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center text-lg font-semibold cursor-pointer transition" aria-label="Tutup">&times;</button>
        </div>

        <form action="{{ route('orders.review', $order->order_number) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="product_id" id="review-product-id">

            <div>
                <h4 id="review-product-name" class="font-bold text-xs text-gray-800 mb-2">Nama Menu</h4>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Rating Penilaian (1 - 5):</label>
                <select name="rating" required class="w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 text-xs font-bold text-amber-600 focus:outline-none">
                    <option value="5">Bintang 5 (Sangat Enak & Puas)</option>
                    <option value="4">Bintang 4 (Enak & Sesuai)</option>
                    <option value="3">Bintang 3 (Cukup Baik)</option>
                    <option value="2">Bintang 2 (Kurang Sesuai)</option>
                    <option value="1">Bintang 1 (Mengecewakan)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Komentar & Saran:</label>
                <textarea name="comment" rows="3" placeholder="Ceritakan rasa burger atau kemasan Toon Burger..." class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-xs focus:outline-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-medium text-xs py-3 rounded-xl transition">
                Kirim Ulasan
            </button>
        </form>
    </div>
</div>
</div>
@endsection

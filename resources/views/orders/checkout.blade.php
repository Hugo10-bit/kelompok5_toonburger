@extends('layouts.app')

@section('title', 'Checkout Pesanan - Toon Burger')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-6">
        <a href="{{ route('menu') }}" class="text-xs text-gray-500 hover:text-bites-red font-semibold inline-flex items-center gap-1">
            &larr; Kembali ke Katalog Menu
        </a>
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1">Konfirmasi &amp; Pembayaran</h1>
        <p class="text-xs text-gray-500">Lengkapi detail pemesanan dan pilih metode pembayaran favorit Anda.</p>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT FORM: CUSTOMER & ORDER DETAILS -->
            <div class="lg:col-span-7 space-y-6">

                <!-- 1. ORDER TYPE SELECTOR (TAKEAWAY & DELIVERY ONLY) -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-black text-sm text-gray-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-bites-yellow text-bites-dark text-xs flex items-center justify-center font-bold">1</span>
                            Pilih Tipe Pesanan
                        </h3>
                        <span class="bg-amber-100 text-amber-900 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">
                            No Dine-In
                        </span>
                    </div>

                    <div class="bg-amber-50/80 border border-amber-200/80 text-amber-950 text-xs px-3.5 py-2.5 rounded-2xl flex items-center gap-2.5 font-medium">
                        <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Outlet Toon Burger berkonsep <strong>Cloud Kitchen &amp; Takeaway Hub</strong>. Kami hanya melayani <strong>Takeaway</strong> dan <strong>Delivery</strong> (tidak tersedia makan di tempat).</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="border-2 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer transition select-none hover:border-bites-orange border-bites-orange bg-amber-50/40" id="type-card-takeaway">
                            <input type="radio" name="order_type" value="takeaway" checked onchange="handleOrderTypeChange('takeaway')" class="sr-only">
                            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center mb-1.5 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <span class="font-extrabold text-xs text-gray-900">Takeaway (Bawa Pulang)</span>
                            <span class="text-[10px] text-gray-500 mt-0.5">Ambil pesanan di outlet Banjarbaru</span>
                        </label>

                        <label class="border-2 border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center text-center cursor-pointer transition select-none hover:border-bites-orange" id="type-card-delivery">
                            <input type="radio" name="order_type" value="delivery" onchange="handleOrderTypeChange('delivery')" class="sr-only">
                            <div class="w-10 h-10 rounded-xl bg-red-600 text-white flex items-center justify-center mb-1.5 shadow-2xs">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                            </div>
                            <span class="font-extrabold text-xs text-gray-900">Online Delivery</span>
                            <span class="text-[10px] text-gray-500 mt-0.5">Diantar kurir langsung ke alamat Anda</span>
                        </label>
                    </div>

                    <!-- Dynamic Field: Delivery Address -->
                    <div id="delivery-address-section" class="pt-3 border-t border-gray-100 hidden">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Alamat Lengkap Pengiriman:</label>
                        <textarea name="delivery_address" rows="2" placeholder="Nama Jalan, No. Rumah, RT/RW, Patokan..." class="w-full bg-gray-50 border border-gray-300 rounded-xl p-3 text-xs focus:outline-none focus:border-bites-orange">{{ Auth::user()->address ?? '' }}</textarea>
                    </div>
                </div>

                <!-- 2. CUSTOMER CONTACT INFO -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs space-y-4">
                    <h3 class="font-black text-sm text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-bites-yellow text-bites-dark text-xs flex items-center justify-center font-bold">2</span>
                        Informasi Pemesan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">Nama Pemesan:</label>
                            <input type="text" name="customer_name" value="{{ Auth::user()->name ?? Auth::user()->username ?? '' }}" required placeholder="Contoh: Budi Santoso" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-bites-orange font-medium">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">No. WhatsApp / Telepon:</label>
                            <input type="tel" name="customer_phone" value="{{ Auth::user()->phone_number ?? '081234567890' }}" required placeholder="Contoh: 081234567890" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-bites-orange font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan untuk Pesanan (Opsional):</label>
                        <input type="text" name="notes" placeholder="Contoh: Tolong bungkus terpisah, extra saus sambal..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3.5 py-2.5 text-xs focus:outline-none focus:border-bites-orange">
                    </div>
                </div>

                <!-- 3. PAYMENT METHOD SELECTION -->
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-xs space-y-4">
                    <h3 class="font-black text-sm text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-bites-yellow text-bites-dark text-xs flex items-center justify-center font-bold">3</span>
                        Metode Pembayaran
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="border-2 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition select-none hover:border-bites-orange border-bites-orange bg-amber-50/40" id="pay-card-qris">
                            <input type="radio" name="payment_method" value="qris" checked onchange="handlePaymentChange('qris')" class="text-bites-orange focus:ring-bites-orange">
                            <div>
                                <div class="font-bold text-xs text-gray-900 flex items-center gap-1.5">
                                    <span>QRIS Instant</span>
                                    <span class="bg-green-100 text-green-700 text-[10px] font-bold px-1.5 py-0.2 rounded">Otomatis</span>
                                </div>
                                <div class="text-[11px] text-gray-500">GoPay, OVO, Dana, BCA, ShopeePay</div>
                            </div>
                        </label>

                        <label class="border-2 border-gray-200 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition select-none hover:border-bites-orange" id="pay-card-cash">
                            <input type="radio" name="payment_method" value="cash" onchange="handlePaymentChange('cash')" class="text-bites-orange focus:ring-bites-orange">
                            <div>
                                <div class="font-bold text-xs text-gray-900">Tunai di Kasir</div>
                                <div class="text-[11px] text-gray-500">Bayar langsung saat pesanan disiapkan</div>
                            </div>
                        </label>

                        <label class="border-2 border-gray-200 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition select-none hover:border-bites-orange" id="pay-card-bank">
                            <input type="radio" name="payment_method" value="bank_transfer" onchange="handlePaymentChange('bank_transfer')" class="text-bites-orange focus:ring-bites-orange">
                            <div>
                                <div class="font-bold text-xs text-gray-900">Transfer Bank</div>
                                <div class="text-[11px] text-gray-500">BCA / Mandiri Virtual Account</div>
                            </div>
                        </label>

                        <label class="border-2 border-gray-200 rounded-2xl p-4 flex items-center gap-3 cursor-pointer transition select-none hover:border-bites-orange" id="pay-card-ewallet">
                            <input type="radio" name="payment_method" value="ewallet" onchange="handlePaymentChange('ewallet')" class="text-bites-orange focus:ring-bites-orange">
                            <div>
                                <div class="font-bold text-xs text-gray-900">E-Wallet</div>
                                <div class="text-[11px] text-gray-500">Direct wallet checkout</div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- RIGHT COLUMN: ORDER SUMMARY -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl p-6 border border-gray-200/80 shadow-lg sticky top-24 space-y-5">
                    <h3 class="font-black text-base text-gray-900 pb-3 border-b border-gray-100 flex items-center justify-between">
                        <span>Ringkasan Pesanan</span>
                        <span class="text-xs bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full font-bold">
                            {{ $cart['item_count'] }} Item
                        </span>
                    </h3>

                    <!-- Item List -->
                    <div class="max-h-60 overflow-y-auto space-y-3 pr-1">
                        @foreach($cart['items'] as $item)
                            <div class="flex items-center gap-3 text-xs">
                                <img src="{{ asset($item['image'] ?: 'images/burger-bg.jpg') }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded-xl border border-gray-200 flex-shrink-0">
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-gray-900 truncate">{{ $item['name'] }}</div>
                                    <div class="text-[11px] text-gray-500 font-semibold">{{ $item['quantity'] }}x @ Rp {{ number_format($item['unit_price'], 0, ',', '.') }}</div>
                                    @if(!empty($item['options']))
                                        <div class="text-[10px] text-gray-400 truncate">
                                            {{ implode(', ', array_column($item['options'], 'value_name')) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="font-black text-gray-900">
                                    Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Voucher Applied Info -->
                    @if($cart['coupon'])
                        <div class="bg-green-50 text-green-800 text-xs p-3 rounded-xl border border-green-200 flex items-center justify-between font-bold">
                            <span>Voucher Aktif: {{ $cart['coupon']['code'] }}</span>
                            <span>- Rp {{ number_format($cart['discount'], 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <!-- Price Calculations -->
                    <div class="space-y-2 text-xs text-gray-600 pt-3 border-t border-gray-100">
                        <div class="flex justify-between">
                            <span>Subtotal Menu:</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($cart['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Diskon Voucher:</span>
                            <span class="font-semibold">- Rp {{ number_format($cart['discount'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Pajak Restoran PB1 (10%):</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($cart['tax'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-base font-black text-gray-900 pt-3 border-t border-gray-200">
                            <span>Total Tagihan:</span>
                            <span class="text-bites-red font-black text-lg">Rp {{ number_format($cart['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-black py-4 rounded-2xl flex items-center justify-center gap-2 shadow-lg transition active:scale-98 text-sm">
                        <span>Buat Pesanan Sekarang</span>
                        <span>&rarr;</span>
                    </button>

                    <p class="text-[11px] text-gray-400 text-center">
                        Pesanan Anda langsung diteruskan ke sistem dapur Toon Burger.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    function handleOrderTypeChange(type) {
        document.querySelectorAll('[id^="type-card-"]').forEach(el => {
            el.classList.remove('border-bites-orange', 'bg-amber-50/40');
            el.classList.add('border-gray-200');
        });
        const activeCard = document.getElementById('type-card-' + type);
        if (activeCard) {
            activeCard.classList.add('border-bites-orange', 'bg-amber-50/40');
            activeCard.classList.remove('border-gray-200');
        }

        const deliverySec = document.getElementById('delivery-address-section');
        if (deliverySec) {
            if (type === 'delivery') {
                deliverySec.classList.remove('hidden');
            } else {
                deliverySec.classList.add('hidden');
            }
        }
    }

    function handlePaymentChange(method) {
        document.querySelectorAll('[id^="pay-card-"]').forEach(el => {
            el.classList.remove('border-bites-orange', 'bg-amber-50/40');
            el.classList.add('border-gray-200');
        });
        const activePay = document.getElementById('pay-card-' + method);
        if (activePay) {
            activePay.classList.add('border-bites-orange', 'bg-amber-50/40');
            activePay.classList.remove('border-gray-200');
        }
    }

    handleOrderTypeChange('takeaway');
</script>
@endsection

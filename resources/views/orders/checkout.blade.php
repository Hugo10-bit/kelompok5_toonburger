@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Toon Burger')
@section('footer_bg', 'orders-dot-bg')

@section('content')
<div class="orders-dot-bg min-h-screen -mt-[88px] sm:-mt-[96px] pt-[112px] sm:pt-[124px] pb-14 sm:pb-20">
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Top Breadcrumb -->
    <div class="mb-2">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-800 transition font-medium">
            <span>&lsaquo;</span>
            <span>Kembali Ke Beranda</span>
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-7 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-[34px] font-brand uppercase text-[#27443E] tracking-wide leading-tight"
            style="font-family: 'Luckiest Guy', cursive, sans-serif;">
            KONFIRMASI PEMBAYARAN
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Lengkapi detail pemesanan dan pilih metode pembayaran Anda
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-2xl flex items-center justify-between shadow-2xs">
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="order_type" value="takeaway">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            <!-- LEFT COLUMN: INFORMASI PEMESAN & PILIH METODE PEMBAYARAN -->
            <div class="lg:col-span-7 space-y-6">

                <!-- 1. INFORMASI PEMESAN CARD -->
                <div class="bg-white rounded-[24px] border border-gray-200/90 shadow-2xs p-6 sm:p-7">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-[#E5A93C] text-black text-xs font-black flex items-center justify-center shrink-0 select-none">
                            1
                        </span>
                        <h2 class="font-bold text-sm sm:text-base text-gray-900">
                            Informasi Pemesan
                        </h2>
                    </div>

                    <div class="border-b border-gray-200/90 my-4 sm:my-5"></div>

                    <div class="space-y-4">
                        <div>
                            <label for="customer_name" class="block text-xs font-bold text-gray-800 mb-1.5">
                                Nama Lengkap
                            </label>
                            <input type="text"
                                   id="customer_name"
                                   name="customer_name"
                                   required
                                   value="{{ Auth::user()->name ?? Auth::user()->username ?? '' }}"
                                   placeholder="Nama Lengkap Anda"
                                   class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] transition">
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-xs font-bold text-gray-800 mb-1.5">
                                Nomor Telfon
                            </label>
                            <input type="tel"
                                   id="customer_phone"
                                   name="customer_phone"
                                   required
                                   value="{{ Auth::user()->phone_number ?? '' }}"
                                   placeholder="Nomor Telfon Anda"
                                   class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] transition">
                        </div>

                        <div>
                            <label for="notes" class="block text-xs font-bold text-gray-800 mb-1.5">
                                Catatan Pesanan
                            </label>
                            <textarea id="notes"
                                      name="notes"
                                      rows="3"
                                      placeholder="Contoh: saus dipisah, tanpa selada..."
                                      class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] transition resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. PILIH METODE PEMBAYARAN CARD -->
                <div class="bg-white rounded-[24px] border border-gray-200/90 shadow-2xs p-6 sm:p-7">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded-full bg-[#E5A93C] text-black text-xs font-black flex items-center justify-center shrink-0 select-none">
                            2
                        </span>
                        <h2 class="font-bold text-sm sm:text-base text-gray-900">
                            Pilih Metode Pembayaran
                        </h2>
                    </div>

                    <div class="border-b border-gray-200/90 my-4 sm:my-5"></div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <!-- QRIS -->
                        <label class="relative flex items-center gap-3 p-4 rounded-2xl border border-gray-200 cursor-pointer transition select-none hover:border-gray-300 has-[:checked]:border-[#27443E] has-[:checked]:ring-1 has-[:checked]:ring-[#27443E]">
                            <input type="radio"
                                   name="payment_method"
                                   value="qris"
                                   checked
                                   class="text-[#27443E] focus:ring-[#27443E] accent-[#27443E] w-4 h-4 cursor-pointer">
                            <div>
                                <div class="font-bold text-xs sm:text-[13px] text-gray-900 leading-snug">QRIS</div>
                                <div class="text-[11px] text-gray-400 mt-0.5 leading-tight">Gopay, OVO, Dana, Bca, Shopeepay</div>
                            </div>
                        </label>

                        <!-- Tunai -->
                        <label class="relative flex items-center gap-3 p-4 rounded-2xl border border-gray-200 cursor-pointer transition select-none hover:border-gray-300 has-[:checked]:border-[#27443E] has-[:checked]:ring-1 has-[:checked]:ring-[#27443E]">
                            <input type="radio"
                                   name="payment_method"
                                   value="cash"
                                   class="text-[#27443E] focus:ring-[#27443E] accent-[#27443E] w-4 h-4 cursor-pointer">
                            <div>
                                <div class="font-bold text-xs sm:text-[13px] text-gray-900 leading-snug">Tunai</div>
                                <div class="text-[11px] text-gray-400 mt-0.5 leading-tight">Bayar langsung dikasir</div>
                            </div>
                        </label>

                        <!-- Transfer Bank -->
                        <label class="relative flex items-center gap-3 p-4 rounded-2xl border border-gray-200 cursor-pointer transition select-none hover:border-gray-300 has-[:checked]:border-[#27443E] has-[:checked]:ring-1 has-[:checked]:ring-[#27443E]">
                            <input type="radio"
                                   name="payment_method"
                                   value="bank_transfer"
                                   class="text-[#27443E] focus:ring-[#27443E] accent-[#27443E] w-4 h-4 cursor-pointer">
                            <div>
                                <div class="font-bold text-xs sm:text-[13px] text-gray-900 leading-snug">Transfer Bank</div>
                                <div class="text-[11px] text-gray-400 mt-0.5 leading-tight">BCA/ Mandiri Virtual Account</div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="relative flex items-center gap-3 p-4 rounded-2xl border border-gray-200 cursor-pointer transition select-none hover:border-gray-300 has-[:checked]:border-[#27443E] has-[:checked]:ring-1 has-[:checked]:ring-[#27443E]">
                            <input type="radio"
                                   name="payment_method"
                                   value="ewallet"
                                   class="text-[#27443E] focus:ring-[#27443E] accent-[#27443E] w-4 h-4 cursor-pointer">
                            <div>
                                <div class="font-bold text-xs sm:text-[13px] text-gray-900 leading-snug">E-Wallet</div>
                                <div class="text-[11px] text-gray-400 mt-0.5 leading-tight">Gopay, OVO, Dana, Shopeepay</div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            <!-- ═══ RIGHT COLUMN: RINGKASAN PESANAN ═══ -->
            <div class="lg:col-span-5">
                <div class="bg-white rounded-[24px] border border-gray-200/90 shadow-2xs p-6 sm:p-7 sticky top-28">
                    <h2 class="font-bold text-sm sm:text-base text-gray-900">
                        Ringkasan Pesanan
                    </h2>

                    <div class="border-b border-gray-200/90 my-4"></div>

                    @php
                        $palettes = ['#FFC83B', '#FED7AA', '#E51D1D', '#A4D477', '#BFE1FD', '#F67A24', '#D5C8F6', '#F5B8DC'];
                    @endphp

                    <!-- Items List -->
                    <div class="space-y-4 max-h-[320px] overflow-y-auto pr-1">
                        @forelse($cart['items'] as $index => $item)
                            @php
                                $bgColor = $palettes[$index % count($palettes)];
                            @endphp
                            <div class="flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl flex items-center justify-center shrink-0 overflow-hidden p-1.5"
                                         style="background-color: {{ $bgColor }};">
                                        <img src="{{ asset($item['image'] ?: 'images/burger-bg.jpg') }}"
                                             alt="{{ $item['name'] }}"
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-xs sm:text-[13px] text-gray-900 truncate leading-snug">
                                            {{ $item['name'] }}
                                        </h3>
                                        <div class="text-[11px] text-gray-500 font-medium mt-0.5">
                                            Rp {{ number_format($item['unit_price'], 0, ',', '.') }} (x{{ $item['quantity'] }})
                                        </div>
                                        <div class="inline-flex items-center border border-gray-200 rounded-md bg-white px-2 py-0.5 gap-2.5 mt-1.5 shadow-2xs">
                                            <button type="button"
                                                    onclick="updateCheckoutQty('{{ $item['cart_key'] }}', {{ $item['quantity'] - 1 }})"
                                                    class="text-gray-500 hover:text-gray-900 font-bold text-xs cursor-pointer select-none"
                                                    aria-label="Kurangi jumlah">&minus;</button>
                                            <span class="text-[11px] font-bold text-gray-900 select-none">{{ $item['quantity'] }}</span>
                                            <button type="button"
                                                    onclick="updateCheckoutQty('{{ $item['cart_key'] }}', {{ $item['quantity'] + 1 }})"
                                                    class="text-gray-500 hover:text-gray-900 font-bold text-xs cursor-pointer select-none"
                                                    aria-label="Tambah jumlah">&plus;</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="font-bold text-xs sm:text-[13px] text-gray-900 text-right whitespace-nowrap">
                                    Rp {{ number_format($item['total_price'], 0, ',', '.') }}
                                </div>
                            </div>
                        @empty
                            <div class="py-6 text-center text-xs text-gray-400">
                                Keranjang kosong
                            </div>
                        @endforelse
                    </div>

                    <!-- Summary Box matching Mockup -->
                    <div class="bg-[#F8F9FA] rounded-2xl p-4 sm:p-5 mt-5 space-y-2.5">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">Subtotal Menu:</span>
                            <span class="font-semibold text-gray-900 text-xs sm:text-[13px]">
                                Rp {{ number_format($cart['subtotal'], 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">Pajak PPN (11%)</span>
                            <span class="font-semibold text-gray-900 text-xs sm:text-[13px]">
                                Rp {{ number_format($cart['tax'], 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="border-t border-gray-200/90 pt-2.5 mt-2 flex justify-between items-center text-xs sm:text-sm font-bold text-gray-900">
                            <span>Total Tagihan:</span>
                            <span class="font-bold text-sm sm:text-base text-gray-900">
                                Rp {{ number_format($cart['total'], 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Button -->
                    <button type="submit"
                            class="w-full mt-5 bg-[#385850] hover:bg-[#2C463F] active:scale-[0.99] text-white font-bold text-xs sm:text-sm py-3.5 rounded-xl transition shadow-xs cursor-pointer flex items-center justify-center">
                        Buat Pesanan Sekarang
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>
</div>
@endsection

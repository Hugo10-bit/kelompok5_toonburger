@extends('layouts.app')

@section('title', 'Riwayat Pesanan Saya - Toon Burger')
@section('footer_bg', 'orders-dot-bg')

@section('content')
@php
    $currentSort = $sort ?? request('sort', 'latest');
    $nextSort = $currentSort === 'oldest' ? 'latest' : 'oldest';
    $productsMap = $productsByName ?? collect();
    $thumbPalettes = ['#FED638', '#FEC2E6', '#E51D1D', '#2C3E50', '#3B5953', '#BFE1FD', '#FFE3BE', '#A4D477'];

    $resolveItemThumb = function ($item, $idx) use ($productsMap, $thumbPalettes) {
        $prod = $item->product ?? $productsMap->get(strtolower(trim((string) $item->product_name)));
        $img = $prod?->image ?: 'images/burger-bg.jpg';
        $nameLower = strtolower((string) $item->product_name);

        if (str_contains($nameLower, 'very cheese')) {
            $bg = '#FED638';
        } elseif (str_contains($nameLower, 'hot chicken')) {
            $bg = '#FEC2E6';
        } elseif (str_contains($nameLower, 'bbq beef')) {
            $bg = '#E51D1D';
        } elseif (str_contains($nameLower, 'wing')) {
            $bg = '#2C3E50';
        } elseif (str_contains($nameLower, 'fries') || str_contains($nameLower, 'kentang')) {
            $bg = '#3B5953';
        } elseif (str_contains($nameLower, 'cheese chicken')) {
            $bg = '#FFE3BE';
        } elseif (str_contains($nameLower, 'double cheese')) {
            $bg = '#A4D477';
        } elseif (str_contains($nameLower, 'cheese burger')) {
            $bg = '#BFE1FD';
        } else {
            $bg = $thumbPalettes[$idx % count($thumbPalettes)];
        }

        return ['img' => $img, 'bg' => $bg];
    };
@endphp

<div class="orders-dot-bg min-h-screen -mt-[88px] sm:-mt-[96px] pt-[112px] sm:pt-[128px] pb-14 sm:pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-medium text-gray-500 hover:text-[#27443E] transition mb-1.5">
            <span>&lsaquo;</span>
            <span>Kembali Ke Beranda</span>
        </a>

        <!-- Header & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6 sm:mb-7">
            <div>
                <h1 class="font-brand text-2xl sm:text-3xl lg:text-[34px] text-[#35524D] uppercase tracking-wide leading-tight"
                    style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive, sans-serif;">
                    RIWAYAT PESANAN
                </h1>
                <p class="text-xs sm:text-[13px] text-gray-500 mt-1">
                    Daftar semua transaksi dan pesanan yang pernah Anda buat di Toon Burger.
                </p>
            </div>

            <div class="flex items-center gap-2.5 self-start sm:self-end shrink-0">
                <a href="{{ route('orders.index', ['sort' => $nextSort]) }}"
                   title="{{ $currentSort === 'oldest' ? 'Urutkan Terbaru' : 'Urutkan Terlama' }}"
                   class="bg-white hover:bg-gray-50 text-gray-700 border border-gray-400/90 font-medium text-xs px-3.5 py-2 min-h-[36px] rounded-lg transition inline-flex items-center gap-1.5 shadow-2xs cursor-pointer">
                    <svg class="w-3.5 h-3.5 text-gray-700 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 4v16m0 0l-3-3m3 3l3-3"/>
                        <path d="M15 10l2-5 2 5M15.6 8.5h2.8"/>
                        <path d="M15 15h4l-4 5h4"/>
                    </svg>
                    <span>Sortir</span>
                </a>

                <a href="{{ route('menu') }}"
                   class="bg-[#385652] hover:bg-[#2B4440] text-white font-medium text-xs px-4 py-2 min-h-[36px] rounded-lg transition inline-flex items-center justify-center shadow-2xs cursor-pointer">
                    <span>Pesan Lagi</span>
                </a>
            </div>
        </div>

        @if($orders->isEmpty() || request()->has('empty'))
            <div class="bg-white rounded-[22px] sm:rounded-[26px] border border-gray-400/80 shadow-[0_3px_0px_rgba(0,0,0,0.2)] p-10 sm:p-14 text-center">
                <img src="{{ asset('images/empty-order.png') }}"
                     alt="Belum Ada Riwayat Pesanan"
                     width="170"
                     height="158"
                     loading="lazy"
                     class="w-36 sm:w-40 h-auto mx-auto mb-4 object-contain">
                <h3 class="text-lg sm:text-xl font-bold text-gray-900">Belum Ada Riwayat Pesanan</h3>
                <p class="text-xs sm:text-sm text-gray-500 mt-1.5 max-w-sm mx-auto leading-relaxed">
                    Anda belum pernah melakukan pemesanan di Toon Burger. Yuk, pesan burger favoritmu sekarang!
                </p>
                <a href="{{ route('menu') }}" class="inline-flex items-center justify-center mt-5 bg-[#385652] hover:bg-[#2B4440] text-white font-medium text-xs px-5 py-2.5 rounded-lg shadow-xs transition">
                    Mulai Pesan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-4 sm:space-y-5">
                @foreach($orders as $order)
                    <div class="bg-white rounded-[20px] sm:rounded-[24px] border border-gray-400/80 shadow-[0_3px_0px_rgba(0,0,0,0.22)] px-5 py-4 sm:px-7 sm:py-5 transition hover:shadow-[0_4px_0px_rgba(56,86,82,0.32)]">
                        <!-- Card Header: Order Number & Date -->
                        <div class="border-b border-gray-200/90 pb-3 sm:pb-3.5 mb-3.5 sm:mb-4">
                            <div class="text-xs sm:text-[13px] font-bold text-gray-800 tracking-wide">
                                {{ $order->order_number }}
                            </div>
                            <div class="text-[11px] text-gray-400 mt-0.5">
                                {{ $order->created_at->timezone('Asia/Makassar')->translatedFormat('d M Y, H:i') }} WITA
                            </div>
                        </div>

                        <!-- Card Body: Ordered Items -->
                        <div class="space-y-3 sm:space-y-3.5">
                            @foreach($order->items as $itemIdx => $item)
                                @php
                                    $thumb = $resolveItemThumb($item, $itemIdx);
                                    $lineTotal = $item->subtotal ?: ($item->price * $item->quantity);
                                @endphp
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 sm:gap-3.5 min-w-0 flex-1">
                                        <div class="tb-skeleton-img-wrap is-loading w-11 h-11 sm:w-12 sm:h-12 rounded-xl overflow-hidden flex items-center justify-center shrink-0"
                                             style="background-color: {{ $thumb['bg'] }};">
                                            <div class="tb-skeleton-img-overlay tb-skeleton" aria-hidden="true"></div>
                                            <img src="{{ \App\Services\ImageDataUriService::toAssetUrl($thumb['img'], 'images/burger-bg.jpg') }}"
                                                 alt="{{ $item->product_name }}"
                                                 data-skeleton-img
                                                 onload="this.parentElement.classList.remove('is-loading')"
                                                 onerror="this.parentElement.classList.remove('is-loading')"
                                                 width="48"
                                                 height="48"
                                                 loading="lazy"
                                                 decoding="async"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-xs sm:text-[13.5px] font-semibold text-gray-800 leading-snug break-words">
                                                {{ $item->product_name }}
                                            </h3>
                                            <p class="text-[11px] text-gray-400 mt-0.5">
                                                {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-xs sm:text-[13.5px] font-semibold text-gray-800 whitespace-nowrap pl-2">
                                        Rp {{ number_format($lineTotal, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Card Footer: Total & Buttons -->
                        <div class="border-t border-gray-200/90 pt-3 sm:pt-3.5 mt-3.5 sm:mt-4 flex items-center justify-between gap-3 flex-wrap">
                            <div>
                                <span class="block text-[10.5px] text-gray-400 leading-tight">Total Pesanan:</span>
                                <span class="text-sm sm:text-[15px] font-extrabold text-gray-900 mt-0.5 block">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex items-center gap-2 sm:gap-2.5">
                                <a href="{{ route('orders.show', $order->order_number) }}"
                                   class="px-3.5 sm:px-4 py-1.5 rounded-lg border border-gray-400/90 bg-white hover:bg-gray-50 text-gray-800 text-[11px] sm:text-xs font-medium transition cursor-pointer">
                                    Lihat Detail
                                </a>

                                <form action="{{ route('orders.reorder', $order->order_number) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="px-3.5 sm:px-4 py-1.5 rounded-lg bg-[#385652] hover:bg-[#2B4440] text-white text-[11px] sm:text-xs font-medium transition inline-flex items-center gap-1.5 cursor-pointer shadow-2xs">
                                        <span>Pesan Lagi</span>
                                        <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M21 12a9 9 0 1 1-2.64-6.36"/>
                                            <path d="M21 3v6h-6"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-3xl border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-4 sm:p-9 lg:p-10 flex-1">
    <!-- Header & Sort -->
    <div class="mb-5 sm:mb-7 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-xl sm:text-[36px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="ord_title">Proses pesanan</h1>
            <p class="text-xs sm:text-[16px] text-gray-500 dark:text-[#D4D4D4] mt-1.5" data-i18n="ord_sub">
                Kelola dan konfirmasi pesanan masuk.
                @if(($dateFilter ?? '') === 'today')
                    <span class="inline-flex items-center gap-1 font-semibold text-[#415C58] dark:text-[#6EE7B7] bg-[#415C58]/10 dark:bg-[#415C58]/30 px-2 py-0.5 rounded-md text-xs ml-1">Hari Ini</span>
                @elseif(($dateFilter ?? '') === 'yesterday')
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-[#404040] px-2 py-0.5 rounded-md text-xs ml-1">Kemarin</span>
                @elseif(($dateFilter ?? '') === 'week')
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-[#404040] px-2 py-0.5 rounded-md text-xs ml-1">7 Hari Terakhir</span>
                @elseif(($dateFilter ?? '') === 'month')
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-[#404040] px-2 py-0.5 rounded-md text-xs ml-1">Bulan Ini</span>
                @elseif(!empty($startDate) || !empty($endDate))
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-[#404040] px-2 py-0.5 rounded-md text-xs ml-1">Rentang: {{ $startDate ?: '...' }} s/d {{ $endDate ?: '...' }}</span>
                @endif
            </p>
        </div>

        <!-- Sorting selector -->
        <div class="flex items-center gap-2 self-start md:self-auto">
            <label for="order-sort-select" class="text-xs font-semibold text-gray-600 dark:text-gray-300 whitespace-nowrap">Urutan:</label>
            <select id="order-sort-select"
                    onchange="handleOrderSortChange(this.value)"
                    class="bg-white dark:bg-[#383838] border border-gray-300 dark:border-[#555555] rounded-xl px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-200 focus:ring-[#415C58] focus:border-[#415C58] cursor-pointer shadow-2xs">
                <option value="newest" {{ ($sort ?? 'newest') === 'newest' ? 'selected' : '' }}>Terbaru Masuk (Default)</option>
                <option value="oldest" {{ ($sort ?? '') === 'oldest' ? 'selected' : '' }}>Terlama Masuk (Antrian)</option>
                <option value="priority" {{ ($sort ?? '') === 'priority' ? 'selected' : '' }}>Prioritas Status (Menunggu & Dimasak Duluan)</option>
            </select>
        </div>
    </div>

    <!-- Filter Bar: Tanggal & Preset (Mendukung histori hingga bertahun-tahun) -->
    <div class="bg-[#F8F9FA] dark:bg-[#333333] border border-gray-200/90 dark:border-[#444444] rounded-2xl p-3 sm:p-4 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3.5">
        <!-- Quick Preset Pills -->
        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
            <span class="text-xs font-bold text-gray-500 dark:text-gray-400 mr-1 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Tanggal:
            </span>
            @php
                $currentQuery = request()->except(['page']);
            @endphp
            <a href="{{ route('admin.orders', array_merge($currentQuery, ['date' => 'all', 'start_date' => null, 'end_date' => null])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ ($dateFilter ?? 'all') === 'all' && empty($startDate) && empty($endDate) ? 'bg-[#415C58] text-white shadow-xs' : 'bg-white dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-[#525252] hover:bg-gray-100 dark:hover:bg-[#474747]' }}">
                Semua
            </a>
            <a href="{{ route('admin.orders', array_merge($currentQuery, ['date' => 'today', 'start_date' => null, 'end_date' => null])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ ($dateFilter ?? '') === 'today' ? 'bg-[#415C58] text-white shadow-xs' : 'bg-white dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-[#525252] hover:bg-gray-100 dark:hover:bg-[#474747]' }}">
                Hari Ini
            </a>
            <a href="{{ route('admin.orders', array_merge($currentQuery, ['date' => 'yesterday', 'start_date' => null, 'end_date' => null])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ ($dateFilter ?? '') === 'yesterday' ? 'bg-[#415C58] text-white shadow-xs' : 'bg-white dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-[#525252] hover:bg-gray-100 dark:hover:bg-[#474747]' }}">
                Kemarin
            </a>
            <a href="{{ route('admin.orders', array_merge($currentQuery, ['date' => 'week', 'start_date' => null, 'end_date' => null])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ ($dateFilter ?? '') === 'week' ? 'bg-[#415C58] text-white shadow-xs' : 'bg-white dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-[#525252] hover:bg-gray-100 dark:hover:bg-[#474747]' }}">
                7 Hari Terakhir
            </a>
            <a href="{{ route('admin.orders', array_merge($currentQuery, ['date' => 'month', 'start_date' => null, 'end_date' => null])) }}"
               class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ ($dateFilter ?? '') === 'month' ? 'bg-[#415C58] text-white shadow-xs' : 'bg-white dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-[#525252] hover:bg-gray-100 dark:hover:bg-[#474747]' }}">
                Bulan Ini
            </a>
        </div>

        <!-- Custom Date Range Form -->
        <form method="GET" action="{{ route('admin.orders') }}" class="flex flex-wrap items-center gap-2 text-xs">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            @if(request('search'))
                <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
            <input type="hidden" name="date" value="custom">

            <div class="flex items-center gap-1.5">
                <input type="date"
                       name="start_date"
                       value="{{ $startDate ?? '' }}"
                       aria-label="Dari Tanggal"
                       class="bg-white dark:bg-[#3D3D3D] border border-gray-300 dark:border-[#525252] text-gray-700 dark:text-gray-200 rounded-lg px-2.5 py-1.5 text-xs focus:ring-[#415C58] focus:border-[#415C58]">
                <span class="text-gray-400">s/d</span>
                <input type="date"
                       name="end_date"
                       value="{{ $endDate ?? '' }}"
                       aria-label="Sampai Tanggal"
                       class="bg-white dark:bg-[#3D3D3D] border border-gray-300 dark:border-[#525252] text-gray-700 dark:text-gray-200 rounded-lg px-2.5 py-1.5 text-xs focus:ring-[#415C58] focus:border-[#415C58]">
            </div>

            <button type="submit"
                    class="px-3 py-1.5 rounded-lg bg-[#415C58] hover:bg-[#344B48] text-white font-medium transition shadow-2xs cursor-pointer">
                Terapkan
            </button>

            @if(!empty($startDate) || !empty($endDate) || (($dateFilter ?? '') && $dateFilter !== 'all'))
                <a href="{{ route('admin.orders', array_merge(request()->only(['status', 'sort', 'search']))) }}"
                   class="px-2.5 py-1.5 rounded-lg border border-gray-300 dark:border-[#525252] bg-white dark:bg-[#383838] hover:bg-gray-100 dark:hover:bg-[#444444] text-gray-600 dark:text-gray-300 font-medium transition"
                   title="Reset Filter Tanggal">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Status Tabs (Mempertahankan Filter Tanggal & Sortir) -->
    <div class="flex flex-wrap items-center gap-2 sm:gap-3.5 mb-6 sm:mb-8">
        @php
            $tabQueryParams = request()->except(['page']);
        @endphp
        <a href="{{ route('admin.orders', array_merge($tabQueryParams, ['status' => null])) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 min-h-[38px] sm:min-h-[42px] rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-2 sm:gap-2.5 {{ !request('status') ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_all">Semua</span>
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full text-[11px] sm:text-xs font-bold inline-flex items-center justify-center {{ !request('status') ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countAll }}</span>
        </a>
        <a href="{{ route('admin.orders', array_merge($tabQueryParams, ['status' => 'pending'])) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 min-h-[38px] sm:min-h-[42px] rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-2 sm:gap-2.5 {{ request('status') == 'pending' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_pending">Menunggu</span>
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full text-[11px] sm:text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'pending' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countPending }}</span>
        </a>
        <a href="{{ route('admin.orders', array_merge($tabQueryParams, ['status' => 'diproses'])) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 min-h-[38px] sm:min-h-[42px] rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-2 sm:gap-2.5 {{ request('status') == 'diproses' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_cooking">Dimasak</span>
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full text-[11px] sm:text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'diproses' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countCooking }}</span>
        </a>
        <a href="{{ route('admin.orders', array_merge($tabQueryParams, ['status' => 'ready'])) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 min-h-[38px] sm:min-h-[42px] rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-2 sm:gap-2.5 {{ request('status') == 'ready' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_ready">Siap Saji</span>
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full text-[11px] sm:text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'ready' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countReady }}</span>
        </a>
        <a href="{{ route('admin.orders', array_merge($tabQueryParams, ['status' => 'completed'])) }}" class="px-3 sm:px-4 py-1.5 sm:py-2 min-h-[38px] sm:min-h-[42px] rounded-lg text-xs sm:text-sm font-medium transition-colors flex items-center gap-2 sm:gap-2.5 {{ request('status') == 'completed' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_completed">Selesai</span>
            <span class="w-5 h-5 sm:w-6 sm:h-6 rounded-full text-[11px] sm:text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'completed' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countCompleted }}</span>
        </a>
    </div>

    <!-- Orders Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-7 flex-1">
        @forelse((request()->has('empty') ? collect([]) : $orders) as $order)
            @php
                $badgeConfig = match($order->status) {
                    'pending' => [
                        'bg' => 'bg-[#F9E7B2] dark:bg-[#4A3A20] text-[#5C4D26] dark:text-[#FBBF24] border border-transparent dark:border-amber-700/50',
                        'label' => 'Menunggu',
                        'i18n' => 'st_pending',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"></path></svg>',
                    ],
                    'confirmed', 'preparing' => [
                        'bg' => 'bg-[#E6A8A1] dark:bg-[#4A2626] text-[#5A2520] dark:text-[#F87171] border border-transparent dark:border-red-800/50',
                        'label' => 'Dimasak',
                        'i18n' => 'st_cooking',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4v2m4-2v2m4-2v2M4 11h14a1 1 0 011 1v2a5 5 0 01-5 5H9a5 5 0 01-5-5v-2a1 1 0 011-1zm15 1h1.5a1.5 1.5 0 010 3H19"></path></svg>',
                    ],
                    'ready' => [
                        'bg' => 'bg-[#C8E6C9] dark:bg-[#1E453B] text-[#255A2A] dark:text-[#34D399] border border-transparent dark:border-emerald-700/50',
                        'label' => 'Siap Saji',
                        'i18n' => 'st_ready',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>',
                    ],
                    'completed' => [
                        'bg' => 'bg-[#BBDEFB] dark:bg-[#243852] text-[#1E3A8A] dark:text-[#60A5FA] border border-transparent dark:border-blue-700/50',
                        'label' => 'Selesai',
                        'i18n' => 'st_completed',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    ],
                    'cancelled' => [
                        'bg' => 'bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-400 border border-transparent dark:border-red-900/50',
                        'label' => 'Batal',
                        'i18n' => 'st_cancelled',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    ],
                    default => [
                        'bg' => 'bg-gray-100 dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-transparent dark:border-gray-700',
                        'label' => $order->status,
                        'i18n' => '',
                        'icon' => '',
                    ],
                };

                $nextStatus = match($order->status) {
                    'pending' => 'preparing',
                    'confirmed', 'preparing' => 'ready',
                    'ready' => 'completed',
                    default => null,
                };

                $isCreatedToday = $order->created_at->isToday();
                $isCreatedYesterday = $order->created_at->isYesterday();
                $minsAgo = max(1, (int) abs(now()->diffInMinutes($order->created_at)));
                
                if ($isCreatedToday) {
                    $timeDisplay = $minsAgo < 60 ? ($minsAgo . ' Menit yang lalu') : ('Hari ini, ' . $order->created_at->format('H:i'));
                } elseif ($isCreatedYesterday) {
                    $timeDisplay = 'Kemarin, ' . $order->created_at->format('H:i');
                } else {
                    $timeDisplay = $order->created_at->format('d M Y, H:i');
                }
            @endphp

            <div class="bg-white dark:bg-[#3C3C3C] rounded-[22px] sm:rounded-[26px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-4 sm:p-6 flex flex-col justify-between">
                <div>
                    <!-- Order number & payment badge -->
                    <div class="mb-3.5 flex items-center justify-between gap-2 flex-wrap">
                        <span class="bg-[#F0F2F5] dark:bg-[#4F4F4F] text-gray-800 dark:text-white font-mono font-bold text-xs px-3 py-1.5 rounded-md inline-block tracking-wide">{{ $order->order_number }}</span>
                        @if($order->payment_status === 'paid')
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#D1FAE5]/70 dark:bg-[#1E453B] text-[#065F46] dark:text-[#34D399]" data-i18n="order_detail_paid">Lunas</span>
                        @elseif($order->isAwaitingPaymentVerification())
                            <a href="{{ route('admin.orders.show', $order->order_number) }}#payment-proof-section"
                               class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-100 hover:bg-amber-200 dark:bg-[#4A3A20] text-amber-900 dark:text-[#FBBF24] border border-amber-300/80 dark:border-amber-700/60 transition inline-flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span data-i18n="ord_proof_pending">Bukti Masuk • Konfirmasi</span>
                            </a>
                        @elseif($order->status !== 'cancelled')
                            <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-rose-50 dark:bg-[#4A2626] text-rose-700 dark:text-[#F87171]" data-i18n="order_detail_unpaid">Belum Lunas</span>
                        @endif
                    </div>

                    <div class="flex items-start justify-between gap-2 mb-3.5">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-lg sm:text-xl font-extrabold text-gray-900 dark:text-white leading-tight break-words">{{ $order->customer_name }}</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-300 mt-1" data-mins-ago="{{ $minsAgo }}">{{ $timeDisplay }}</p>
                        </div>
                        <span class="px-2.5 sm:px-3 py-1 rounded-md text-[11px] sm:text-xs font-semibold inline-flex items-center gap-1.5 shrink-0 {{ $badgeConfig['bg'] }}">
                            {!! $badgeConfig['icon'] !!}
                            <span @if($badgeConfig['i18n']) data-i18n="{{ $badgeConfig['i18n'] }}" @endif>{{ $badgeConfig['label'] }}</span>
                        </span>
                    </div>

                    <div class="border-t border-gray-200 dark:border-[#555555] pt-3 pb-3">
                        <div class="grid grid-cols-12 text-xs text-gray-400 dark:text-gray-300 font-medium mb-2">
                            <span class="col-span-5" data-i18n="ord_col_prod">Produk</span>
                            <span class="col-span-2 text-center" data-i18n="ord_col_qty">total</span>
                            <span class="col-span-5 text-right" data-i18n="ord_col_price">Harga</span>
                        </div>
                        <div class="space-y-1.5">
                            @foreach($order->items as $item)
                            <div class="grid grid-cols-12 items-start text-xs sm:text-[13px] text-gray-800 dark:text-[#E5E5E5] font-medium">
                                <span class="col-span-5 break-words pr-1.5">{{ $item->product_name }}</span>
                                <span class="col-span-2 text-center">{{ $item->quantity }}</span>
                                <span class="col-span-5 text-right whitespace-nowrap"><span data-i18n="currency">Rp</span> {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <div class="border-t border-gray-200 dark:border-[#555555] pt-3 mb-3.5 flex items-center justify-between">
                        <span class="text-base font-bold text-gray-900 dark:text-white" data-i18n="ord_total_label">Total</span>
                        <span class="text-base font-extrabold text-gray-900 dark:text-white"><span data-i18n="currency">Rp</span> {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    @if($nextStatus)
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                        <button type="button"
                                onclick="confirmProcessOrder(this, '{{ $nextStatus }}', '{{ $order->order_number }}')"
                                class="w-full bg-[#415C58] hover:bg-[#344B48] active:scale-98 text-white font-medium py-3 px-4 rounded-xl text-xs sm:text-[13.5px] transition-all cursor-pointer flex items-center justify-center gap-2"
                                data-i18n="btn_confirm_order">
                            <span>konfirmasi pesanan</span>
                        </button>
                    </form>
                    @else
                    <div class="w-full bg-gray-100 dark:bg-[#444444] text-gray-700 dark:!text-white font-semibold py-3 px-4 rounded-xl text-xs sm:text-[13.5px] text-center border border-transparent dark:border-[#555555]" data-i18n="{{ $order->status == 'completed' ? 'ord_done_badge' : 'ord_cancel_badge' }}">
                        {{ $order->status == 'completed' ? 'Pesanan Selesai' : 'Pesanan Dibatalkan' }}
                    </div>
                    @endif

                    <div class="flex items-center justify-between text-xs pt-3">
                        <a href="{{ route('admin.orders.show', $order->order_number) }}" class="text-[#4A7C9B] dark:text-[#93C5FD] hover:underline font-medium" data-i18n="btn_detail">Lihat Detail Pesanan</a>
                        @if(!in_array($order->status, ['completed', 'cancelled']))
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="button"
                                    onclick="confirmCancelOrder(this, '{{ $order->order_number }}')"
                                    class="text-[#E53935] dark:text-[#FCA5A5] hover:underline font-medium cursor-pointer"
                                    data-i18n="btn_cancel">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center text-center py-16 px-4">
                <img src="{{ asset('images/empty-order.png') }}"
                     alt="Belum Ada Pesanan"
                     width="180"
                     height="168"
                     loading="lazy"
                     class="w-36 sm:w-44 h-auto mx-auto mb-4 object-contain">
                <h3 class="text-xl font-bold text-[#262626] dark:text-white" data-i18n="ord_empty_title">Belum Ada Pesanan</h3>
                <p class="text-xs sm:text-sm text-[#6B7280] dark:text-[#C4C9D0] mt-1.5 max-w-sm leading-relaxed" data-i18n="ord_empty_desc">
                    Tidak ditemukan pesanan pada filter tanggal atau kriteria ini.
                </p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('admin.orders') }}" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-[#555555] bg-white dark:bg-[#333333] hover:bg-gray-50 dark:hover:bg-[#3D3D3D] text-xs font-semibold text-gray-700 dark:text-[#E5E5E5] transition shadow-xs cursor-pointer">
                        Lihat Semua Pesanan
                    </a>
                    <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 rounded-xl bg-[#415C58] hover:bg-[#344B48] text-white text-xs font-semibold transition shadow-xs cursor-pointer" data-i18n="btn_refresh">
                        Refresh Halaman
                    </button>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginasi Scalable (Untuk penggunaan jangka panjang hingga bertahun-tahun) -->
    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
    <div class="mt-8 pt-6 border-t border-gray-200/90 dark:border-[#444444] flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-xs text-gray-500 dark:text-gray-400">
            Menampilkan <span class="font-bold text-gray-800 dark:text-white">{{ $orders->firstItem() }}</span> s/d <span class="font-bold text-gray-800 dark:text-white">{{ $orders->lastItem() }}</span> dari <span class="font-bold text-gray-800 dark:text-white">{{ $orders->total() }}</span> pesanan
        </div>
        <div class="overflow-x-auto max-w-full">
            {{ $orders->links() }}
        </div>
    </div>
    @endif
</div>

<script>
function handleOrderSortChange(sortVal) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sortVal);
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endsection

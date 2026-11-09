@extends('layouts.admin')

@section('title', 'Dashboard - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-5 sm:p-7 lg:p-8 space-y-6 h-full flex flex-col justify-between">

    <div class="space-y-5 sm:space-y-6">
        <div>
            <h1 class="text-2xl sm:text-[28px] font-bold text-[#262626] dark:text-white tracking-tight leading-tight">
                <span data-i18n="dash_greeting">Halo, Admin Toon Burger</span><span aria-hidden="true">👋</span>
            </h1>
            <p class="text-xs sm:text-[13.5px] text-[#6B7280] dark:text-[#C4C9D0] mt-1 font-normal" data-i18n="dash_subtitle">Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 min-[1140px]:grid-cols-4 gap-4 sm:gap-5">

            <a href="{{ route('admin.orders', ['status' => 'completed']) }}"
               class="tb-metric-card tb-focus-ring rounded-[18px] overflow-hidden flex flex-col justify-between group">
                <div class="p-4 pb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="tb-metric-icon w-9 h-9 rounded-[10px] flex items-center justify-center shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <rect x="3.5" y="11" width="2.8" height="5.2" rx="0.7"></rect>
                                <rect x="8.6" y="7.8" width="2.8" height="8.4" rx="0.7"></rect>
                                <rect x="13.7" y="4.2" width="2.8" height="12" rx="0.7"></rect>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs sm:text-[13px] font-medium text-[#374151] dark:text-[#F3F4F6] leading-tight truncate" data-i18n="dash_metric_profit">Pendapatan Hari Ini</div>
                            <div class="text-[10px] text-[#6B7280] dark:text-[#D1D5DB] leading-tight mt-0.5 truncate" data-i18n="dash_sub_profit">Lorem ipsum dolor</div>
                        </div>
                    </div>

                    <div class="mt-3.5 flex items-center gap-2 flex-wrap">
                        <span class="text-[18px] xl:text-[20px] font-semibold text-[#262626] dark:text-white tracking-tight leading-none whitespace-nowrap">
                            <span data-i18n="currency_dot">Rp.</span> {{ number_format($todayRevenue, 0, ',', '.') }}
                        </span>
                        <span class="tb-badge-positive inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full leading-tight whitespace-nowrap">
                            +{{ $revenueGrowth }}% &uarr;
                        </span>
                    </div>
                </div>

                <div class="tb-metric-footer px-4 py-2 flex items-center justify-between text-[11px] font-normal">
                    <span data-i18n="dash_view_detail">Lihat Detail</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M13 6l6 6-6 6"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}"
               class="tb-metric-card tb-focus-ring rounded-[18px] overflow-hidden flex flex-col justify-between group">
                <div class="p-4 pb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="tb-metric-icon w-9 h-9 rounded-[10px] flex items-center justify-center shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 2.75A1.75 1.75 0 0 0 3.75 4.5v11c0 .966.784 1.75 1.75 1.75h9a1.75 1.75 0 0 0 1.75-1.75v-11A1.75 1.75 0 0 0 14.5 2.75h-9ZM6.5 6a.75.75 0 0 1 .75-.75h5.5a.75.75 0 0 1 0 1.5h-5.5A.75.75 0 0 1 6.5 6Zm.75 2.75a.75.75 0 0 0 0 1.5h5.5a.75.75 0 0 0 0-1.5h-5.5Zm-.75 4.25a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs sm:text-[13px] font-medium text-[#374151] dark:text-[#F3F4F6] leading-tight truncate" data-i18n="dash_metric_orders">Pesanan Hari Ini</div>
                            <div class="text-[10px] text-[#6B7280] dark:text-[#D1D5DB] leading-tight mt-0.5 truncate" data-i18n="dash_sub_orders">Lorem ipsum dolor</div>
                        </div>
                    </div>

                    <div class="mt-3.5 flex items-center gap-2 flex-wrap">
                        <span class="text-[18px] xl:text-[20px] font-semibold text-[#262626] dark:text-white tracking-tight leading-none whitespace-nowrap">
                            {{ $totalOrdersToday }} <span data-i18n="transaction">Transaksi</span>
                        </span>
                        <span class="tb-badge-positive inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full leading-tight whitespace-nowrap">
                            +{{ $ordersGrowth }}% &uarr;
                        </span>
                    </div>
                </div>

                <div class="tb-metric-footer px-4 py-2 flex items-center justify-between text-[11px] font-normal">
                    <span data-i18n="dash_view_detail">Lihat Detail</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M13 6l6 6-6 6"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.orders', ['status' => 'diproses']) }}"
               class="tb-metric-card tb-focus-ring rounded-[18px] overflow-hidden flex flex-col justify-between group">
                <div class="p-4 pb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="tb-metric-icon w-9 h-9 rounded-[10px] flex items-center justify-center shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                <rect x="3.5" y="11" width="2.8" height="5.2" rx="0.7"></rect>
                                <rect x="8.6" y="7.8" width="2.8" height="8.4" rx="0.7"></rect>
                                <rect x="13.7" y="4.2" width="2.8" height="12" rx="0.7"></rect>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs sm:text-[13px] font-medium text-[#374151] dark:text-[#F3F4F6] leading-tight truncate" data-i18n="dash_metric_progress">Pesanan Dalam Proses</div>
                            <div class="text-[10px] text-[#6B7280] dark:text-[#D1D5DB] leading-tight mt-0.5 truncate" data-i18n="dash_sub_progress">Lorem ipsum dolor</div>
                        </div>
                    </div>

                    <div class="mt-3.5 flex items-center gap-2 flex-wrap">
                        <span class="text-[18px] xl:text-[20px] font-semibold text-[#262626] dark:text-white tracking-tight leading-none whitespace-nowrap">
                            {{ $pendingOrders }} <span data-i18n="queue">Antrean</span>
                        </span>
                        <span class="tb-badge-positive inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full leading-tight whitespace-nowrap" data-i18n="dash_needs_processing">
                            Perlu segera diproses
                        </span>
                    </div>
                </div>

                <div class="tb-metric-footer px-4 py-2 flex items-center justify-between text-[11px] font-normal">
                    <span data-i18n="dash_view_detail">Lihat Detail</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M13 6l6 6-6 6"></path>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.products') }}"
               class="tb-metric-card tb-focus-ring rounded-[18px] overflow-hidden flex flex-col justify-between group">
                <div class="p-4 pb-3.5">
                    <div class="flex items-center gap-3">
                        <div class="tb-metric-icon w-9 h-9 rounded-[10px] flex items-center justify-center shrink-0" aria-hidden="true">
                            <svg class="w-4 h-4" viewBox="0 -960 960 960" fill="currentColor">
                                <path d="M160-120q-33 0-56.5-23.5T80-200v-80q0-17 11.5-28.5T120-320h720q17 0 28.5 11.5T880-280v80q0 33-23.5 56.5T800-120H160Zm0-280q-33 0-56.5-23.5T80-480q0-33 23.5-56.5T160-560h640q33 0 56.5 23.5T880-480q0 33-23.5 56.5T800-400H160Zm665-240H135q-26 0-40.5-21T86-708q34-66 123-109t271-43q182 0 271 43t123 109q15 26 .5 47T825-640Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs sm:text-[13px] font-medium text-[#374151] dark:text-[#F3F4F6] leading-tight truncate" data-i18n="dash_metric_products">Total Produk</div>
                            <div class="text-[10px] text-[#6B7280] dark:text-[#D1D5DB] leading-tight mt-0.5 truncate" data-i18n="dash_sub_products">Lorem ipsum dolor</div>
                        </div>
                    </div>

                    <div class="mt-3.5 flex items-center gap-1.5 flex-wrap">
                        <span class="text-[18px] xl:text-[20px] font-semibold text-[#262626] dark:text-white tracking-tight leading-none whitespace-nowrap">
                            {{ $totalProducts }} <span data-i18n="nav_products_short">Produk</span>
                        </span>
                        <span class="tb-badge-positive inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full leading-tight whitespace-nowrap">
                            {{ $activeProducts }} <span class="ml-0.5" data-i18n="dash_active">Aktif</span>
                        </span>
                        <span class="tb-badge-danger inline-flex items-center text-[10px] font-medium px-2 py-0.5 rounded-full leading-tight whitespace-nowrap">
                            {{ $outOfStockProducts }} <span class="ml-0.5" data-i18n="dash_out_of_stock">Habis</span>
                        </span>
                    </div>
                </div>

                <div class="tb-metric-footer px-4 py-2 flex items-center justify-between text-[11px] font-normal">
                    <span data-i18n="dash_view_detail">Lihat Detail</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M13 6l6 6-6 6"></path>
                    </svg>
                </div>
            </a>

        </div>
    </div>

    <div class="grid grid-cols-1 min-[1140px]:grid-cols-[minmax(0,2.22fr)_minmax(275px,1fr)] gap-5 lg:gap-6 items-stretch flex-1">

        <section class="tb-panel-card rounded-[22px] p-5 sm:p-6 lg:p-7 flex flex-col justify-between" aria-labelledby="chart-heading">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <h2 id="chart-heading" class="text-xs sm:text-[13.5px] font-normal text-[#6B7280] dark:text-[#C4C9D0]" data-i18n="dash_rev_12m">Pendapatan 12 Bulan Terakhir</h2>
                    <div class="text-xl sm:text-[22px] font-bold text-[#262626] dark:text-white tracking-tight mt-1">
                        <span data-i18n="currency_dot">Rp.</span> {{ number_format($yearlyRevenue, 2, '.', ',') }}
                    </div>
                </div>

                <div class="flex items-center gap-2" role="group" aria-label="Rentang bulan pendapatan">
                    <button type="button"
                            id="period-btn-jan-jun"
                            onclick="switchRevenuePeriod('jan_jun')"
                            aria-pressed="true"
                            class="tb-period-btn tb-focus-ring is-active rounded-full px-4 py-1.5 max-sm:min-h-[44px] text-[11px] font-medium cursor-pointer"
                            data-i18n="dash_period_h1">
                        Jan - Jun
                    </button>
                    <button type="button"
                            id="period-btn-jul-des"
                            onclick="switchRevenuePeriod('jul_des')"
                            aria-pressed="false"
                            class="tb-period-btn tb-focus-ring rounded-full px-4 py-1.5 max-sm:min-h-[44px] text-[11px] font-medium cursor-pointer"
                            data-i18n="dash_period_h2">
                        Jul - Des
                    </button>
                </div>
            </div>

            <div class="mt-8 sm:mt-10 pt-5 flex-1 flex flex-col justify-end">
                <div class="flex items-stretch gap-3 sm:gap-5">
                    <div class="w-8 shrink-0 relative h-[215px] sm:h-[245px] select-none text-[11px] text-[#6B7280] dark:text-[#C4C9D0]" aria-hidden="true">
                        <span class="absolute left-0 bottom-[100%] translate-y-1/2" data-yaxis="10">10jt</span>
                        <span class="absolute left-0 bottom-[80%] translate-y-1/2" data-yaxis="8">8jt</span>
                        <span class="absolute left-0 bottom-[60%] translate-y-1/2" data-yaxis="6">6jt</span>
                        <span class="absolute left-0 bottom-[40%] translate-y-1/2" data-yaxis="4">4jt</span>
                        <span class="absolute left-0 bottom-[20%] translate-y-1/2" data-yaxis="2">2jt</span>
                    </div>

                    <div class="flex-1 relative h-[215px] sm:h-[245px]">
                        <div class="pointer-events-none absolute inset-x-0 bottom-[100%] border-t border-[#EFEFEF] dark:border-[#4A4A4A]"></div>
                        <div class="pointer-events-none absolute inset-x-0 bottom-[80%] border-t border-[#EFEFEF] dark:border-[#4A4A4A]"></div>
                        <div class="pointer-events-none absolute inset-x-0 bottom-[60%] border-t border-[#EFEFEF] dark:border-[#4A4A4A]"></div>
                        <div class="pointer-events-none absolute inset-x-0 bottom-[40%] border-t border-[#EFEFEF] dark:border-[#4A4A4A]"></div>
                        <div class="pointer-events-none absolute inset-x-0 bottom-[20%] border-t border-[#EFEFEF] dark:border-[#4A4A4A]"></div>

                        <div id="revenue-bars-grid" class="relative z-10 h-full grid grid-cols-6 gap-2 sm:gap-4 items-end px-1 sm:px-3">
                            @foreach($chartPeriods['jan_jun'] as $idx => $bar)
                                @php
                                    $isDefaultActive = ($idx === 2);
                                    $tooltipAlign = $idx === 0
                                        ? 'left-0 sm:left-1/2 sm:-translate-x-1/2'
                                        : ($idx === 5 ? 'right-0 sm:right-auto sm:left-1/2 sm:-translate-x-1/2' : 'left-1/2 -translate-x-1/2');
                                @endphp
                                <div class="h-full flex flex-col justify-end items-center relative">
                                    <button type="button"
                                            onclick="selectRevenueBar({{ $idx }})"
                                            aria-pressed="{{ $isDefaultActive ? 'true' : 'false' }}"
                                            aria-label="{{ $bar['id_month'] }}: {{ $bar['val_id'] }}"
                                            style="height: {{ $bar['pct'] }}%;"
                                            class="tb-chart-bar tb-focus-ring {{ $isDefaultActive ? 'is-active' : '' }} w-full max-w-[50px] sm:max-w-[66px] xl:max-w-[74px] rounded-t-[14px] sm:rounded-t-[18px] relative cursor-pointer">
                                        <span class="tb-bar-tooltip {{ $isDefaultActive ? 'block' : 'hidden' }} absolute bottom-[calc(100%+7px)] {{ $tooltipAlign }} bg-[#333333] text-white rounded-[10px] px-2.5 sm:px-3 py-1.5 shadow-md text-left whitespace-nowrap z-20 pointer-events-none">
                                            <span class="tb-tooltip-date block text-[9px] text-[#D1D5DB] font-normal leading-tight">{{ $bar['date_id'] }}</span>
                                            <span class="tb-tooltip-val block text-[11px] font-semibold text-white leading-snug">{{ $bar['val_id'] }}</span>
                                            <span class="hidden sm:block absolute left-1/2 -translate-x-1/2 top-full w-0 h-0 border-l-[5px] border-l-transparent border-r-[5px] border-r-transparent border-t-[5px] border-t-[#333333]"></span>
                                        </span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-5 mt-2">
                    <div class="w-8 shrink-0 text-[11px] text-[#6B7280] dark:text-[#C4C9D0] select-none">0k</div>
                    <div id="revenue-months-grid" class="flex-1 grid grid-cols-6 gap-2 sm:gap-4 px-1 sm:px-3 text-center text-[11px] text-[#6B7280] dark:text-[#C4C9D0]">
                        @foreach($chartPeriods['jan_jun'] as $idx => $bar)
                            <button type="button"
                                    onclick="selectRevenueBar({{ $idx }})"
                                    class="tb-month-label tb-focus-ring py-1 rounded cursor-pointer hover:text-[#262626] dark:hover:text-white transition {{ $idx === 2 ? 'font-medium text-[#374151] dark:text-white' : '' }}">
                                {{ $bar['id_month'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="tb-panel-card rounded-[22px] overflow-hidden flex flex-col justify-between" aria-labelledby="bestseller-heading">
            <div class="px-5 py-4 border-b border-gray-100 dark:border-[#4A4A4A]">
                <h2 id="bestseller-heading" class="font-semibold text-[15px] sm:text-base text-[#262626] dark:text-white tracking-tight" data-i18n="dash_best_selling">Produk Terlaris</h2>
            </div>

            <div class="p-4 space-y-2.5 flex-1 flex flex-col justify-center">
                @forelse($topProducts as $item)
                    <a href="{{ route('admin.products', ['search' => $item->search_term]) }}"
                       class="tb-bestseller-item tb-focus-ring rounded-xl px-3 py-2.5 min-h-[56px] flex items-center justify-between gap-3 group">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-lg overflow-hidden flex items-center justify-center shrink-0"
                             style="background-color: {{ $item->bg_hex }};">
                            <img src="{{ asset($item->image) }}"
                                 alt="{{ $item->product_name }}"
                                 width="44"
                                 height="44"
                                 loading="lazy"
                                 decoding="async"
                                 class="w-full h-full object-contain p-0.5 transition-transform duration-200 group-hover:scale-105">
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-xs text-current truncate leading-snug">{{ $item->product_name }}</h3>
                            <span class="tb-bestseller-sub text-[10.5px] font-normal block mt-0.5 leading-tight">
                                {{ $item->total_qty }} <span data-i18n="dash_products_sold">Produk Terjual</span>
                            </span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-[#4B5563] dark:text-[#D1D5DB] shrink-0 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </a>
                @empty
                    <div class="text-center py-8 px-4 text-xs text-[#5F6672] dark:text-[#D1D5DB]">
                        Belum ada data penjualan menu. Tambahkan menu di halaman Data Produk untuk mulai mencatat penjualan.
                    </div>
                @endforelse
            </div>

            <a href="{{ route('admin.products') }}"
               class="tb-bestseller-footer tb-focus-ring px-5 py-3.5 min-h-[44px] flex items-center justify-between text-xs font-normal group">
                <span data-i18n="dash_see_all_products">Lihat Semua Produk</span>
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="M13 6l6 6-6 6"></path>
                </svg>
            </a>
        </section>

    </div>

</div>

<script>
    (function () {
        const chartPeriods = @json($chartPeriods);
        let activePeriod = 'jan_jun';
        let activeBarIndex = 2;

        function isEnglishActive() {
            return window._tbLang === 'US' || window._tbLang === 'EN';
        }

        let cachedRefs = null;

        function getChartRefs() {
            if (cachedRefs) return cachedRefs;
            const barsGrid = document.getElementById('revenue-bars-grid');
            const monthsGrid = document.getElementById('revenue-months-grid');
            if (!barsGrid || !monthsGrid) return null;
            cachedRefs = {
                btnH1: document.getElementById('period-btn-jan-jun'),
                btnH2: document.getElementById('period-btn-jul-des'),
                yAxisEls: Array.from(document.querySelectorAll('[data-yaxis]')),
                barButtons: Array.from(barsGrid.querySelectorAll('.tb-chart-bar')).map((btn) => ({
                    btn,
                    tooltip: btn.querySelector('.tb-bar-tooltip'),
                    dateEl: btn.querySelector('.tb-tooltip-date'),
                    valEl: btn.querySelector('.tb-tooltip-val'),
                })),
                monthButtons: Array.from(monthsGrid.querySelectorAll('.tb-month-label')),
            };
            return cachedRefs;
        }

        function renderRevenueChart() {
            const refs = getChartRefs();
            if (!refs) return;

            const isEn = isEnglishActive();
            const rows = chartPeriods[activePeriod] || [];

            if (refs.btnH1 && refs.btnH2) {
                const h1Active = activePeriod === 'jan_jun';
                refs.btnH1.classList.toggle('is-active', h1Active);
                refs.btnH1.setAttribute('aria-pressed', h1Active ? 'true' : 'false');
                refs.btnH2.classList.toggle('is-active', !h1Active);
                refs.btnH2.setAttribute('aria-pressed', !h1Active ? 'true' : 'false');
            }

            refs.yAxisEls.forEach((el) => {
                const n = el.getAttribute('data-yaxis');
                const nextLabel = isEn ? `${n}M` : `${n}jt`;
                if (el.textContent !== nextLabel) el.textContent = nextLabel;
            });

            rows.forEach((row, idx) => {
                const isSelected = idx === activeBarIndex;
                const monthText = isEn ? row.en_month : row.id_month;
                const dateText = isEn ? row.date_en : row.date_id;
                const valText = isEn ? row.val_en : row.val_id;

                const barRef = refs.barButtons[idx];
                if (barRef) {
                    const nextHeight = `${row.pct}%`;
                    if (barRef.btn.style.height !== nextHeight) barRef.btn.style.height = nextHeight;
                    barRef.btn.classList.toggle('is-active', isSelected);
                    barRef.btn.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
                    barRef.btn.setAttribute('aria-label', `${monthText}: ${valText}`);

                    if (barRef.dateEl && barRef.dateEl.textContent !== dateText) barRef.dateEl.textContent = dateText;
                    if (barRef.valEl && barRef.valEl.textContent !== valText) barRef.valEl.textContent = valText;
                    if (barRef.tooltip) {
                        barRef.tooltip.classList.toggle('block', isSelected);
                        barRef.tooltip.classList.toggle('hidden', !isSelected);
                    }
                }

                const monthBtn = refs.monthButtons[idx];
                if (monthBtn) {
                    if (monthBtn.textContent.trim() !== monthText) monthBtn.textContent = monthText;
                    monthBtn.classList.toggle('font-medium', isSelected);
                    monthBtn.classList.toggle('text-[#374151]', isSelected);
                    monthBtn.classList.toggle('dark:text-white', isSelected);
                }
            });
        }

        window.switchRevenuePeriod = function (period) {
            if (!chartPeriods[period]) return;
            activePeriod = period;
            activeBarIndex = period === 'jan_jun' ? 2 : 3;
            renderRevenueChart();
        };

        window.selectRevenueBar = function (idx) {
            activeBarIndex = idx;
            renderRevenueChart();
        };

        if (window._tbDashLangHandler) {
            window.removeEventListener('tb:langchange', window._tbDashLangHandler);
        }
        window._tbDashLangHandler = renderRevenueChart;
        window.addEventListener('tb:langchange', renderRevenueChart);
        if (isEnglishActive()) {
            renderRevenueChart();
        }
    })();
</script>
@endsection

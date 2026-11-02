@extends('layouts.admin')

@section('title', 'Dashboard - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-6 sm:p-9 lg:p-10 flex-1 flex flex-col justify-between space-y-8">

    <div>
        <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight flex items-center gap-1.5 leading-tight">
            <span data-i18n="dash_greeting">Halo, Admin Toon Burger</span><span>👋</span>
        </h1>
        <p class="text-sm sm:text-[15px] text-gray-500 dark:text-[#D4D4D4] mt-1.5 font-normal" data-i18n="dash_subtitle">Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">

        <div class="bg-white dark:bg-[#3C3C3C] rounded-[24px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.12)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-6 lg:p-7 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500 dark:text-[#E0E0E0]">
                <span class="text-sm lg:text-[15px] font-normal text-gray-500 dark:text-[#E0E0E0]" data-i18n="dash_metric_profit">Pendapatan Hari Ini</span>
                <svg class="w-5 h-5 text-gray-600 dark:text-[#BDBDBD] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4v16h16"/>
                    <path d="M8 14h4"/>
                    <path d="M8 10h8"/>
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-gray-900 dark:text-white tracking-tight block leading-tight" data-kpi-revenue="{{ $todayRevenue }}">
                    Rp. {{ number_format($todayRevenue, 0, ',', '.') }}
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-xs lg:text-[13px] font-medium px-3.5 py-1 rounded-full bg-[#E6F4EA] dark:bg-[#2E5A44] text-[#4E7D6B] dark:text-[#A7F3D0]" data-i18n="dash_up5">
                    Naik {{ $revenueGrowth }}% dari kemarin
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#3C3C3C] rounded-[24px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.12)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-6 lg:p-7 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500 dark:text-[#E0E0E0]">
                <span class="text-sm lg:text-[15px] font-normal text-gray-500 dark:text-[#E0E0E0]" data-i18n="dash_metric_orders">Pesanan Hari Ini</span>
                <svg class="w-5 h-5 text-gray-600 dark:text-[#BDBDBD] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6.5 16.5V3.5L7.8 5L9.1 3.5L10.4 5L11.7 3.5L13 5L14.3 3.5L15.6 5L16.9 3.5L18.2 5L19.5 3.5V20" />
                    <path d="M9 8h5M16.2 8h1.4" stroke-width="2" />
                    <path d="M9 11.5h5M16.2 11.5h1.4" stroke-width="2" />
                    <path d="M15.5 16.5H4.8A1.75 1.75 0 0 0 3.05 18.25A1.75 1.75 0 0 0 4.8 20H19.5" />
                    <line x1="15.5" y1="16.5" x2="15.5" y2="20" />
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-gray-900 dark:text-white tracking-tight block leading-tight">
                    {{ $totalOrdersToday }} <span data-i18n="transaction">Transaksi</span>
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-xs lg:text-[13px] font-medium px-3.5 py-1 rounded-full bg-[#E6F4EA] dark:bg-[#2E5A44] text-[#4E7D6B] dark:text-[#A7F3D0]" data-i18n="dash_up2">
                    Naik {{ $ordersGrowth }}% dari kemarin
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#3C3C3C] rounded-[24px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.12)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-6 lg:p-7 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500 dark:text-[#E0E0E0]">
                <span class="text-sm lg:text-[15px] font-normal text-gray-500 dark:text-[#E0E0E0]" data-i18n="dash_metric_progress">Pesanan Dalam Proses</span>
                <svg class="w-5 h-5 text-gray-600 dark:text-[#BDBDBD] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="3" x2="8" y2="6"/>
                    <line x1="12" y1="3" x2="12" y2="6"/>
                    <path d="M4 10h13v3a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5v-3z"/>
                    <path d="M17 10h1.5a2.5 2.5 0 0 1 0 5H17"/>
                    <line x1="4" y1="20" x2="17" y2="20"/>
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-gray-900 dark:text-white tracking-tight block leading-tight">
                    {{ $pendingOrders }} <span data-i18n="queue">Antrean</span>
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-xs lg:text-[13px] font-medium px-3.5 py-1 rounded-full bg-[#E6F4EA] dark:bg-[#2E5A44] text-[#4E7D6B] dark:text-[#A7F3D0]" data-i18n="dash_needs_processing">
                    Perlu Segera Di Proses
                </span>
            </div>
        </div>

        <div class="bg-white dark:bg-[#3C3C3C] rounded-[24px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.12)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-6 lg:p-7 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500 dark:text-[#E0E0E0]">
                <span class="text-sm lg:text-[15px] font-normal text-gray-500 dark:text-[#E0E0E0]" data-i18n="dash_metric_products">Total Produk</span>
                <svg class="w-5 h-5 text-gray-600 dark:text-[#BDBDBD] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4v16h16"/>
                    <path d="M8 14h4"/>
                    <path d="M8 10h8"/>
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-gray-900 dark:text-white tracking-tight block leading-tight">
                    {{ $totalProducts }} <span data-i18n="nav_products_short">Produk</span>
                </span>
            </div>
            <div class="flex items-center gap-2.5 flex-wrap">
                <span class="inline-flex items-center text-xs lg:text-[13px] font-medium px-3.5 py-1 rounded-full bg-[#E6F4EA] dark:bg-[#2E5A44] text-[#4E7D6B] dark:text-[#A7F3D0]">
                    {{ $activeProducts }} <span class="ml-1" data-i18n="dash_active">Aktif</span>
                </span>
                <span class="inline-flex items-center text-xs lg:text-[13px] font-medium px-3.5 py-1 rounded-full bg-[#FCE8E6] dark:bg-[#632B2B] text-[#D9534F] dark:text-[#FCA5A5]">
                    {{ $outOfStockProducts }} <span class="ml-1" data-i18n="dash_out_of_stock">Habis</span>
                </span>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-7 items-stretch flex-1">

        <div class="lg:col-span-8 bg-white dark:bg-[#2B2B2B] rounded-[26px] border border-gray-200/90 dark:border-[#555555] shadow-2xs overflow-hidden flex flex-col">
            <div class="px-7 py-5 flex items-center justify-between">
                <h3 class="font-bold text-lg lg:text-[20px] text-[#333333] dark:text-white tracking-tight" data-i18n="dash_latest_order">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders') }}" class="text-sm lg:text-[15px] font-medium text-gray-600 dark:text-[#E0E0E0] hover:text-gray-900 dark:hover:text-white transition inline-flex items-center gap-1.5 group min-h-[36px]">
                    <span data-i18n="dash_see_all">Lihat semua</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto flex-1 flex flex-col">
                <table class="w-full text-center text-sm lg:text-[14.5px] flex-1">
                    <thead>
                        <tr class="bg-[#F5F5F5] dark:bg-[#9E9E9E] border-y border-gray-200/80 dark:border-[#757575] text-gray-600 dark:text-[#222222] font-normal text-xs sm:text-sm lg:text-[14px]">
                            <th class="py-4 px-5 font-normal" data-i18n="dash_col_order_num">No. Pesanan</th>
                            <th class="py-4 px-5 font-normal" data-i18n="dash_col_customer">Nama Pelanggan</th>
                            <th class="py-4 px-5 font-normal" data-i18n="dash_col_total">Total</th>
                            <th class="py-4 px-5 font-normal" data-i18n="dash_col_status">Status</th>
                            <th class="py-4 px-5 font-normal" data-i18n="dash_col_action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/70 dark:divide-[#444444]">
                        @forelse($recentOrders as $order)
                            @php
                                $statusConfig = match($order->status) {
                                    'completed' => ['dot' => 'bg-[#3B82F6]', 'key' => 'stepper_completed', 'label' => 'Selesai'],
                                    'ready' => ['dot' => 'bg-[#689F38]', 'key' => 'stepper_ready', 'label' => 'Siap Saji'],
                                    'preparing', 'confirmed' => ['dot' => 'bg-[#E53935]', 'key' => 'stepper_cooking', 'label' => 'Dimasak'],
                                    'cancelled' => ['dot' => 'bg-gray-400', 'key' => 'orders_status_cancelled', 'label' => 'Dibatalkan'],
                                    default => ['dot' => 'bg-[#FBC02D]', 'key' => 'stepper_pending', 'label' => 'Menunggu'],
                                };
                            @endphp
                            <tr class="hover:bg-gray-50/70 dark:hover:bg-[#353535] transition">
                                <td class="py-6 px-5 font-mono font-bold text-gray-800 dark:text-[#E5E5E5] text-xs sm:text-sm lg:text-[14.5px] whitespace-nowrap">
                                    {{ $order->display_order_number ?? $order->order_number }}
                                </td>
                                <td class="py-6 px-5 text-gray-600 dark:text-[#D4D4D4] text-xs sm:text-sm lg:text-[14.5px] font-normal">
                                    {{ $order->customer_name ?: ($order->user->name ?? 'Pelanggan') }}
                                </td>
                                <td class="py-6 px-5 font-bold text-gray-800 dark:text-white text-xs sm:text-sm lg:text-[14.5px] whitespace-nowrap">
                                    <span data-i18n="currency">Rp</span> {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-6 px-5 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center gap-2 text-xs sm:text-sm lg:text-[14.5px] text-gray-700 dark:text-[#E5E5E5] font-medium">
                                        <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }} dark:ring-1 dark:ring-white"></span>
                                        <span data-i18n="{{ $statusConfig['key'] }}">{{ $statusConfig['label'] }}</span>
                                    </span>
                                </td>
                                <td class="py-6 px-5 text-center">
                                    <a href="{{ route('admin.orders.show', $order->order_number) }}" class="inline-block bg-white dark:bg-transparent hover:bg-gray-100 dark:hover:bg-[#3C3C3C] border border-gray-500 dark:border-[#D4D4D4] text-gray-700 dark:text-white font-normal px-5 py-1 rounded-full transition text-xs lg:text-[13px]" data-i18n="dash_detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-10 text-center text-gray-400 text-sm" data-i18n="dash_empty_orders">
                                    Belum ada pesanan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white dark:bg-[#2B2B2B] rounded-[26px] p-6 sm:p-7 border border-gray-200/90 dark:border-[#555555] shadow-2xs flex flex-col">
            <h3 class="font-bold text-lg lg:text-[20px] text-[#333333] dark:text-white pb-4 mb-5 border-b border-gray-100 dark:border-[#757575] tracking-tight" data-i18n="dash_best_selling">Menu Terlaris</h3>
            <div class="space-y-3.5 flex-1 flex flex-col justify-between">
                @forelse($topProducts as $idx => $item)
                    <div class="flex items-center gap-4 px-5 py-4 rounded-2xl bg-[#EBEBEB] dark:bg-[#6B6B6B] hover:bg-[#E2E2E2] dark:hover:bg-[#757575] transition">
                        <span class="w-8 h-8 rounded-full bg-[#3F5E5A] text-white font-bold text-sm flex items-center justify-center shrink-0">
                            {{ $idx + 1 }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-sm lg:text-[15px] text-gray-900 dark:text-white truncate leading-tight">{{ $item->product_name }}</h4>
                            <span class="text-xs lg:text-[12.5px] text-gray-500 dark:text-[#E5E5E5] font-normal block mt-0.5">{{ $item->total_qty }} <span data-i18n="dash_products_sold">Produk Terjual</span></span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-gray-400 text-sm" data-i18n="dash_empty_best">
                        Belum ada penjualan menu.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

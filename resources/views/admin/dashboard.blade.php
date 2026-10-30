@extends('layouts.admin')

@section('title', 'Dashboard - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-7">

    <div>
        <h1 class="text-2xl sm:text-[28px] font-bold text-[#333333] tracking-tight flex items-center gap-1">
            <span data-i18n="dash_greeting">Halo, Admin Toon Burger</span><span>👋</span>
        </h1>
        <p class="text-xs sm:text-[13px] text-gray-500 mt-1 font-normal" data-i18n="dash_subtitle">Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

        <div class="bg-white rounded-[22px] border border-gray-200/90 shadow-[0_4px_10px_rgba(0,0,0,0.12)] p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500">
                <span class="text-xs font-normal text-gray-500" data-i18n="dash_metric_profit">Pendapatan Hari Ini</span>
                <svg class="w-4 h-4 text-gray-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4v16h16"/>
                    <path d="M8 14h4"/>
                    <path d="M8 10h8"/>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    Rp. {{ number_format($todayRevenue, 0, ',', '.') }}
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-3 py-0.5 rounded-full bg-[#E6F4EA] text-[#4E7D6B]" data-i18n="dash_up5">
                    Naik {{ $revenueGrowth }}% dari kemarin
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[22px] border border-gray-200/90 shadow-[0_4px_10px_rgba(0,0,0,0.12)] p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500">
                <span class="text-xs font-normal text-gray-500" data-i18n="dash_metric_orders">Pesanan Hari Ini</span>
                <svg class="w-4 h-4 text-gray-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6.5 16.5V3.5L7.8 5L9.1 3.5L10.4 5L11.7 3.5L13 5L14.3 3.5L15.6 5L16.9 3.5L18.2 5L19.5 3.5V20" />
                    <path d="M9 8h5M16.2 8h1.4" stroke-width="2" />
                    <path d="M9 11.5h5M16.2 11.5h1.4" stroke-width="2" />
                    <path d="M15.5 16.5H4.8A1.75 1.75 0 0 0 3.05 18.25A1.75 1.75 0 0 0 4.8 20H19.5" />
                    <line x1="15.5" y1="16.5" x2="15.5" y2="20" />
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $totalOrdersToday }} <span data-i18n="transaction">Transaksi</span>
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-3 py-0.5 rounded-full bg-[#E6F4EA] text-[#4E7D6B]" data-i18n="dash_up2">
                    Naik {{ $ordersGrowth }}% dari kemarin
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[22px] border border-gray-200/90 shadow-[0_4px_10px_rgba(0,0,0,0.12)] p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500">
                <span class="text-xs font-normal text-gray-500" data-i18n="dash_metric_progress">Pesanan Dalam Proses</span>
                <svg class="w-4 h-4 text-gray-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="8" y1="3" x2="8" y2="6"/>
                    <line x1="12" y1="3" x2="12" y2="6"/>
                    <path d="M4 10h13v3a5 5 0 0 1-5 5H9a5 5 0 0 1-5-5v-3z"/>
                    <path d="M17 10h1.5a2.5 2.5 0 0 1 0 5H17"/>
                    <line x1="4" y1="20" x2="17" y2="20"/>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $pendingOrders }} <span data-i18n="queue">Antrean</span>
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-3 py-0.5 rounded-full bg-[#E6F4EA] text-[#4E7D6B]" data-i18n="dash_needs_processing">
                    Perlu Segera Di Proses
                </span>
            </div>
        </div>

        <div class="bg-white rounded-[22px] border border-gray-200/90 shadow-[0_4px_10px_rgba(0,0,0,0.12)] p-5 flex flex-col justify-between">
            <div class="flex items-center justify-between text-gray-500">
                <span class="text-xs font-normal text-gray-500" data-i18n="dash_metric_products">Total Produk</span>
                <svg class="w-4 h-4 text-gray-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4v16h16"/>
                    <path d="M8 14h4"/>
                    <path d="M8 10h8"/>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $totalProducts }} <span data-i18n="nav_products_short">Produk</span>
                </span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-3 py-0.5 rounded-full bg-[#E6F4EA] text-[#4E7D6B]">
                    {{ $activeProducts }} <span class="ml-1" data-i18n="dash_active">Aktif</span>
                </span>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-3 py-0.5 rounded-full bg-[#FCE8E6] text-[#D9534F]">
                    {{ $outOfStockProducts }} <span class="ml-1" data-i18n="dash_out_of_stock">Habis</span>
                </span>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-stretch">

        <div class="lg:col-span-8 bg-white rounded-[24px] border border-gray-200/90 shadow-2xs overflow-hidden flex flex-col">
            <div class="px-6 py-4 flex items-center justify-between">
                <h3 class="font-bold text-base text-[#333333] tracking-tight" data-i18n="dash_latest_order">Pesanan Terbaru</h3>
                <a href="{{ route('admin.orders') }}" class="text-xs font-medium text-gray-600 hover:text-gray-900 transition inline-flex items-center gap-1 group min-h-[32px]">
                    <span data-i18n="dash_see_all">Lihat semua</span>
                    <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-center text-xs">
                    <thead>
                        <tr class="bg-[#F5F5F5] border-y border-gray-200/80 text-gray-600 font-normal text-xs">
                            <th class="py-3 px-4 font-normal" data-i18n="dash_col_order_num">No. Pesanan</th>
                            <th class="py-3 px-4 font-normal" data-i18n="dash_col_customer">Nama Pelanggan</th>
                            <th class="py-3 px-4 font-normal" data-i18n="dash_col_total">Total</th>
                            <th class="py-3 px-4 font-normal" data-i18n="dash_col_status">Status</th>
                            <th class="py-3 px-4 font-normal" data-i18n="dash_col_action">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/70">
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
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="py-5 px-4 font-mono font-bold text-gray-800 text-xs whitespace-nowrap">
                                    {{ $order->display_order_number ?? $order->order_number }}
                                </td>
                                <td class="py-5 px-4 text-gray-600 text-xs font-normal">
                                    {{ $order->customer_name ?: ($order->user->name ?? 'Pelanggan') }}
                                </td>
                                <td class="py-5 px-4 font-bold text-gray-800 text-xs whitespace-nowrap">
                                    <span data-i18n="currency">Rp</span> {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-5 px-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center gap-1.5 text-xs text-gray-700 font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                        <span data-i18n="{{ $statusConfig['key'] }}">{{ $statusConfig['label'] }}</span>
                                    </span>
                                </td>
                                <td class="py-5 px-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order->order_number) }}" class="inline-block bg-white hover:bg-gray-100 border border-gray-500 text-gray-700 font-normal px-4 py-0.5 rounded-full transition text-[11px]" data-i18n="dash_detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                    Belum ada pesanan terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-[24px] p-5 sm:p-6 border border-gray-200/90 shadow-2xs">
            <h3 class="font-bold text-base text-[#333333] pb-3.5 mb-4 border-b border-gray-100 tracking-tight" data-i18n="dash_best_selling">Menu Terlaris</h3>
            <div class="space-y-3">
                @forelse($topProducts as $idx => $item)
                    <div class="flex items-center gap-3.5 px-4 py-3 rounded-xl bg-[#EBEBEB] hover:bg-[#E2E2E2] transition">
                        <span class="w-6 h-6 rounded-full bg-[#3F5E5A] text-white font-bold text-xs flex items-center justify-center shrink-0">
                            {{ $idx + 1 }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-xs text-gray-900 truncate leading-tight">{{ $item->product_name }}</h4>
                            <span class="text-[10px] text-gray-500 font-normal block mt-0.5">{{ $item->total_qty }} <span data-i18n="dash_products_sold">Produk Terjual</span></span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-gray-400 text-xs">
                        Belum ada penjualan menu.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

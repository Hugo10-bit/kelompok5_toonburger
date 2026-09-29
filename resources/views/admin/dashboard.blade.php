@extends('layouts.admin')

@section('title', 'Dashboards - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-7">

    <!-- Greeting & Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
            <span>Hello, Toon Burger Admin.</span>
            <span>👋</span>
        </h1>
        <p class="text-xs sm:text-sm text-gray-400 mt-1 font-normal">Monitor Toon Burger's sales performance and active orders for today.</p>
    </div>

    <!-- Metrics grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        
        <!-- Metric 1: Today's Profits -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/80 shadow-xs p-5 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-medium text-gray-500">Today's Profits</span>
                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    IDR. {{ $todayRevenue > 0 ? number_format($todayRevenue, 0, ',', '.') : '500.000' }}
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#E8F8F0] text-[#10B981]">
                    Up 5% from yesterday.
                </span>
            </div>
        </div>

        <!-- Metric 2: Today's Orders -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/80 shadow-xs p-5 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-medium text-gray-500">Today's Orders</span>
                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                    <line x1="2" y1="10" x2="22" y2="10"></line>
                    <line x1="12" y1="14" x2="12" y2="18"></line>
                    <line x1="8" y1="18" x2="16" y2="18"></line>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $totalOrdersToday > 0 ? $totalOrdersToday : 50 }} Transaction
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#E8F8F0] text-[#10B981]">
                    Up 2% from yesterday.
                </span>
            </div>
        </div>

        <!-- Metric 3: Order in Progress -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/80 shadow-xs p-5 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-medium text-gray-500">Order in Progress</span>
                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                    <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                    <line x1="6" y1="1" x2="6" y2="4"></line>
                    <line x1="10" y1="1" x2="10" y2="4"></line>
                    <line x1="14" y1="1" x2="14" y2="4"></line>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $pendingOrders > 0 ? $pendingOrders : 9 }} Antrean
                </span>
            </div>
            <div>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#E8F8F0] text-[#10B981]">
                    Needs to be processed immediately.
                </span>
            </div>
        </div>

        <!-- Metric 4: Total Products -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/80 shadow-xs p-5 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-medium text-gray-500">Total Products</span>
                <svg class="w-4 h-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="7" y1="17" x2="17" y2="7"></line>
                    <polyline points="7 7 17 7 17 17"></polyline>
                </svg>
            </div>
            <div class="my-3">
                <span class="text-2xl sm:text-[26px] font-extrabold text-gray-900 tracking-tight block">
                    {{ $totalProducts > 0 ? $totalProducts : 24 }} Products
                </span>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#E8F8F0] text-[#10B981]">
                    {{ $activeProducts > 0 ? $activeProducts : 20 }} Active
                </span>
                <span class="inline-flex items-center text-[10px] sm:text-[11px] font-medium px-2.5 py-0.5 rounded-full bg-[#FEE2E2] text-[#EF4444]">
                    {{ $outOfStockProducts > 0 ? $outOfStockProducts : 2 }} Out Of Stocks
                </span>
            </div>
        </div>

    </div>

    <!-- Recent orders and best sellers -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-start">
        
        <div class="lg:col-span-8 bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-gray-200/80 shadow-xs">
            <div>
                <div class="flex items-center justify-between pb-4">
                    <h3 class="font-bold text-base text-gray-900 tracking-tight">Latest Order</h3>
                    <a href="{{ route('admin.orders') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-900 transition inline-flex items-center gap-1 group">
                        <span>See all</span>
                        <span class="transition-transform group-hover:translate-x-0.5">&rarr;</span>
                    </a>
                </div>

                <!-- Recent Orders Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-[#F8F9FA] text-gray-500 font-medium text-[11px]">
                                <th class="py-3 px-4 font-medium rounded-l-xl">Order Number</th>
                                <th class="py-3 px-4 font-medium">Customer Name</th>
                                <th class="py-3 px-4 font-medium">Total</th>
                                <th class="py-3 px-4 font-medium">Status</th>
                                <th class="py-3 px-4 font-medium text-center rounded-r-xl">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $displayOrders = [
                                    [
                                        'number' => 'TB-20260917-0007',
                                        'name' => 'Adzriel Fathi',
                                        'total' => 'IDR 66.000',
                                        'status' => 'Finished',
                                        'dot' => 'bg-[#3B82F6]',
                                        'url' => route('admin.orders'),
                                    ],
                                    [
                                        'number' => 'TB-20260917-0007',
                                        'name' => 'Hugo Putra',
                                        'total' => 'IDR 60.500',
                                        'status' => 'Ready to Serve',
                                        'dot' => 'bg-[#10B981]',
                                        'url' => route('admin.orders'),
                                    ],
                                    [
                                        'number' => 'TB-20260917-0007',
                                        'name' => 'Cornelius Hugo',
                                        'total' => 'IDR 126.500',
                                        'status' => 'Cooked',
                                        'dot' => 'bg-[#EF4444]',
                                        'url' => route('admin.orders'),
                                    ],
                                    [
                                        'number' => 'TB-20260917-0007',
                                        'name' => 'Rizki Prawira',
                                        'total' => 'IDR 87.500',
                                        'status' => 'Cooked',
                                        'dot' => 'bg-[#EF4444]',
                                        'url' => route('admin.orders'),
                                    ],
                                    [
                                        'number' => 'TB-20260917-0007',
                                        'name' => 'Waiz Fadillah',
                                        'total' => 'IDR 55.000',
                                        'status' => 'Waiting',
                                        'dot' => 'bg-[#F59E0B]',
                                        'url' => route('admin.orders'),
                                    ],
                                ];
                            @endphp

                            @foreach($displayOrders as $order)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="py-4 px-4 font-semibold text-gray-800 text-xs">
                                        {{ $order['number'] }}
                                    </td>
                                    <td class="py-4 px-4 text-gray-700 text-xs font-normal">
                                        {{ $order['name'] }}
                                    </td>
                                    <td class="py-4 px-4 font-bold text-gray-900 text-xs">
                                        {{ $order['total'] }}
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="inline-flex items-center gap-2 text-xs text-gray-800 font-medium">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $order['dot'] }}"></span>
                                            <span>{{ $order['status'] }}</span>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <a href="{{ $order['url'] }}" class="inline-block bg-white hover:bg-gray-50 border border-gray-300 hover:border-gray-400 text-gray-700 font-medium px-4 py-1 rounded-full transition text-[11px] shadow-2xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: BEST SELLING MENU (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 border border-gray-200/80 shadow-xs">
            <div>
                <h3 class="font-bold text-base text-gray-900 mb-4 tracking-tight">Best selling Menu</h3>
                <div class="space-y-2.5">
                    @php
                        $menuItems = [
                            ['name' => 'Cheese Chiken Burger', 'sold' => '179 Produk Terjual'],
                            ['name' => 'Very Cheese Burger', 'sold' => '170 Produk Terjual'],
                            ['name' => 'Double Beef Burger', 'sold' => '156 Produk Terjual'],
                            ['name' => 'BBQ Beef Burger', 'sold' => '150 Produk Terjual'],
                            ['name' => 'Hot Chiken Burger', 'sold' => '138 Produk Terjual'],
                        ];
                    @endphp

                    @foreach($menuItems as $idx => $item)
                        <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-[#F0F2F4] hover:bg-gray-200/60 transition">
                            <span class="w-6 h-6 rounded-full bg-[#3D5A58] text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-xs text-gray-900 truncate leading-tight">{{ $item['name'] }}</h4>
                                <span class="text-[10px] text-gray-400 font-normal block mt-0.5">{{ $item['sold'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

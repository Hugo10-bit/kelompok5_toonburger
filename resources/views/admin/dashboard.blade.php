@extends('layouts.admin')

@section('title', 'Dashboard - Toon Burger Admin')

@section('admin_content')
<!-- ═══ MAIN DASHBOARD CARD CONTAINER (ACCORDING TO MOCKUP) ═══ -->
<div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs p-6 sm:p-8 space-y-7">

    <!-- Greeting & Header -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
            <span>Halo, Admin Toon Burger</span>
            <span>👋</span>
        </h1>
        <p class="text-xs text-gray-400 mt-1">Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.</p>
    </div>

    <!-- ═══ 3 METRICS GRID ═══ -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6">
        
        <!-- Metric 1: Pendapatan Hari Ini -->
        <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs p-6 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-semibold text-gray-600">Pendapatan Hari Ini</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl font-black text-gray-900 font-mono-code tracking-tight block">
                    Rp. {{ number_format($todayRevenue, 0, ',', '.') }},00
                </span>
            </div>
            <div class="text-[10px] text-gray-400 font-medium">
                Total pendapatan bersih tercatat hari ini
            </div>
        </div>

        <!-- Metric 2: Pesanan Hari Ini -->
        <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs p-6 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-semibold text-gray-600">Pesanan Hari Ini</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight block">
                    {{ $totalOrdersToday }} Transaksi
                </span>
            </div>
            <div class="text-[10px] text-gray-400 font-medium">
                Total pesanan masuk dari semua kanal
            </div>
        </div>

        <!-- Metric 3: Pesanan dalam proses -->
        <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs p-6 flex flex-col justify-between hover:shadow-md transition">
            <div class="flex items-center justify-between text-gray-400">
                <span class="text-xs font-semibold text-gray-600">Pesanan dalam proses</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                </svg>
            </div>
            <div class="my-4">
                <span class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight block">
                    {{ $pendingOrders }} Antrean
                </span>
            </div>
            <div class="text-[10px] text-gray-400 font-medium">
                Sedang diproses & dimasak di dapur
            </div>
        </div>

    </div>

    <!-- ═══ LOWER SECTION: PESANAN TERBARU & MENU TERLARIS ═══ -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: PESANAN TERBARU (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between">
            <div>
                <!-- Table Header Row -->
                <div class="flex items-center justify-between pb-4">
                    <h3 class="font-extrabold text-sm tracking-wider uppercase text-gray-900">PESANAN TERBARU</h3>
                    <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-gray-500 hover:text-toon-granite transition inline-flex items-center gap-1">
                        <span>Lihat semua</span>
                        <span>&rarr;</span>
                    </a>
                </div>

                <!-- Recent Orders Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-gray-400 font-medium text-[11px] border-b border-gray-100">
                                <th class="pb-3 font-normal">No. Pesanan</th>
                                <th class="pb-3 font-normal">Nama pelanggan</th>
                                <th class="pb-3 font-normal">Total</th>
                                <th class="pb-3 font-normal text-center">Status</th>
                                <th class="pb-3 font-normal text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100/80">
                            @forelse($recentOrders as $ro)
                                <tr class="hover:bg-gray-50/70 transition">
                                    <td class="py-3 font-mono-code font-bold text-gray-800 text-[11px]">
                                        {{ $ro->order_number }}
                                    </td>
                                    <td class="py-3 font-semibold text-gray-800 text-xs">
                                        {{ $ro->customer_name }}
                                    </td>
                                    <td class="py-3 font-extrabold text-gray-900 text-xs font-mono-code">
                                        Rp {{ number_format($ro->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @if($ro->status === 'completed')
                                            <span class="px-3.5 py-1 rounded-full text-[10px] font-bold bg-[#4A5568] text-white">
                                                Selesai
                                            </span>
                                        @elseif($ro->status === 'ready')
                                            <span class="px-3.5 py-1 rounded-full text-[10px] font-bold bg-[#2F855A] text-white">
                                                Siap Saji
                                            </span>
                                        @elseif(in_array($ro->status, ['preparing', 'confirmed']))
                                            <span class="px-3.5 py-1 rounded-full text-[10px] font-bold bg-[#C1502D] text-white">
                                                Dimasak
                                            </span>
                                        @elseif($ro->status === 'cancelled')
                                            <span class="px-3.5 py-1 rounded-full text-[10px] font-bold bg-rose-700 text-white">
                                                Batal
                                            </span>
                                        @else
                                            <span class="px-3.5 py-1 rounded-full text-[10px] font-bold bg-[#D69E2E] text-white">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <a href="{{ route('orders.show', $ro->order_number) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold px-4 py-1 rounded-full transition text-[11px] inline-block shadow-2xs">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-400 text-xs">
                                        Belum ada pesanan terbaru hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Menu Terlaris (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between">
            <div>
                <h3 class="font-extrabold text-base text-gray-900 mb-4">Menu Terlaris</h3>
                <div class="space-y-2.5">
                    @forelse($topProducts as $idx => $tp)
                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#F8F9FA] hover:bg-gray-100/80 transition">
                            <span class="w-6 h-6 rounded-full bg-toon-granite text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <h4 class="font-extrabold text-xs text-gray-900 truncate leading-tight">{{ $tp->product_name }}</h4>
                                <span class="text-[10px] text-gray-400 font-medium block mt-0.5">{{ $tp->total_qty }} Produk Terjual</span>
                            </div>
                        </div>
                    @empty
                        @for($i = 1; $i <= 5; $i++)
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#F8F9FA]">
                                <span class="w-6 h-6 rounded-full bg-toon-granite text-white font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h4 class="font-extrabold text-xs text-gray-900 leading-tight">Cheese Chicken Burger</h4>
                                    <span class="text-[10px] text-gray-400 font-medium block mt-0.5">179 Produk Terjual</span>
                                </div>
                            </div>
                        @endfor
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

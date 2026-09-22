@extends('layouts.admin')

@section('title', 'Dashboard Analytics - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-7">
    
    <!-- Top Greeting & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 sm:p-7 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-black uppercase tracking-wider text-toon-granite bg-toon-cream px-2.5 py-0.5 rounded-full border border-toon-granite/20">Admin Panel</span>
                <span class="text-xs text-gray-400 font-semibold">• {{ now()->translatedFormat('l, d F Y') }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1 flex items-center gap-2">
                <span>Halo, Admin Toon Burger</span>
                <span class="inline-block animate-bounce">👋</span>
            </h1>
            <p class="text-xs text-gray-500 mt-1">Pantau performa penjualan, pesanan aktif, dan ketersediaan menu restoran Toon Burger hari ini.</p>
        </div>
        <div class="flex items-center gap-2.5 self-start sm:self-center">
            <a href="{{ route('admin.pos') }}" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold text-xs px-4 py-2.5 rounded-full shadow-sm transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buka POS Kasir</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="bg-white hover:bg-toon-cream text-toon-granite border border-toon-granite/30 font-bold text-xs px-4 py-2.5 rounded-full shadow-xs transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
                <span>Proses Pesanan</span>
            </a>
        </div>
    </div>

    <!-- METRICS GRID (SESUAI MOCKUP FOTO) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Metric 1: Total Pendapatan -->
        <div class="bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs flex items-center gap-4 hover:shadow-md transition">
            <div class="w-13 h-13 rounded-2xl bg-toon-granite/10 text-toon-granite flex items-center justify-center font-black text-sm flex-shrink-0 border border-toon-granite/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-xl sm:text-2xl font-black text-gray-900 font-mono-code truncate block">
                    Rp {{ number_format($todayRevenue, 0, ',', '.') }},00
                </span>
                <span class="text-[10px] font-semibold text-emerald-600 block mt-0.5">Hari ini tercatat</span>
            </div>
        </div>

        <!-- Metric 2: Total Transaksi -->
        <div class="bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs flex items-center gap-4 hover:shadow-md transition">
            <div class="w-13 h-13 rounded-2xl bg-toon-wheat text-toon-granite flex items-center justify-center font-black text-sm flex-shrink-0 border border-[#E0C89F]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Total Pesanan</span>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block truncate">
                    {{ $totalOrdersToday }} Transaksi
                </span>
                <span class="text-[10px] font-semibold text-gray-500 block mt-0.5">Semua kanal pemesanan</span>
            </div>
        </div>

        <!-- Metric 3: Pesanan Antrean / Dalam Proses -->
        <div class="bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs flex items-center gap-4 hover:shadow-md transition">
            <div class="w-13 h-13 rounded-2xl bg-toon-rust/10 text-toon-rust flex items-center justify-center font-black text-sm flex-shrink-0 border border-toon-rust/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Dalam Proses</span>
                <span class="text-xl sm:text-2xl font-black text-toon-rust block truncate">
                    {{ $pendingOrders }} Antrean
                </span>
                <span class="text-[10px] font-semibold text-amber-600 block mt-0.5">Perlu disiapkan dapur</span>
            </div>
        </div>

        <!-- Metric 4: Okupansi Meja Restoran -->
        <div class="bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs flex items-center gap-4 hover:shadow-md transition">
            <div class="w-13 h-13 rounded-2xl bg-toon-cream text-toon-granite flex items-center justify-center font-black text-sm flex-shrink-0 border border-[#E2D5BA]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="min-w-0">
                <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Okupansi Meja</span>
                <span class="text-xl sm:text-2xl font-black text-gray-900 block truncate">
                    {{ $occupiedTables }} / {{ $totalTables }} Terisi
                </span>
                <span class="text-[10px] font-semibold text-gray-500 block mt-0.5">Dine-in aktif saat ini</span>
            </div>
        </div>

    </div>

    <!-- RECENT ORDERS & TOP PRODUCTS (SESUAI MOCKUP FOTO) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-7">
        
        <!-- Pesanan Terbaru Table (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-extrabold text-base text-gray-900">Pesanan Terbaru</h3>
                    <p class="text-[11px] text-gray-400">Daftar transaksi masuk dan proses pengerjaan</p>
                </div>
                <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-toon-granite hover:underline flex items-center gap-1 bg-toon-cream px-3 py-1.5 rounded-full">
                    <span>Lihat Semua</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-gray-400 font-bold border-b border-gray-100 uppercase text-[10px] tracking-wider">
                            <th class="pb-3">No. Order</th>
                            <th class="pb-3">Pemesan</th>
                            <th class="pb-3">Tipe / Meja</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $ro)
                            <tr class="hover:bg-toon-cream/30 transition">
                                <td class="py-3.5 font-mono-code font-bold text-toon-granite">
                                    {{ $ro->order_number }}
                                </td>
                                <td class="py-3.5 font-semibold text-gray-800">
                                    {{ $ro->customer_name }}
                                </td>
                                <td class="py-3.5 font-medium text-gray-500">
                                    <span class="inline-flex items-center gap-1 bg-gray-100 px-2 py-0.5 rounded text-[11px] font-semibold text-gray-700 uppercase">
                                        {{ str_replace('_', ' ', $ro->order_type) }}
                                        @if($ro->table) <strong class="text-toon-granite font-black">({{ $ro->table->table_number }})</strong> @endif
                                    </span>
                                </td>
                                <td class="py-3.5">
                                    @if($ro->status === 'completed')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Selesai
                                        </span>
                                    @elseif(in_array($ro->status, ['preparing', 'confirmed']))
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-toon-wheat text-toon-granite border border-[#E0C89F]">
                                            Diproses
                                        </span>
                                    @elseif($ro->status === 'ready')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-blue-100 text-blue-800 border border-blue-200">
                                            Siap Saji
                                        </span>
                                    @elseif($ro->status === 'cancelled')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-red-100 text-toon-rust border border-red-200">
                                            Batal
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 font-black text-gray-900 font-mono-code">
                                    Rp {{ number_format($ro->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('orders.show', $ro->order_number) }}" target="_blank" class="bg-toon-cream hover:bg-toon-wheat text-toon-granite font-bold px-3 py-1.5 rounded-full transition text-[11px] inline-flex items-center gap-1">
                                        <span>Detail</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    Belum ada pesanan masuk hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Menu Terlaris (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs space-y-4">
            <div class="pb-3 border-b border-gray-100">
                <h3 class="font-extrabold text-base text-gray-900">Menu Terlaris</h3>
                <p class="text-[11px] text-gray-400">Paling banyak dipesan pelanggan</p>
            </div>

            <div class="space-y-3">
                @forelse($topProducts as $idx => $tp)
                    <div class="flex items-center justify-between p-3 rounded-2xl bg-toon-cream/40 border border-[#EFE5D0] text-xs hover:bg-toon-cream/80 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-6 rounded-full {{ $idx === 0 ? 'bg-toon-granite text-white font-black' : ($idx === 1 ? 'bg-toon-wheat text-toon-granite font-bold' : 'bg-gray-200 text-gray-700 font-bold') }} flex items-center justify-center text-[11px] flex-shrink-0">
                                {{ $idx + 1 }}
                            </span>
                            <div>
                                <h4 class="font-bold text-gray-900 leading-tight">{{ $tp->product_name }}</h4>
                                <span class="text-gray-400 text-[10px] font-semibold">{{ $tp->total_qty }} porsi terjual</span>
                            </div>
                        </div>
                        <div class="font-bold text-toon-granite font-mono-code text-right text-xs">
                            Rp {{ number_format($tp->total_sales, 0, ',', '.') }}
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-400 text-xs">
                        Belum ada data penjualan menu.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div class="flex items-center gap-3.5">
            <div class="w-12 h-12 rounded-2xl bg-toon-cream border border-toon-granite/20 flex items-center justify-center text-toon-granite shrink-0 shadow-xs">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-toon-dark tracking-tight">Proses Pesanan</h1>
                <p class="text-xs text-gray-500 mt-0.5">Kelola antrean pesanan & pembaruan dapur secara real-time.</p>
            </div>
        </div>

        <div class="flex items-center flex-wrap gap-2.5 self-start sm:self-center">
            <!-- Auto-Refresh Toggle Button -->
            <button id="btn-toggle-autorefresh" type="button" class="bg-toon-cream/70 hover:bg-toon-cream text-toon-granite border border-toon-granite/20 text-xs font-bold px-3.5 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 select-none">
                <span id="autorefresh-dot" class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="autorefresh-text">Auto-Refresh: <strong id="autorefresh-countdown">30s</strong></span>
            </button>

            <!-- Manual Refresh Button -->
            <button onclick="window.location.reload()" class="bg-white hover:bg-toon-cream text-toon-granite border border-toon-granite/30 text-xs font-bold px-4 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Segarkan</span>
            </button>
        </div>
    </div>

    <!-- STATUS FILTER TABS -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs font-bold scrollbar-thin">
        <!-- ALL -->
        <a href="{{ route('admin.orders', ['status' => 'all']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'all' ? 'bg-toon-granite text-white shadow-sm ring-2 ring-toon-granite/20' : 'bg-white text-toon-dark hover:bg-toon-cream border border-[#E6DEC8]' }}">
            <span>Semua Antrean</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-toon-cream text-toon-dark' }}">{{ $counts['all'] }}</span>
        </a>

        <!-- MENUNGGU (PENDING) -->
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-600 text-white shadow-sm ring-2 ring-amber-500/30' : 'bg-white text-toon-dark hover:bg-amber-50 border border-[#E6DEC8]' }}">
            <span class="w-2 h-2 rounded-full {{ $status === 'pending' ? 'bg-white' : 'bg-amber-500' }}"></span>
            <span>Menunggu</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'pending' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-900' }}">{{ $counts['pending'] }}</span>
        </a>

        <!-- DIKONFIRMASI -->
        <a href="{{ route('admin.orders', ['status' => 'confirmed']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'confirmed' ? 'bg-blue-600 text-white shadow-sm ring-2 ring-blue-500/30' : 'bg-white text-toon-dark hover:bg-blue-50 border border-[#E6DEC8]' }}">
            <span>Dikonfirmasi</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'confirmed' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-900' }}">{{ $counts['confirmed'] }}</span>
        </a>

        <!-- SEDANG DIMASAK -->
        <a href="{{ route('admin.orders', ['status' => 'preparing']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'preparing' ? 'bg-toon-wheat text-toon-granite font-extrabold shadow-sm ring-2 ring-toon-wheat/50 border border-[#E0C89F]' : 'bg-white text-toon-dark hover:bg-toon-cream border border-[#E6DEC8]' }}">
            <svg class="w-3.5 h-3.5 {{ $status === 'preparing' ? 'text-toon-granite animate-spin' : 'text-toon-slate' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Sedang Dimasak</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'preparing' ? 'bg-toon-granite/15 text-toon-granite font-black' : 'bg-toon-wheat/60 text-toon-granite' }}">{{ $counts['preparing'] }}</span>
        </a>

        <!-- SIAP SAJI -->
        <a href="{{ route('admin.orders', ['status' => 'ready']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'ready' ? 'bg-teal-600 text-white shadow-sm ring-2 ring-teal-500/30' : 'bg-white text-toon-dark hover:bg-teal-50 border border-[#E6DEC8]' }}">
            <span>Siap Saji</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'ready' ? 'bg-white/20 text-white' : 'bg-teal-100 text-teal-900' }}">{{ $counts['ready'] }}</span>
        </a>

        <!-- SELESAI -->
        <a href="{{ route('admin.orders', ['status' => 'completed']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'completed' ? 'bg-emerald-700 text-white shadow-sm ring-2 ring-emerald-600/30' : 'bg-white text-toon-dark hover:bg-emerald-50 border border-[#E6DEC8]' }}">
            <span>Selesai</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'completed' ? 'bg-white/20 text-white' : 'bg-emerald-50 text-emerald-900' }}">{{ $counts['completed'] }}</span>
        </a>

        <!-- DIBATALKAN -->
        <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" 
           class="px-4 py-2.5 rounded-full transition flex items-center gap-2 whitespace-nowrap {{ $status === 'cancelled' ? 'bg-rose-700 text-white shadow-sm ring-2 ring-rose-600/30' : 'bg-white text-toon-dark hover:bg-rose-50 border border-[#E6DEC8]' }}">
            <span>Dibatalkan</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'cancelled' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-800' }}">{{ $counts['cancelled'] }}</span>
        </a>
    </div>

    <!-- ORDERS GRID -->
    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-[#E6DEC8] shadow-xs">
            <div class="w-16 h-16 rounded-full bg-toon-cream text-toon-granite flex items-center justify-center mx-auto mb-4 border border-toon-granite/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <h3 class="text-base font-extrabold text-gray-900">Tidak ada pesanan dalam status ini</h3>
            <p class="text-xs text-gray-500 max-w-sm mx-auto mt-1">Saat ada pesanan baru atau status diperbarui, pesanan akan segera tampil di antrean ini.</p>
            @if($status !== 'all')
                <div class="mt-4">
                    <a href="{{ route('admin.orders', ['status' => 'all']) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-toon-granite bg-toon-cream hover:bg-toon-wheat/50 px-4 py-2 rounded-full border border-toon-granite/20 transition">
                        <span>Lihat Semua Antrean</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($orders as $order)
                @php
                    $isUrgent = in_array($order->status, ['pending', 'preparing']) && $order->created_at->diffInMinutes(now()) >= 15;
                @endphp
                <div class="bg-white rounded-3xl border-2 {{ in_array($order->status, ['pending', 'confirmed', 'preparing']) ? 'border-toon-granite/40 shadow-md ring-1 ring-toon-granite/10' : 'border-[#E6DEC8] shadow-xs' }} p-5 flex flex-col justify-between space-y-4 hover:shadow-lg transition">
                    
                    <!-- Card Top Area -->
                    <div class="space-y-3.5">
                        <!-- Header: Order ID, Time, Urgency & Status Badges -->
                        <div class="flex items-start justify-between gap-2 pb-3 border-b border-gray-100">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <span class="font-mono-code font-black text-xs text-toon-granite bg-toon-cream px-2.5 py-1 rounded-full border border-toon-granite/20">
                                        #{{ $order->order_number }}
                                    </span>
                                    @if($isUrgent)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full animate-pulse" title="Pesanan menunggu lebih dari 15 menit">
                                            <span>⚠️</span>
                                            <span>&gt;15 Menit</span>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $order->created_at->diffForHumans() }}</span>
                                    <span class="text-gray-300">&bull;</span>
                                    <span class="font-mono-code">{{ $order->created_at->format('H:i') }}</span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end gap-1">
                                <!-- Process Status Badge -->
                                @if($order->status === 'completed')
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Selesai
                                    </span>
                                @elseif($order->status === 'ready')
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-teal-100 text-teal-800 border border-teal-200">
                                        Siap Saji
                                    </span>
                                @elseif($order->status === 'preparing')
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-toon-wheat text-toon-granite border border-[#E0C89F] flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-toon-granite animate-ping"></span>
                                        <span>Memasak</span>
                                    </span>
                                @elseif($order->status === 'confirmed')
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        Dikonfirmasi
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-200">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        Menunggu
                                    </span>
                                @endif

                                <!-- Payment Status Badge -->
                                @if($order->payment_status === 'paid')
                                    <span class="text-[9px] font-black tracking-wider uppercase px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Lunas
                                    </span>
                                @else
                                    <span class="text-[9px] font-black tracking-wider uppercase px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-200">
                                        Belum Lunas
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Customer Info & Service Type -->
                        <div class="py-1 text-xs flex items-center justify-between gap-2">
                            <div class="min-w-0">
                                <strong class="text-gray-900 block text-sm font-bold truncate">{{ $order->customer_name }}</strong>
                                @if($order->customer_phone)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->customer_phone)) }}" 
                                       target="_blank" 
                                       class="text-toon-granite hover:underline text-[11px] inline-flex items-center gap-1 mt-0.5 font-medium">
                                        <svg class="w-3 h-3 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-2.222-.559-1.954-.809-3.21-2.793-3.308-2.923-.098-.13-1.04-1.385-1.04-2.641 0-1.256.653-1.874.887-2.13.235-.256.512-.321.684-.321.173 0 .346.002.497.01.161.008.375-.061.587.447.218.523.743 1.815.808 1.948.065.133.109.289.022.464-.087.174-.131.282-.26.433-.13.15-.274.336-.391.452-.131.13-.267.272-.115.534.152.261.677 1.116 1.453 1.808.998.889 1.839 1.164 2.1 1.295.261.13.414.108.567-.066.153-.174.654-.761.828-1.023.174-.261.348-.218.587-.13.239.087 1.524.718 1.785.848.261.13.435.195.499.304.066.109.066.63-.078 1.035z"/>
                                        </svg>
                                        <span>{{ $order->customer_phone }}</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-[11px]">-</span>
                                @endif
                            </div>
                            
                            <!-- Order Type Badge -->
                            <div class="shrink-0 text-right">
                                <span class="font-extrabold text-xs uppercase bg-toon-cream text-toon-granite px-3 py-1 rounded-full border border-toon-granite/20 inline-flex items-center gap-1.5 shadow-2xs">
                                    @if($order->order_type === 'dine_in')
                                        <svg class="w-3.5 h-3.5 text-toon-rust" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <span>Dine In</span>
                                        @if($order->table)
                                            <span class="text-toon-rust font-black">&bull; Meja {{ $order->table->table_number }}</span>
                                        @endif
                                    @else
                                        <svg class="w-3.5 h-3.5 text-toon-granite" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        <span>{{ str_replace('_', ' ', $order->order_type) }}</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Items List (Ticket Format) -->
                        <div class="bg-toon-cream/40 border border-[#EFE5D0] rounded-2xl p-3.5 space-y-2.5 text-xs">
                            @foreach($order->items as $item)
                                <div class="flex items-start justify-between gap-3 border-b border-gray-200/50 pb-2 last:border-0 last:pb-0">
                                    <div class="space-y-1 min-w-0">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            @if($item->quantity > 1)
                                                <span class="bg-toon-granite text-white font-mono-code font-black text-[11px] px-1.5 py-0.5 rounded shadow-2xs">
                                                    {{ $item->quantity }}x
                                                </span>
                                            @else
                                                <span class="bg-gray-200 text-gray-800 font-mono-code font-bold text-[11px] px-1.5 py-0.5 rounded">
                                                    1x
                                                </span>
                                            @endif
                                            <span class="font-extrabold text-gray-900 leading-snug">{{ $item->product_name }}</span>
                                        </div>

                                        <!-- Options / Toppings -->
                                        @if($item->options->isNotEmpty())
                                            <div class="text-[11px] text-gray-600 pl-6 flex items-center gap-1 flex-wrap">
                                                <span class="text-gray-400">+</span>
                                                <span class="bg-white/80 border border-gray-200 px-2 py-0.5 rounded text-[10px] font-medium">
                                                    {{ $item->options->pluck('option_value_name')->implode(', ') }}
                                                </span>
                                            </div>
                                        @endif

                                        <!-- Customer Notes (High Visibility Callout) -->
                                        @if($item->notes)
                                            <div class="bg-amber-50 border border-amber-300 text-amber-950 px-2 py-1 rounded-lg text-[11px] font-semibold flex items-start gap-1.5 ml-6">
                                                <svg class="w-3.5 h-3.5 text-toon-rust shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                                <span class="leading-tight"><strong class="text-toon-rust font-bold">Catatan:</strong> "{{ $item->notes }}"</span>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-700 font-mono-code shrink-0 text-right">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Bottom Area: Total & Actions -->
                    <div class="pt-3 border-t border-gray-100 space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-semibold">Total Tagihan:</span>
                            <span class="font-black text-base text-toon-granite font-mono-code">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>

                        <!-- 1-Click Status Advance Form -->
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="grid grid-cols-2 gap-2 text-xs">
                            @csrf
                            
                            @if($order->status === 'pending')
                                <button type="submit" name="status" value="confirmed" class="col-span-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-full transition shadow-xs flex items-center justify-center gap-2 active:scale-98">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Konfirmasi Pesanan</span>
                                </button>
                            @elseif($order->status === 'confirmed')
                                <button type="submit" name="status" value="preparing" class="col-span-2 bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 rounded-full transition shadow-xs flex items-center justify-center gap-2 active:scale-98">
                                    <svg class="w-4 h-4 text-toon-wheat" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                                    </svg>
                                    <span>Mulai Memasak di Dapur</span>
                                </button>
                            @elseif($order->status === 'preparing')
                                <button type="submit" name="status" value="ready" class="col-span-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 rounded-full transition shadow-xs flex items-center justify-center gap-2 active:scale-98">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Pesanan Siap Saji</span>
                                </button>
                            @elseif($order->status === 'ready')
                                <button type="submit" name="status" value="completed" class="col-span-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 rounded-full transition shadow-xs flex items-center justify-center gap-2 active:scale-98">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Selesaikan Pesanan</span>
                                </button>
                            @endif

                            <!-- Quick Mark as Paid Button (If not yet paid) -->
                            @if($order->payment_status !== 'paid')
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" name="status" value="{{ $order->status }}" class="col-span-2 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-300 font-bold py-2 rounded-full text-xs transition flex items-center justify-center gap-1.5 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Tandai Lunas (Kasir)</span>
                                </button>
                            @endif
                        </form>

                        <!-- Card Footer Links -->
                        <div class="flex justify-between items-center text-[11px] pt-1">
                            <a href="{{ route('orders.show', $order->order_number) }}" target="_blank" class="text-toon-granite hover:underline font-bold inline-flex items-center gap-1 transition">
                                <span>Buka Struk / Invoice</span>
                                <span>&rarr;</span>
                            </a>
                            
                            @if(!in_array($order->status, ['completed', 'cancelled']))
                                <form id="form-cancel-{{ $order->id }}" action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="button" onclick="confirmCancelOrder('{{ $order->id }}', '{{ $order->order_number }}')" class="text-toon-rust hover:text-toon-rust-dark font-bold hover:underline transition">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-6">
            {{ $orders->links() }}
        </div>
    @endif

</div>

<!-- SCRIPT: SweetAlert Cancel & Persistent Auto-Refresh -->
<script>
    // SweetAlert Order Cancellation
    function confirmCancelOrder(orderId, orderNumber) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Batalkan Pesanan #' + orderNumber + '?',
                text: 'Pesanan yang dibatalkan akan mengembalikan ketersediaan meja dan tidak dapat diproses lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C1502D',
                cancelButtonColor: '#466967',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Kembali',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-3xl shadow-2xl font-sans',
                    confirmButton: 'rounded-full px-5 py-2.5 font-bold',
                    cancelButton: 'rounded-full px-5 py-2.5 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-cancel-' + orderId).submit();
                }
            });
        } else {
            if (confirm('Batalkan pesanan #' + orderNumber + '?')) {
                document.getElementById('form-cancel-' + orderId).submit();
            }
        }
    }

    // Auto-Refresh Logic (persisted in localStorage)
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('btn-toggle-autorefresh');
        const dot = document.getElementById('autorefresh-dot');
        const text = document.getElementById('autorefresh-text');
        const countdownEl = document.getElementById('autorefresh-countdown');
        
        let intervalSec = 30;
        let timeLeft = intervalSec;
        let timer = null;
        let isEnabled = localStorage.getItem('admin_orders_autorefresh') !== 'false';

        function updateUI() {
            if (isEnabled) {
                dot.className = 'w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse';
                text.innerHTML = 'Auto-Refresh: <strong id="autorefresh-countdown">' + timeLeft + 's</strong>';
            } else {
                dot.className = 'w-2.5 h-2.5 rounded-full bg-gray-400';
                text.innerHTML = 'Auto-Refresh: <strong>Mati</strong>';
            }
        }

        function startTimer() {
            if (timer) clearInterval(timer);
            timeLeft = intervalSec;
            updateUI();

            timer = setInterval(function () {
                if (!isEnabled) return;
                timeLeft--;
                const countdown = document.getElementById('autorefresh-countdown');
                if (countdown) countdown.textContent = timeLeft + 's';

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    window.location.reload();
                }
            }, 1000);
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                isEnabled = !isEnabled;
                localStorage.setItem('admin_orders_autorefresh', isEnabled ? 'true' : 'false');
                if (isEnabled) {
                    startTimer();
                } else {
                    if (timer) clearInterval(timer);
                    updateUI();
                }
            });
        }

        if (isEnabled) {
            startTimer();
        } else {
            updateUI();
        }
    });
</script>
@endsection

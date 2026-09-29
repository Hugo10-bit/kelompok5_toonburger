@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <!-- Header Section (Sesuai Mockup Foto Board 11) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Proses Pesanan</h1>
            <p class="text-xs text-gray-400 mt-1">Kelola alur dan status pesanan pelanggan secara realtime.</p>
        </div>

        <div class="flex items-center gap-2.5">
            <button onclick="window.location.reload()" class="bg-[#F4F5F7] hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-full transition flex items-center gap-2 active:scale-95 shadow-2xs select-none">
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                <span>Segarkan</span>
            </button>
        </div>
    </div>

    <!-- Status Filter Tabs (Persis Mockup Foto Board 11 - 15) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold scrollbar-none select-none">
        <!-- 1. Semua -->
        <a href="{{ route('admin.orders', ['status' => 'all']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'all' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Semua</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['all'] }})</span>
        </a>

        <!-- 2. Menunggu -->
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'pending' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Menunggu</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['pending'] }})</span>
        </a>

        <!-- 3. Diproses -->
        <a href="{{ route('admin.orders', ['status' => 'diproses']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'diproses' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Diproses</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['diproses'] }})</span>
        </a>

        <!-- 4. Siap Diambil -->
        <a href="{{ route('admin.orders', ['status' => 'ready']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'ready' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Siap Diambil</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['ready'] }})</span>
        </a>

        <!-- 5. Selesai -->
        <a href="{{ route('admin.orders', ['status' => 'completed']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'completed' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Selesai</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['completed'] }})</span>
        </a>

        <!-- 6. Dibatalkan -->
        <a href="{{ route('admin.orders', ['status' => 'cancelled']) }}" 
           class="px-5 py-2 rounded-full transition whitespace-nowrap {{ $status === 'cancelled' ? 'bg-[#385A56] text-white font-bold shadow-xs' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80' }}">
            <span>Dibatalkan</span>
            <span class="ml-1 text-[11px] opacity-80">({{ $counts['cancelled'] }})</span>
        </a>
    </div>

    <!-- Orders Cards Grid (Persis Mockup Foto Board 11 - 15) -->
    @if($orders->isEmpty())
        <div class="py-16 text-center border border-gray-200/80 rounded-2xl">
            <div class="w-14 h-14 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <h3 class="text-sm font-bold text-gray-800">Tidak ada pesanan dalam status ini</h3>
            <p class="text-xs text-gray-400 max-w-xs mx-auto mt-1">Saat ada pesanan baru masuk, pesanan akan segera tampil di sini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 flex flex-col justify-between space-y-4 hover:shadow-md transition">
                    
                    <!-- Top Area: Order ID & Status Badge -->
                    <div class="space-y-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-extrabold text-sm text-gray-900 tracking-tight">
                                    #{{ $order->order_number }}
                                </h4>
                                <div class="text-[11px] text-gray-400 mt-0.5">
                                    {{ $order->created_at->format('d M Y, H:i') }} WIB
                                </div>
                            </div>

                            <!-- Status Badge (Sesuai Foto) -->
                            <div>
                                @if($order->status === 'completed')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Selesai
                                    </span>
                                @elseif($order->status === 'ready')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-teal-100 text-teal-800 border border-teal-200">
                                        Siap Diambil
                                    </span>
                                @elseif(in_array($order->status, ['preparing', 'confirmed']))
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                        Diproses
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-800 border border-rose-200">
                                        Dibatalkan
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                        Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Customer Info -->
                        <div class="flex items-center justify-between text-xs text-gray-700">
                            <span class="font-bold text-gray-900">{{ $order->customer_name }}</span>
                            <span class="text-gray-400 text-[11px]">
                                {{ $order->restaurant_table_id ? 'Meja ' . ($order->table->table_number ?? $order->restaurant_table_id) : ($order->order_type === 'takeaway' ? 'Take Away' : 'Dine In') }}
                            </span>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Items List -->
                        <div class="space-y-1.5 text-xs max-h-36 overflow-y-auto pr-1">
                            @foreach($order->items as $item)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-700 font-medium">
                                        {{ $item->quantity }}x {{ $item->product_name }}
                                    </span>
                                    <span class="font-bold text-gray-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <hr class="border-gray-100">

                        <!-- Total Line -->
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-xs text-gray-900 uppercase tracking-wide">Total</span>
                            <span class="font-black text-sm text-gray-900">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Bottom Action Area (Sesuai Mockup Foto) -->
                    <div class="space-y-2 pt-2">
                        <!-- Primary Action Button -->
                        @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-4 rounded-full text-xs shadow-xs transition select-none">
                                    Terima Pesanan
                                </button>
                            </form>
                        @elseif(in_array($order->status, ['confirmed', 'preparing']))
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="ready">
                                <button type="submit" class="w-full bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-4 rounded-full text-xs shadow-xs transition select-none">
                                    Pesanan Siap
                                </button>
                            </form>
                        @elseif($order->status === 'ready')
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="completed">
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" class="w-full bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-4 rounded-full text-xs shadow-xs transition select-none">
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        @elseif($order->status === 'completed')
                            <div class="w-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-center font-bold py-2 px-4 rounded-full text-xs">
                                Pesanan Selesai
                            </div>
                        @else
                            <div class="w-full bg-rose-50 text-rose-700 border border-rose-200 text-center font-bold py-2 px-4 rounded-full text-xs">
                                Pesanan Dibatalkan
                            </div>
                        @endif

                        <!-- Secondary Links (Detail & Batalkan) -->
                        <div class="flex items-center justify-between text-[11px] pt-1 px-1">
                            <a href="{{ route('orders.show', $order->order_number) }}" target="_blank" class="text-gray-500 hover:text-gray-800 font-semibold transition">
                                Lihat Detail
                            </a>

                            @if(!in_array($order->status, ['completed', 'cancelled']))
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan #{{ $order->order_number }}?')">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="text-[#DE3B28] hover:text-red-700 font-semibold transition">
                                        Tolak Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection

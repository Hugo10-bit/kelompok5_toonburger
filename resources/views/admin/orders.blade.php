@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Proses Pesanan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola dan update proses memasak pesanan dapur secara real-time.</p>
        </div>
        <button onclick="window.location.reload()" class="bg-white hover:bg-toon-cream text-toon-granite border border-toon-granite/30 text-xs font-bold px-4 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Refresh Antrean</span>
        </button>
    </div>

    <!-- STATUS TABS (SESUAI MOCKUP FOTO) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 text-xs font-bold">
        <a href="{{ route('admin.orders', ['status' => 'all']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'all' ? 'bg-toon-granite text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-toon-cream border border-[#E6DEC8]' }}">
            <span>Semua Antrean</span>
            <span class="bg-white/20 px-2 py-0.5 rounded-full text-[10px]">{{ $counts['all'] }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'pending' ? 'bg-amber-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-amber-50 border border-[#E6DEC8]' }}">
            <span>Menunggu</span>
            <span class="bg-amber-100 text-amber-900 px-2 py-0.5 rounded-full text-[10px]">{{ $counts['pending'] }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'confirmed']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'confirmed' ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-blue-50 border border-[#E6DEC8]' }}">
            <span>Dikonfirmasi</span>
            <span class="bg-blue-100 text-blue-900 px-2 py-0.5 rounded-full text-[10px]">{{ $counts['confirmed'] }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'preparing']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'preparing' ? 'bg-toon-wheat text-toon-granite font-extrabold shadow-sm border border-[#E0C89F]' : 'bg-white text-gray-700 hover:bg-toon-cream border border-[#E6DEC8]' }}">
            <span>Sedang Dimasak</span>
            <span class="bg-toon-granite/10 text-toon-granite px-2 py-0.5 rounded-full text-[10px]">{{ $counts['preparing'] }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'ready']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'ready' ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-teal-50 border border-[#E6DEC8]' }}">
            <span>Siap Saji</span>
            <span class="bg-teal-100 text-teal-900 px-2 py-0.5 rounded-full text-[10px]">{{ $counts['ready'] }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="px-4 py-2 rounded-full transition flex items-center gap-1.5 whitespace-nowrap {{ $status === 'completed' ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-emerald-50 border border-[#E6DEC8]' }}">
            <span>Selesai</span>
            <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full text-[10px]">{{ $counts['completed'] }}</span>
        </a>
    </div>

    <!-- ORDERS GRID (SESUAI MOCKUP FOTO) -->
    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-[#E6DEC8] shadow-xs">
            <div class="w-14 h-14 rounded-full bg-toon-cream text-toon-granite flex items-center justify-center mx-auto mb-3">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <h3 class="text-sm font-extrabold text-gray-800">Tidak ada pesanan dalam status ini</h3>
            <p class="text-xs text-gray-400 mt-1">Pesanan masuk yang baru akan muncul di sini secara otomatis.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl border-2 {{ in_array($order->status, ['pending', 'confirmed', 'preparing']) ? 'border-toon-granite/40 shadow-md' : 'border-[#E6DEC8] shadow-xs' }} p-5 flex flex-col justify-between space-y-4 hover:shadow-lg transition">
                    
                    <!-- Header -->
                    <div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                            <div>
                                <span class="font-mono-code font-black text-xs text-toon-granite bg-toon-cream px-2.5 py-1 rounded-full border border-toon-granite/20">
                                    {{ $order->order_number }}
                                </span>
                                <div class="text-[10px] text-gray-400 mt-1">{{ $order->created_at->diffForHumans() }}</div>
                            </div>

                            <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-full {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : ($order->status === 'preparing' ? 'bg-toon-wheat text-toon-granite border border-[#E0C89F]' : ($order->status === 'ready' ? 'bg-teal-100 text-teal-800 border border-teal-200' : 'bg-amber-100 text-amber-800 border border-amber-200')) }}">
                                {{ $order->status }}
                            </span>
                        </div>

                        <!-- Customer & Table -->
                        <div class="py-3 text-xs text-gray-700 flex items-center justify-between">
                            <div>
                                <strong class="text-gray-900 block text-sm">{{ $order->customer_name }}</strong>
                                <span class="text-gray-400 text-[11px]">{{ $order->customer_phone ?: '-' }}</span>
                            </div>
                            <span class="font-black text-xs uppercase bg-toon-cream text-toon-granite px-3 py-1 rounded-full border border-toon-granite/15">
                                {{ str_replace('_', ' ', $order->order_type) }}
                                @if($order->table) &bull; {{ $order->table->table_number }} @endif
                            </span>
                        </div>

                        <!-- Items List -->
                        <div class="bg-toon-cream/35 border border-[#EFE5D0] rounded-2xl p-3 space-y-2 text-xs">
                            @foreach($order->items as $item)
                                <div class="flex items-start justify-between">
                                    <div>
                                        <span class="font-bold text-gray-900">{{ $item->quantity }}x {{ $item->product_name }}</span>
                                        @if($item->options->isNotEmpty())
                                            <div class="text-[10px] text-gray-500">
                                                {{ $item->options->pluck('option_value_name')->implode(', ') }}
                                            </div>
                                        @endif
                                        @if($item->notes)
                                            <div class="text-[10px] text-toon-rust font-medium italic">[Catatan] "{{ $item->notes }}"</div>
                                        @endif
                                    </div>
                                    <span class="font-bold text-gray-700 font-mono-code">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Actions & Status Update Buttons -->
                    <div class="pt-3 border-t border-gray-100 space-y-2.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-semibold">Total Tagihan:</span>
                            <span class="font-black text-base text-toon-granite font-mono-code">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>

                        <!-- 1-Click Status Advance Form -->
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="grid grid-cols-2 gap-2 text-xs">
                            @csrf
                            
                            @if($order->status === 'pending')
                                <button type="submit" name="status" value="confirmed" class="col-span-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-full transition shadow-xs">
                                    Konfirmasi Pesanan
                                </button>
                            @elseif($order->status === 'confirmed')
                                <button type="submit" name="status" value="preparing" class="col-span-2 bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 rounded-full transition shadow-xs">
                                    Mulai Memasak di Dapur
                                </button>
                            @elseif($order->status === 'preparing')
                                <button type="submit" name="status" value="ready" class="col-span-2 bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 rounded-full transition shadow-xs">
                                    Pesanan Siap Saji
                                </button>
                            @elseif($order->status === 'ready')
                                <button type="submit" name="status" value="completed" class="col-span-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold py-2.5 rounded-full transition shadow-xs">
                                    Selesaikan Pesanan
                                </button>
                            @endif

                            @if($order->payment_status !== 'paid')
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" name="status" value="{{ $order->status }}" class="col-span-2 bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold py-1.5 rounded-full text-[11px] hover:bg-emerald-100">
                                    Tandai Lunas (Kasir)
                                </button>
                            @endif
                        </form>

                        <div class="flex justify-between items-center text-[11px] pt-1">
                            <a href="{{ route('orders.show', $order->order_number) }}" target="_blank" class="text-toon-granite hover:underline font-bold inline-flex items-center gap-1">
                                <span>Buka Struk / Invoice</span>
                                <span>&rarr;</span>
                            </a>
                            
                            @if(!in_array($order->status, ['completed', 'cancelled']))
                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf
                                    <input type="hidden" name="status" value="cancelled">
                                    <button type="submit" class="text-toon-rust hover:underline font-bold">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection

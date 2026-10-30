@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-9 lg:p-10 flex-1">
    <div class="mb-7">
        <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] tracking-tight leading-tight" data-i18n="ord_title">Proses pesanan</h1>
        <p class="text-sm sm:text-[15px] text-gray-500 mt-1.5" data-i18n="ord_sub">Kelola dan konfirmasi pesanan yang masuk hari ini.</p>
    </div>

    <div class="flex flex-wrap items-center gap-3.5 mb-8">
        <a href="{{ route('admin.orders') }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ !request('status') ? 'bg-[#415C58] text-white' : 'bg-white border border-gray-400 text-gray-600 hover:bg-gray-50' }}">
            <span data-i18n="tab_all">Semua</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ !request('status') ? 'bg-white/25 text-white' : 'bg-gray-300/80 text-gray-700' }}">{{ $countAll }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'pending' ? 'bg-[#415C58] text-white' : 'bg-white border border-gray-400 text-gray-600 hover:bg-gray-50' }}">
            <span data-i18n="tab_pending">Menunggu</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'pending' ? 'bg-white/25 text-white' : 'bg-gray-300/80 text-gray-700' }}">{{ $countPending }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'diproses']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'diproses' ? 'bg-[#415C58] text-white' : 'bg-white border border-gray-400 text-gray-600 hover:bg-gray-50' }}">
            <span data-i18n="tab_cooking">Dimasak</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'diproses' ? 'bg-white/25 text-white' : 'bg-gray-300/80 text-gray-700' }}">{{ $countCooking }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'ready']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'ready' ? 'bg-[#415C58] text-white' : 'bg-white border border-gray-400 text-gray-600 hover:bg-gray-50' }}">
            <span data-i18n="tab_ready">Siap Saji</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'ready' ? 'bg-white/25 text-white' : 'bg-gray-300/80 text-gray-700' }}">{{ $countReady }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'completed' ? 'bg-[#415C58] text-white' : 'bg-white border border-gray-400 text-gray-600 hover:bg-gray-50' }}">
            <span data-i18n="tab_completed">Selesai</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'completed' ? 'bg-white/25 text-white' : 'bg-gray-300/80 text-gray-700' }}">{{ $countCompleted }}</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
        @forelse($orders as $order)
            @php
                $badgeConfig = match($order->status) {
                    'pending' => [
                        'bg' => 'bg-[#F9E7B2] text-[#5C4D26]',
                        'label' => 'Menunggu',
                        'i18n' => 'st_pending',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"></path></svg>',
                    ],
                    'confirmed', 'preparing' => [
                        'bg' => 'bg-[#E6A8A1] text-[#5A2520]',
                        'label' => 'Dimasak',
                        'i18n' => 'st_cooking',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4v2m4-2v2m4-2v2M4 11h14a1 1 0 011 1v2a5 5 0 01-5 5H9a5 5 0 01-5-5v-2a1 1 0 011-1zm15 1h1.5a1.5 1.5 0 010 3H19"></path></svg>',
                    ],
                    'ready' => [
                        'bg' => 'bg-[#C8E6C9] text-[#255A2A]',
                        'label' => 'Siap Saji',
                        'i18n' => 'st_ready',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>',
                    ],
                    'completed' => [
                        'bg' => 'bg-[#BBDEFB] text-[#1E3A8A]',
                        'label' => 'Selesai',
                        'i18n' => 'st_completed',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    ],
                    'cancelled' => [
                        'bg' => 'bg-red-100 text-red-700',
                        'label' => 'Batal',
                        'i18n' => 'st_cancelled',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    ],
                    default => [
                        'bg' => 'bg-gray-100 text-gray-700',
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

                $minsAgo = max(1, (int) abs(now()->diffInMinutes($order->created_at)));
                $relativeLabel = $order->notes && str_contains($order->notes, 'Menit')
                    ? $order->notes
                    : ($minsAgo . ' Menit yang lalu');
            @endphp

            <div class="bg-white rounded-[26px] border border-gray-200/90 shadow-[0_4px_12px_rgba(0,0,0,0.08)] p-6 flex flex-col justify-between">
                <div>
                    <div class="mb-3.5">
                        <span class="bg-[#F0F2F5] text-gray-800 font-mono font-bold text-xs px-3.5 py-1.5 rounded-md inline-block tracking-wide">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex items-start justify-between gap-2 mb-3.5">
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900 leading-tight">{{ $order->customer_name }}</h3>
                            <p class="text-xs text-gray-400 mt-1">{{ $relativeLabel }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-md text-xs font-semibold inline-flex items-center gap-1.5 {{ $badgeConfig['bg'] }}">
                            {!! $badgeConfig['icon'] !!}
                            <span @if($badgeConfig['i18n']) data-i18n="{{ $badgeConfig['i18n'] }}" @endif>{{ $badgeConfig['label'] }}</span>
                        </span>
                    </div>

                    <div class="border-t border-gray-200 pt-3 pb-3">
                        <div class="grid grid-cols-12 text-xs text-gray-400 mb-2">
                            <span class="col-span-6">Produk</span>
                            <span class="col-span-2 text-center">total</span>
                            <span class="col-span-4 text-right">Harga</span>
                        </div>
                        <div class="space-y-1.5">
                            @foreach($order->items as $item)
                            <div class="grid grid-cols-12 text-xs sm:text-[13px] text-gray-800 font-medium">
                                <span class="col-span-6 truncate pr-1">{{ $item->product_name }}</span>
                                <span class="col-span-2 text-center">{{ $item->quantity }}</span>
                                <span class="col-span-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <div class="border-t border-gray-200 pt-3 mb-3.5 flex items-center justify-between">
                        <span class="text-base font-bold text-gray-900">Total</span>
                        <span class="text-base font-extrabold text-gray-900">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    @if($nextStatus)
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                        <button type="submit" class="w-full bg-[#415C58] hover:bg-[#344B48] text-white font-medium py-3 px-4 rounded-xl text-xs sm:text-[13.5px] transition-colors cursor-pointer" data-i18n="btn_confirm_order">
                            konfirmasi pesanan
                        </button>
                    </form>
                    @else
                    <div class="w-full bg-gray-100 text-gray-500 font-medium py-3 px-4 rounded-xl text-xs sm:text-[13.5px] text-center">
                        {{ $order->status == 'completed' ? 'Pesanan Selesai' : 'Pesanan Dibatalkan' }}
                    </div>
                    @endif

                    <div class="flex items-center justify-between text-xs pt-3">
                        <a href="{{ route('admin.orders.show', $order->order_number) }}" class="text-[#4A7C9B] hover:underline font-medium" data-i18n="btn_detail">Lihat Detail Pesanan</a>
                        @if(!in_array($order->status, ['completed', 'cancelled']))
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirm('Batalkan pesanan ini?');">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit" class="text-[#E53935] hover:underline font-medium cursor-pointer" data-i18n="btn_cancel">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                <p class="text-gray-500 text-sm font-medium" data-i18n="ord_empty">Belum ada pesanan pada kategori status ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

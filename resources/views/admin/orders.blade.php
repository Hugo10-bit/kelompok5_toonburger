@extends('layouts.admin')

@section('title', 'Proses Pesanan - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-6 sm:p-9 lg:p-10 flex-1">
    <div class="mb-7">
        <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="ord_title">Proses pesanan</h1>
        <p class="text-sm sm:text-[15px] text-gray-500 dark:text-[#D4D4D4] mt-1.5" data-i18n="ord_sub">Kelola dan konfirmasi pesanan yang masuk hari ini.</p>
    </div>

    <div class="flex flex-wrap items-center gap-3.5 mb-8">
        <a href="{{ route('admin.orders') }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ !request('status') ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_all">Semua</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ !request('status') ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countAll }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'pending']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'pending' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_pending">Menunggu</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'pending' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countPending }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'diproses']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'diproses' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_cooking">Dimasak</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'diproses' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countCooking }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'ready']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'ready' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_ready">Siap Saji</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'ready' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countReady }}</span>
        </a>
        <a href="{{ route('admin.orders', ['status' => 'completed']) }}" class="px-4 py-2 min-h-[42px] rounded-lg text-sm font-medium transition-colors flex items-center gap-2.5 {{ request('status') == 'completed' ? 'bg-[#415C58] text-white' : 'bg-white dark:bg-[#383838] border border-gray-400 dark:border-[#555555] text-gray-600 dark:text-[#E0E0E0] hover:bg-gray-50 dark:hover:bg-[#444444]' }}">
            <span data-i18n="tab_completed">Selesai</span>
            <span class="w-6 h-6 rounded-full text-xs font-bold inline-flex items-center justify-center {{ request('status') == 'completed' ? 'bg-white/25 text-white' : 'bg-gray-300/80 dark:bg-[#4F4F4F] text-gray-700 dark:text-white' }}">{{ $countCompleted }}</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">
        @forelse($orders as $order)
            @php
                $badgeConfig = match($order->status) {
                    'pending' => [
                        'bg' => 'bg-[#F9E7B2] dark:bg-[#4A3A20] text-[#5C4D26] dark:text-[#FBBF24] border border-transparent dark:border-amber-700/50',
                        'label' => 'Menunggu',
                        'i18n' => 'st_pending',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"></path></svg>',
                    ],
                    'confirmed', 'preparing' => [
                        'bg' => 'bg-[#E6A8A1] dark:bg-[#4A2626] text-[#5A2520] dark:text-[#F87171] border border-transparent dark:border-red-800/50',
                        'label' => 'Dimasak',
                        'i18n' => 'st_cooking',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 4v2m4-2v2m4-2v2M4 11h14a1 1 0 011 1v2a5 5 0 01-5 5H9a5 5 0 01-5-5v-2a1 1 0 011-1zm15 1h1.5a1.5 1.5 0 010 3H19"></path></svg>',
                    ],
                    'ready' => [
                        'bg' => 'bg-[#C8E6C9] dark:bg-[#1E453B] text-[#255A2A] dark:text-[#34D399] border border-transparent dark:border-emerald-700/50',
                        'label' => 'Siap Saji',
                        'i18n' => 'st_ready',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>',
                    ],
                    'completed' => [
                        'bg' => 'bg-[#BBDEFB] dark:bg-[#243852] text-[#1E3A8A] dark:text-[#60A5FA] border border-transparent dark:border-blue-700/50',
                        'label' => 'Selesai',
                        'i18n' => 'st_completed',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                    ],
                    'cancelled' => [
                        'bg' => 'bg-red-100 dark:bg-red-950/60 text-red-700 dark:text-red-400 border border-transparent dark:border-red-900/50',
                        'label' => 'Batal',
                        'i18n' => 'st_cancelled',
                        'icon' => '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>',
                    ],
                    default => [
                        'bg' => 'bg-gray-100 dark:bg-[#3D3D3D] text-gray-700 dark:text-gray-200 border border-transparent dark:border-gray-700',
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
                $rawNotes = $order->notes ? str_ireplace('menityang', 'menit yang', $order->notes) : '';
                $relativeLabel = $rawNotes && (stripos($rawNotes, 'menit') !== false || stripos($rawNotes, 'jam') !== false)
                    ? $rawNotes
                    : ($minsAgo . ' Menit yang lalu');
            @endphp

            <div class="bg-white dark:bg-[#3C3C3C] rounded-[26px] border border-gray-200/90 dark:border-[#525252] shadow-[0_4px_12px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_12px_rgba(0,0,0,0.35)] p-6 flex flex-col justify-between">
                <div>
                    <div class="mb-3.5">
                        <span class="bg-[#F0F2F5] dark:bg-[#4F4F4F] text-gray-800 dark:text-white font-mono font-bold text-xs px-3.5 py-1.5 rounded-md inline-block tracking-wide">{{ $order->order_number }}</span>
                    </div>

                    <div class="flex items-start justify-between gap-2 mb-3.5">
                        <div>
                            <h3 class="text-xl font-extrabold text-gray-900 dark:text-white leading-tight">{{ $order->customer_name }}</h3>
                            <p class="text-xs text-gray-400 dark:text-gray-300 mt-1" data-mins-ago="{{ $minsAgo }}">{{ $relativeLabel }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-md text-xs font-semibold inline-flex items-center gap-1.5 {{ $badgeConfig['bg'] }}">
                            {!! $badgeConfig['icon'] !!}
                            <span @if($badgeConfig['i18n']) data-i18n="{{ $badgeConfig['i18n'] }}" @endif>{{ $badgeConfig['label'] }}</span>
                        </span>
                    </div>

                    <div class="border-t border-gray-200 dark:border-[#555555] pt-3 pb-3">
                        <div class="grid grid-cols-12 text-xs text-gray-400 dark:text-gray-300 font-medium mb-2">
                            <span class="col-span-6" data-i18n="ord_col_prod">Produk</span>
                            <span class="col-span-2 text-center" data-i18n="ord_col_qty">total</span>
                            <span class="col-span-4 text-right" data-i18n="ord_col_price">Harga</span>
                        </div>
                        <div class="space-y-1.5">
                            @foreach($order->items as $item)
                            <div class="grid grid-cols-12 text-xs sm:text-[13px] text-gray-800 dark:text-[#E5E5E5] font-medium">
                                <span class="col-span-6 truncate pr-1">{{ $item->product_name }}</span>
                                <span class="col-span-2 text-center">{{ $item->quantity }}</span>
                                <span class="col-span-4 text-right"><span data-i18n="currency">Rp</span> {{ number_format($item->price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <div class="border-t border-gray-200 dark:border-[#555555] pt-3 mb-3.5 flex items-center justify-between">
                        <span class="text-base font-bold text-gray-900 dark:text-white" data-i18n="ord_total_label">Total</span>
                        <span class="text-base font-extrabold text-gray-900 dark:text-white"><span data-i18n="currency">Rp</span> {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>

                    @if($nextStatus)
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ $nextStatus }}">
                        <button type="button"
                                onclick="confirmProcessOrder(this, '{{ $nextStatus }}', '{{ $order->order_number }}')"
                                class="w-full bg-[#415C58] hover:bg-[#344B48] active:scale-98 text-white font-medium py-3 px-4 rounded-xl text-xs sm:text-[13.5px] transition-all cursor-pointer flex items-center justify-center gap-2"
                                data-i18n="btn_confirm_order">
                            <span>konfirmasi pesanan</span>
                        </button>
                    </form>
                    @else
                    <div class="w-full bg-gray-100 dark:bg-[#444444] text-gray-700 dark:!text-white font-semibold py-3 px-4 rounded-xl text-xs sm:text-[13.5px] text-center border border-transparent dark:border-[#555555]" data-i18n="{{ $order->status == 'completed' ? 'ord_done_badge' : 'ord_cancel_badge' }}">
                        {{ $order->status == 'completed' ? 'Pesanan Selesai' : 'Pesanan Dibatalkan' }}
                    </div>
                    @endif

                    <div class="flex items-center justify-between text-xs pt-3">
                        <a href="{{ route('admin.orders.show', $order->order_number) }}" class="text-[#4A7C9B] dark:text-[#93C5FD] hover:underline font-medium" data-i18n="btn_detail">Lihat Detail Pesanan</a>
                        @if(!in_array($order->status, ['completed', 'cancelled']))
                        <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button type="button"
                                    onclick="confirmCancelOrder(this, '{{ $order->order_number }}')"
                                    class="text-[#E53935] dark:text-[#FCA5A5] hover:underline font-medium cursor-pointer"
                                    data-i18n="btn_cancel">Batalkan</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-gray-50 dark:bg-[#353535] rounded-2xl border border-dashed border-gray-200 dark:border-[#555555]">
                <p class="text-gray-500 dark:text-[#D4D4D4] text-sm font-medium" data-i18n="ord_empty">Belum ada pesanan pada kategori status ini.</p>
            </div>
        @endforelse
    </div>
</div>

<script src="{{ asset('js/admin/orders.js') }}"></script>
@endsection

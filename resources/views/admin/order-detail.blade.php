@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <!-- Header Section (Sesuai Mockup Figma) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight" data-i18n="order_detail_title">Detail Pesanan</h1>
            <p class="text-xs text-gray-400 mt-1" data-i18n="order_detail_subtitle">Konfirmasi dan kelola status pesanan ini.</p>
            <div class="flex items-center gap-2.5 mt-3 flex-wrap">
                <span class="bg-[#F3F4F6] text-gray-800 font-mono text-xs font-extrabold px-3 py-1 rounded-md border border-gray-200/60 tracking-wider">
                    {{ $order->order_number }}
                </span>
                <span class="text-xs text-gray-400 font-medium">
                    {{ $order->created_at->format('d M Y, H.i') }} WITA
                </span>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.orders') }}" class="bg-[#F4F5F7] hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-full transition flex items-center gap-2 active:scale-95 shadow-2xs select-none">
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span data-i18n="order_detail_back">Kembali ke Proses Pesanan</span>
            </a>
        </div>
    </div>

    <!-- 1. Card Status Dapur & Stepper (Persis Mockup Figma) -->
    <div class="border border-gray-200/80 rounded-2xl p-6 sm:p-7 bg-white shadow-2xs space-y-6">
        <!-- Top Row Status & Payment -->
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <span class="text-[11px] font-medium text-gray-400 block mb-1" data-i18n="order_detail_kitchen_status">Status Dapur</span>
                <div class="flex items-center gap-2 font-extrabold text-sm sm:text-base text-gray-900">
                    @if($order->status === 'pending')
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                        <span data-i18n="order_status_kitchen_pending">• Menunggu Konfirmasi</span>
                    @elseif($order->status === 'confirmed')
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 inline-block"></span>
                        <span data-i18n="order_status_kitchen_confirmed">• Pesanan Dikonfirmasi</span>
                    @elseif($order->status === 'preparing')
                        <span class="w-2.5 h-2.5 rounded-full bg-[#EF4444] inline-block"></span>
                        <span data-i18n="order_status_kitchen_preparing">• Pesanan Sedang Dimasak</span>
                    @elseif($order->status === 'ready')
                        <span class="w-2.5 h-2.5 rounded-full bg-teal-500 inline-block"></span>
                        <span data-i18n="order_status_kitchen_ready">• Pesanan Siap Saji</span>
                    @elseif($order->status === 'completed')
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 inline-block"></span>
                        <span data-i18n="order_status_kitchen_completed">• Pesanan Selesai</span>
                    @elseif($order->status === 'cancelled')
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-600 inline-block"></span>
                        <span data-i18n="order_status_kitchen_cancelled">• Pesanan Dibatalkan</span>
                    @endif
                </div>
            </div>

            <div class="text-right">
                <span class="text-[11px] font-medium text-gray-400 block mb-1" data-i18n="order_detail_payment_status">Status Pembayaran</span>
                @if($order->payment_status === 'paid')
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-[#D1FAE5]/60 text-[#065F46] border border-[#A7F3D0]/60">
                        <span data-i18n="order_detail_paid">Lunas</span>&nbsp;({{ strtolower($order->payment_method) === 'qris' ? 'QRIS' : ucfirst($order->payment_method ?: 'Cash') }})
                    </span>
                @elseif($order->payment_status === 'refunded')
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                        <span data-i18n="order_detail_refunded">Refund</span>
                    </span>
                @else
                    <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                        <span data-i18n="order_detail_unpaid">Belum Lunas</span>&nbsp;({{ strtolower($order->payment_method) === 'qris' ? 'QRIS' : ucfirst($order->payment_method ?: 'Cash') }})
                    </span>
                @endif
            </div>
        </div>

        <!-- 4-Step Stepper -->
        @php
            $step = match($order->status) {
                'pending' => 1,
                'confirmed', 'preparing' => 2,
                'ready' => 3,
                'completed' => 4,
                default => 0,
            };
        @endphp
        <div class="pt-2 pb-4 px-2 sm:px-8">
            <div class="relative flex items-center justify-between">
                <!-- Background Track Line -->
                <div class="absolute left-[12.5%] right-[12.5%] top-[22px] -translate-y-1/2 h-[4px] bg-[#E5E7EB] z-0"></div>

                <!-- Active Progress Line -->
                @if($step > 1)
                    <div class="absolute left-[12.5%] top-[22px] -translate-y-1/2 h-[4px] bg-[#F5B025] z-0 transition-all duration-300"
                         style="width: {{ $step === 2 ? '25%' : ($step === 3 ? '50%' : '75%') }};"></div>
                @endif

                <!-- 1. Menunggu -->
                <div class="relative z-10 flex flex-col items-center w-1/4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 1 ? 'bg-[#F5B025] text-gray-900 shadow-2xs' : 'bg-[#E5E7EB] text-gray-500' }}">
                        1
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-2.5 text-center" data-i18n="stepper_pending">Menunggu</span>
                </div>

                <!-- 2. Dimasak -->
                <div class="relative z-10 flex flex-col items-center w-1/4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 2 ? 'bg-[#F5B025] text-gray-900 shadow-2xs' : 'bg-[#E5E7EB] text-gray-500' }}">
                        2
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-2.5 text-center" data-i18n="stepper_cooking">Dimasak</span>
                </div>

                <!-- 3. Siap Saji -->
                <div class="relative z-10 flex flex-col items-center w-1/4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 3 ? 'bg-[#F5B025] text-gray-900 shadow-2xs' : 'bg-[#E5E7EB] text-gray-500' }}">
                        3
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-2.5 text-center" data-i18n="stepper_ready">Siap Saji</span>
                </div>

                <!-- 4. Selesai -->
                <div class="relative z-10 flex flex-col items-center w-1/4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm {{ $step >= 4 ? 'bg-[#F5B025] text-gray-900 shadow-2xs' : 'bg-[#E5E7EB] text-gray-500' }}">
                        4
                    </div>
                    <span class="text-xs font-semibold text-gray-700 mt-2.5 text-center" data-i18n="stepper_completed">Selesai</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Card Informasi Pemesan (Persis Mockup Figma) -->
    <div class="border border-gray-200/80 rounded-2xl p-6 sm:p-7 bg-white shadow-2xs">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-left">
            <div>
                <span class="text-xs font-medium text-gray-400 block mb-1" data-i18n="order_detail_order_type">Tipe Pesanan</span>
                <span class="text-sm font-bold text-gray-900 block">
                    @if($order->restaurant_table_id)
                        Dine In (<span data-i18n="order_detail_table">Meja</span> {{ $order->table->table_number ?? $order->restaurant_table_id }})
                    @elseif(in_array(strtolower($order->order_type ?? ''), ['pickup', 'pickup order']))
                        Pickup Order
                    @elseif(strtolower($order->order_type ?? '') === 'takeaway')
                        Takeaway
                    @else
                        {{ ucfirst($order->order_type ?: 'Pickup Order') }}
                    @endif
                </span>
            </div>

            <div>
                <span class="text-xs font-medium text-gray-400 block mb-1" data-i18n="order_detail_customer_name">Nama Pemesan</span>
                <span class="text-sm font-bold text-gray-900 block">{{ $order->customer_name }}</span>
            </div>

            <div>
                <span class="text-xs font-medium text-gray-400 block mb-1" data-i18n="order_detail_customer_phone">No. Telepon</span>
                <span class="text-sm font-bold text-gray-900 block">{{ $order->customer_phone ?: '-' }}</span>
            </div>

            <div>
                <span class="text-xs font-medium text-gray-400 block mb-1" data-i18n="order_detail_payment_method">Metode Pembayaran</span>
                <span class="text-sm font-bold text-gray-900 block">
                    {{ strtolower($order->payment_method) === 'qris' ? 'QRIS' : ucfirst($order->payment_method ?: 'Cash') }}
                </span>
            </div>
        </div>
    </div>

    <!-- 3. Card Catatan Pesanan (Persis Mockup Figma) -->
    <div class="border border-gray-200/80 rounded-2xl p-6 sm:p-7 bg-white shadow-2xs space-y-2">
        <span class="text-xs font-medium text-gray-400 block" data-i18n="order_detail_notes">Catatan Pesanan</span>
        <div class="bg-[#F5F5F5] rounded-xl p-4 text-xs sm:text-sm text-gray-600 font-medium">
            @if($order->notes)
                {{ $order->notes }}
            @else
                <span data-i18n="order_detail_no_notes">Tanpa catatan</span>
            @endif
        </div>
    </div>

    <!-- 4. Card Rincian Pesanan (Persis Mockup Figma) -->
    <div class="border border-gray-200/80 rounded-2xl p-6 sm:p-7 bg-white shadow-2xs space-y-4">
        <h3 class="text-xs font-bold text-gray-700 tracking-wider" data-i18n="order_detail_items_title">Rincian Pesanan</h3>

        <div class="space-y-2.5">
            @foreach($order->items as $item)
                <div class="bg-[#F5F5F5] rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <h4 class="font-bold text-xs sm:text-sm text-gray-900">{{ $item->product_name }}</h4>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item->quantity }}x <span data-i18n="currency">Rp</span> {{ number_format($item->price, 0, ',', '.') }}</p>
                        @if(!empty($item->notes))
                            <p class="text-[11px] text-gray-500 mt-0.5 italic"><span data-i18n="order_detail_item_note">Catatan:</span> {{ $item->notes }}</p>
                        @endif
                    </div>
                    <div class="font-extrabold text-xs sm:text-sm text-gray-900">
                        <span data-i18n="currency">Rp</span> {{ number_format($item->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        @if($order->tax_amount > 0 || $order->discount_amount > 0)
            <div class="pt-2 border-t border-gray-100 space-y-1.5 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span data-i18n="order_detail_subtotal">Subtotal</span>
                    <span class="font-bold"><span data-i18n="currency">Rp</span> {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-emerald-600">
                        <span data-i18n="order_detail_discount">Diskon</span>
                        <span class="font-bold">-<span data-i18n="currency">Rp</span> {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                @if($order->tax_amount > 0)
                    <div class="flex justify-between">
                        <span data-i18n="order_detail_tax">Pajak</span>
                        <span class="font-bold"><span data-i18n="currency">Rp</span> {{ number_format($order->tax_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>
        @endif

        <div class="pt-3 border-t border-gray-200/80 flex items-center justify-between">
            <span class="font-extrabold text-sm sm:text-base text-gray-900" data-i18n="order_detail_total">Total</span>
            <span class="font-black text-base sm:text-lg text-gray-900">
                <span data-i18n="currency">Rp</span> {{ number_format($order->total_amount, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <!-- 5. Card Aksi Pengelolaan Admin -->
    <div class="border border-gray-200/80 rounded-2xl p-6 sm:p-7 bg-white shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <button type="button" onclick="window.print()" class="bg-[#F4F5F7] hover:bg-gray-200 text-gray-700 font-bold text-xs px-4 py-2.5 rounded-full transition flex items-center gap-2 shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span data-i18n="order_detail_print_receipt">Cetak Struk</span>
            </button>
        </div>

        <div class="flex items-center gap-3 flex-wrap justify-end">
            @if($order->status === 'pending')
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="preparing">
                    <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full text-xs shadow-xs transition cursor-pointer">
                        <span data-i18n="order_detail_accept_cook">Terima & Masak Pesanan</span>
                    </button>
                </form>
            @elseif(in_array($order->status, ['confirmed', 'preparing']))
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="ready">
                    <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full text-xs shadow-xs transition cursor-pointer">
                        <span data-i18n="order_detail_mark_ready">Tandai Siap Saji</span>
                    </button>
                </form>
            @elseif($order->status === 'ready')
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full text-xs shadow-xs transition cursor-pointer">
                        <span data-i18n="order_detail_complete">Selesaikan Pesanan</span>
                    </button>
                </form>
            @endif

            @if(!in_array($order->status, ['completed', 'cancelled']))
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" onsubmit="return confirmCancelOrder()">
                    @csrf
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="text-[#DE3B28] hover:bg-red-50 border border-red-200 font-bold py-2.5 px-5 rounded-full text-xs transition cursor-pointer">
                        <span data-i18n="order_detail_cancel">Batalkan Pesanan</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>

<script>
    function confirmCancelOrder() {
        const isEn = (window._tbLang === 'EN' || window._tbLang === 'US' || localStorage.getItem('tb_admin_lang') === 'US' || localStorage.getItem('tb_admin_lang') === 'EN');
        return confirm(isEn ? 'Are you sure you want to cancel this order?' : 'Apakah Anda yakin ingin membatalkan pesanan ini?');
    }
</script>
@endsection

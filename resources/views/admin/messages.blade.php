@extends('layouts.admin')

@section('title', 'Pesan Terbaru - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#303030] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-5 sm:p-8 lg:p-9 flex-1 flex flex-col">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-[28px] font-bold text-[#262626] dark:text-white tracking-tight leading-tight" data-i18n="messages_title">Pesan Terbaru</h1>
            <p class="text-xs sm:text-sm text-[#6B7280] dark:text-[#C4C9D0] mt-1" data-i18n="messages_subtitle">Ulasan dan catatan masukan pelanggan dari pesanan yang telah selesai.</p>
        </div>

        <form action="{{ route('admin.messages') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <select name="rating"
                    onchange="this.form.submit()"
                    aria-label="Filter rating ulasan"
                    class="bg-white dark:bg-[#3F3F3F] border border-gray-300 dark:border-[#555555] text-gray-700 dark:text-white text-xs font-medium rounded-xl px-3.5 py-2.5 min-h-[44px] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D] cursor-pointer">
                <option id="opt-all-ratings" data-count="{{ $totalCount }}" value="all" {{ $rating === 'all' ? 'selected' : '' }} data-i18n="messages_filter_all">Semua Rating ({{ $totalCount }})</option>
                @for($star = 5; $star >= 1; $star--)
                    <option value="{{ $star }}" {{ (string) $rating === (string) $star ? 'selected' : '' }}>{{ $star }} / 5</option>
                @endfor
            </select>

            @if($rating !== 'all' || $search !== '')
                <a href="{{ route('admin.messages') }}"
                   class="inline-flex items-center justify-center px-3.5 py-2.5 min-h-[44px] rounded-xl border border-gray-300 dark:border-[#555555] text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#3D3D3D] transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D]"
                   data-i18n="messages_reset_filter">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    @if($messages instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $messages->count() > 0)
        <div class="space-y-3.5 flex-1">
            @foreach($messages as $msg)
                @php
                    $senderName = $msg->order->customer_name ?? $msg->user->name ?? 'Pelanggan Toon Burger';
                    $initials = strtoupper(substr(trim($senderName), 0, 2));
                @endphp
                <article class="rounded-2xl border border-gray-200/90 dark:border-[#4A4A4A] bg-[#F8F9FA] dark:bg-[#3A3A3A] p-4 sm:p-5 transition">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-[#40605D] text-white font-semibold text-xs flex items-center justify-center shrink-0">
                                {{ $initials }}
                            </div>
                            <div class="min-w-0">
                                <h2 class="text-sm font-semibold text-[#222222] dark:text-white truncate">{{ $senderName }}</h2>
                                <div class="flex flex-wrap items-center gap-2 text-[11px] text-[#5F6672] dark:text-[#D1D5DB] mt-0.5">
                                    <span>{{ $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '-' }}</span>
                                    @if($msg->product)
                                        <span>&bull;</span>
                                        <span class="font-medium">{{ $msg->product->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 self-start sm:self-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold bg-[#E6F4EE] text-[#13653F] dark:bg-[#1E453B] dark:text-[#6EE7B7]">
                                <span>Rating: {{ $msg->rating }}/5</span>
                            </span>
                            @if($msg->order)
                                <a href="{{ route('admin.orders.show', $msg->order->order_number) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-2 min-h-[40px] rounded-xl bg-white dark:bg-[#303030] border border-gray-300 dark:border-[#555555] text-xs font-medium text-[#222222] dark:text-white hover:bg-gray-50 dark:hover:bg-[#444444] transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D]">
                                    <span>{{ $msg->order->order_number }}</span>
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <p class="mt-3 text-xs sm:text-sm text-[#374151] dark:text-[#E5E7EB] leading-relaxed">
                        {{ $msg->comment ?: 'Pelanggan memberikan penilaian bintang tanpa catatan tambahan.' }}
                    </p>
                </article>
            @endforeach
        </div>

        @if($messages->hasPages())
            <div class="mt-6 pt-4 border-t border-gray-100 dark:border-[#3F3F3F]">
                {{ $messages->links() }}
            </div>
        @endif
    @else
        <div class="flex-1 flex flex-col items-center justify-center text-center py-14 px-4 rounded-2xl border border-dashed border-gray-200 dark:border-[#4A4A4A] bg-[#FAFAFB] dark:bg-[#383838]/50">
            <div class="w-12 h-12 rounded-2xl bg-[#E8EFEE] dark:bg-[#3F4E4C] text-[#40605D] dark:text-[#8CC0B9] flex items-center justify-center mb-3.5">
                <svg class="w-6 h-6" viewBox="0 -960 960 960" fill="currentColor" aria-hidden="true">
                    <path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/>
                </svg>
            </div>
            @if($rating !== 'all' || $search !== '')
                <h2 class="text-base font-bold text-[#262626] dark:text-white" data-i18n="messages_empty_filtered_title">Tidak ada pesan yang sesuai dengan filter</h2>
                <p class="text-xs sm:text-sm text-[#5F6672] dark:text-[#C4C9D0] mt-1 max-w-md" data-i18n="messages_empty_filtered_desc">Ubah pilihan rating atau hapus kata kunci pencarian untuk melihat seluruh pesan pelanggan.</p>
                <a href="{{ route('admin.messages') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-[#40605D] hover:bg-[#344B48] text-white text-xs font-medium px-5 py-2.5 min-h-[44px] rounded-xl transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D]"
                   data-i18n="messages_show_all">
                    Tampilkan Semua Pesan
                </a>
            @else
                <h2 class="text-base font-bold text-[#262626] dark:text-white" data-i18n="messages_empty_title">Belum ada pesan pelanggan yang masuk</h2>
                <p class="text-xs sm:text-sm text-[#5F6672] dark:text-[#C4C9D0] mt-1 max-w-md" data-i18n="messages_empty_desc">Pesan dan ulasan akan otomatis muncul di halaman ini setelah pelanggan menyelesaikan pesanan dan mengirim ulasan.</p>
                <a href="{{ route('admin.orders') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-[#40605D] hover:bg-[#344B48] text-white text-xs font-medium px-5 py-2.5 min-h-[44px] rounded-xl transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D]">
                    <span data-i18n="messages_go_orders">Periksa Proses Pesanan</span>
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

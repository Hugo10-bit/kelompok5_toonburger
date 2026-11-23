@extends('layouts.admin')

@section('title', 'Pesan Terbaru - Toon Burger Admin')

@section('admin_content')
@php
    $avatarBgColors = [
        'bg-[#3B82F6]',
        'bg-[#F59E0B]',
        'bg-[#10B981]',
        'bg-[#EC4899]',
        'bg-[#8B5CF6]',
        'bg-[#0EA5E9]',
        'bg-[#F97316]',
        'bg-[#14B8A6]',
        'bg-[#6366F1]',
    ];

    $buildMessageUrl = function (array $overrides = []) use ($status, $sort, $search) {
        $params = array_merge([
            'status' => $status,
            'sort' => $sort,
            'search' => $search,
        ], $overrides);

        if (($params['status'] ?? 'all') === 'all') {
            unset($params['status']);
        }
        if (($params['sort'] ?? 'latest') === 'latest') {
            unset($params['sort']);
        }
        if (empty($params['search'])) {
            unset($params['search']);
        }

        return route('admin.messages', $params);
    };
@endphp

<div class="bg-white dark:bg-[#2B2B2B] rounded-3xl border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-4 sm:p-9 lg:p-10 flex-1 flex flex-col">
    <!-- Header Row -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5 sm:mb-7">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-2xl font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="messages_title">Pesan Terbaru</h1>
            <p class="text-xs text-gray-400 dark:text-[#D4D4D4] mt-1" data-i18n="messages_subtitle">Pantau semua pesan masuk dan pertanyaan terbaru dari pelanggan di sini.</p>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 relative flex-wrap sm:flex-nowrap">
            <!-- Filter Button & Dropdown -->
            <div class="relative" id="msg-filter-wrap">
                <button type="button"
                        onclick="toggleMsgFilterMenu(event)"
                        class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border {{ $status !== 'all' ? 'border-[#40605D] text-[#27443E] dark:border-[#8CC0B9] dark:text-[#8CC0B9]' : 'border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white' }} font-medium px-3.5 sm:px-4 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 {{ $status !== 'all' ? 'text-[#40605D] dark:text-[#8CC0B9]' : 'text-gray-500 dark:text-[#D4D4D4]' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M6 12h12m-9 6h6"></path>
                    </svg>
                    <span data-i18n="btn_filter">Filter</span>
                    @if($status !== 'all')
                        <span class="w-2 h-2 rounded-full {{ $status === 'unread' ? 'bg-[#EF4444]' : 'bg-[#4ADE80]' }}"></span>
                    @endif
                </button>

                <div id="msg-filter-menu" class="hidden absolute left-0 sm:left-auto sm:right-0 mt-2 w-56 max-w-[calc(100vw-2.5rem)] bg-white dark:bg-[#2B2B2B] rounded-2xl shadow-2xl border border-gray-100 dark:border-[#555555] py-2 z-50 animate-modal-pop">
                    <a href="{{ $buildMessageUrl(['status' => 'all']) }}"
                       class="flex items-center justify-between px-4 py-2.5 text-sm {{ $status === 'all' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition">
                        <span data-i18n="messages_filter_all">Semua Status</span>
                        <span id="msg-filter-total-count" class="text-xs text-gray-400">({{ $totalCount }})</span>
                    </a>
                    <a href="{{ $buildMessageUrl(['status' => 'unread']) }}"
                       class="flex items-center justify-between px-4 py-2.5 text-sm {{ $status === 'unread' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition">
                        <span class="inline-flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#EF4444]"></span>
                            <span data-i18n="msg_status_unread">Belum Dibaca</span>
                        </span>
                        <span id="msg-filter-unread-count" class="text-xs text-gray-400">({{ $unreadCount }})</span>
                    </a>
                    <a href="{{ $buildMessageUrl(['status' => 'read']) }}"
                       class="flex items-center justify-between px-4 py-2.5 text-sm {{ $status === 'read' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition">
                        <span class="inline-flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#4ADE80]"></span>
                            <span data-i18n="msg_status_read">Dibaca</span>
                        </span>
                        <span id="msg-filter-read-count" class="text-xs text-gray-400">({{ $readCount }})</span>
                    </a>
                </div>
            </div>

            <!-- Sortir Button & Dropdown -->
            <div class="relative" id="msg-sort-wrap">
                <button type="button"
                        onclick="toggleMsgSortMenu(event)"
                        class="bg-white dark:bg-[#383838] hover:bg-gray-50 dark:hover:bg-[#444444] border {{ $sort !== 'latest' ? 'border-[#40605D] text-[#27443E] dark:border-[#8CC0B9] dark:text-[#8CC0B9]' : 'border-gray-200 dark:border-[#555555] text-gray-600 dark:text-white' }} font-medium px-3.5 sm:px-4 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl transition-colors text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4 {{ $sort !== 'latest' ? 'text-[#40605D] dark:text-[#8CC0B9]' : 'text-gray-500 dark:text-[#D4D4D4]' }}" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    <span data-i18n="btn_sort">Sortir</span>
                </button>

                <div id="msg-sort-menu" class="hidden absolute left-0 sm:left-auto sm:right-0 mt-2 w-52 max-w-[calc(100vw-2.5rem)] bg-white dark:bg-[#2B2B2B] rounded-2xl shadow-2xl border border-gray-100 dark:border-[#555555] py-2 z-50 animate-modal-pop">
                    <a href="{{ $buildMessageUrl(['sort' => 'latest']) }}"
                       class="block px-4 py-2.5 text-sm {{ $sort === 'latest' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition"
                       data-i18n="msg_sort_latest">Terbaru</a>
                    <a href="{{ $buildMessageUrl(['sort' => 'oldest']) }}"
                       class="block px-4 py-2.5 text-sm {{ $sort === 'oldest' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition"
                       data-i18n="msg_sort_oldest">Terlama</a>
                    <a href="{{ $buildMessageUrl(['sort' => 'unread_first']) }}"
                       class="block px-4 py-2.5 text-sm {{ $sort === 'unread_first' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition"
                       data-i18n="msg_sort_unread_first">Belum Dibaca Dulu</a>
                    <a href="{{ $buildMessageUrl(['sort' => 'name_asc']) }}"
                       class="block px-4 py-2.5 text-sm {{ $sort === 'name_asc' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition"
                       data-i18n="msg_sort_name_asc">Nama (A–Z)</a>
                    <a href="{{ $buildMessageUrl(['sort' => 'name_desc']) }}"
                       class="block px-4 py-2.5 text-sm {{ $sort === 'name_desc' ? 'bg-gray-100/90 dark:bg-[#3A3A3A] text-[#27443E] dark:text-white font-semibold' : 'text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#3A3A3A]' }} transition"
                       data-i18n="msg_sort_name_desc">Nama (Z–A)</a>
                </div>
            </div>

            @if($status !== 'all' || $sort !== 'latest' || $search !== '')
                <a href="{{ route('admin.messages') }}"
                   class="inline-flex items-center justify-center px-3.5 py-2 sm:py-2.5 min-h-[40px] sm:min-h-[42px] rounded-xl border border-gray-200 dark:border-[#555555] text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#3D3D3D] transition"
                   data-i18n="messages_reset_filter">
                    Reset Filter
                </a>
            @endif
        </div>
    </div>

    @if($messages->count() > 0 && !request()->has('empty'))
        <!-- Mobile Message Cards -->
        <div class="md:hidden space-y-3">
            @foreach($messages as $idx => $msg)
                @php
                    $avatarBg = $avatarBgColors[$idx % count($avatarBgColors)];
                    $payload = [
                        'id' => $msg->id,
                        'name' => $msg->name,
                        'phone' => $msg->phone,
                        'email' => $msg->email,
                        'message' => $msg->message,
                        'is_read' => (bool) $msg->is_read,
                        'initials' => $msg->initials,
                        'avatar_url' => $msg->avatar_url,
                        'avatar_bg' => $avatarBg,
                        'created_at' => $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '-',
                        'status_url' => route('admin.messages.status', $msg->id),
                        'delete_url' => route('admin.messages.delete', $msg->id),
                    ];
                @endphp
                <article onclick="openMessageDetailModal(this)"
                         data-msg-id="{{ $msg->id }}"
                         data-message="{{ json_encode($payload) }}"
                         title="Klik untuk melihat detail pesan"
                         class="rounded-2xl border border-gray-200/90 dark:border-[#4A4A4A] bg-[#FAFAFB] dark:bg-[#383838] p-4 shadow-2xs space-y-2.5 cursor-pointer active:scale-[0.99] transition">
                    <div class="flex items-center justify-between gap-2.5">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($msg->avatar_url)
                                <img src="{{ $msg->avatar_url }}" alt="{{ $msg->name }}" class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200 dark:border-[#555555]">
                            @else
                                <div class="w-9 h-9 rounded-full {{ $avatarBg }} text-white font-bold text-xs flex items-center justify-center shrink-0 select-none">
                                    {{ $msg->initials }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <h2 class="font-bold text-gray-900 dark:text-white text-sm truncate">{{ $msg->name }}</h2>
                                <p class="text-[11px] text-gray-500 dark:text-[#BDBDBD] truncate">{{ $msg->phone }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <button type="button"
                                    onclick="event.stopPropagation(); toggleMessageStatus({{ $msg->id }}, this)"
                                    data-msg-status-btn="{{ $msg->id }}"
                                    data-status-url="{{ route('admin.messages.status', $msg->id) }}"
                                    data-is-read="{{ $msg->is_read ? '1' : '0' }}"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-gray-700 dark:text-[#E5E5E5] shrink-0 px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-[#444444] transition cursor-pointer">
                                <span data-msg-dot class="w-2 h-2 rounded-full {{ $msg->is_read ? 'bg-[#4ADE80]' : 'bg-[#EF4444]' }}"></span>
                                <span data-msg-label data-i18n="{{ $msg->is_read ? 'msg_status_read' : 'msg_status_unread' }}">{{ $msg->is_read ? 'Dibaca' : 'Belum Dibaca' }}</span>
                            </button>
                            <button type="button"
                                    onclick="event.stopPropagation(); openDeleteModal('{{ route('admin.messages.delete', $msg->id) }}', 'pesan dari {{ addslashes($msg->name) }}')"
                                    class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 p-1 rounded-lg transition cursor-pointer inline-flex items-center justify-center"
                                    title="Hapus Pesan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            <span class="text-[#40605D] dark:text-[#8CC0B9] p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="text-xs font-medium text-gray-700 dark:text-gray-200 truncate">
                        {{ $msg->email }}
                    </div>

                    <p class="text-xs text-gray-600 dark:text-[#D4D4D4] leading-relaxed line-clamp-2">
                        {{ $msg->message }}
                    </p>
                </article>
            @endforeach
        </div>

        <!-- Desktop Table (Matches uploaded design) -->
        <div class="hidden md:block border border-gray-200 dark:border-[#555555] rounded-[22px] overflow-hidden bg-white dark:bg-[#2B2B2B] flex-1">
            <div class="overflow-auto max-h-[calc(100vh-250px)] min-h-[300px]">
                <table class="w-full text-center border-collapse">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-[#EEEEEE] dark:bg-[#9E9E9E] text-gray-700 dark:text-[#222222] text-sm font-medium border-b border-gray-200 dark:border-[#757575]">
                            <th class="py-4 px-6 text-center whitespace-nowrap" data-i18n="col_msg_user">Nama Pengguna</th>
                            <th class="py-4 px-4 text-center whitespace-nowrap" data-i18n="col_msg_phone">Nomor Telfon</th>
                            <th class="py-4 px-4 text-center whitespace-nowrap" data-i18n="col_msg_email">Email</th>
                            <th class="py-4 px-5 text-center whitespace-nowrap" data-i18n="col_msg_body">Pesan</th>
                            <th class="py-4 px-5 text-center whitespace-nowrap" data-i18n="col_msg_status">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200/80 dark:divide-[#444444] text-sm">
                        @foreach($messages as $idx => $msg)
                            @php
                                $avatarBg = $avatarBgColors[$idx % count($avatarBgColors)];
                                $payload = [
                                    'id' => $msg->id,
                                    'name' => $msg->name,
                                    'phone' => $msg->phone,
                                    'email' => $msg->email,
                                    'message' => $msg->message,
                                    'is_read' => (bool) $msg->is_read,
                                    'initials' => $msg->initials,
                                    'avatar_url' => $msg->avatar_url,
                                    'avatar_bg' => $avatarBg,
                                    'created_at' => $msg->created_at ? $msg->created_at->format('d M Y, H:i') : '-',
                                    'status_url' => route('admin.messages.status', $msg->id),
                                    'delete_url' => route('admin.messages.delete', $msg->id),
                                ];
                            @endphp
                            <tr onclick="openMessageDetailModal(this)"
                                data-msg-id="{{ $msg->id }}"
                                data-message="{{ json_encode($payload) }}"
                                title="Klik untuk melihat detail pesan"
                                class="hover:bg-gray-50/70 dark:hover:bg-[#353535] transition-colors cursor-pointer">
                                <td class="py-4 px-6 text-left">
                                    <div class="flex items-center gap-3.5 pl-1 lg:pl-3">
                                        @if($msg->avatar_url)
                                            <img src="{{ $msg->avatar_url }}"
                                                 alt="{{ $msg->name }}"
                                                 width="36"
                                                 height="36"
                                                 loading="lazy"
                                                 decoding="async"
                                                 class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200 dark:border-[#555555]">
                                        @else
                                            <div class="w-9 h-9 rounded-full {{ $avatarBg }} text-white font-bold text-xs flex items-center justify-center shrink-0 select-none shadow-2xs">
                                                {{ $msg->initials }}
                                            </div>
                                        @endif
                                        <span class="font-bold text-gray-900 dark:text-white text-[13px] leading-snug whitespace-nowrap">
                                            {{ $msg->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center text-[13px] text-gray-600 dark:text-[#D4D4D4] whitespace-nowrap">
                                    {{ $msg->phone }}
                                </td>
                                <td class="py-4 px-4 text-center text-[13px] font-medium text-gray-800 dark:text-white whitespace-nowrap">
                                    {{ $msg->email }}
                                </td>
                                <td class="py-4 px-5 text-center">
                                    <p class="text-[12.5px] text-gray-600 dark:text-[#D4D4D4] leading-relaxed max-w-[330px] mx-auto line-clamp-2">
                                        {{ $msg->message }}
                                    </p>
                                </td>
                                <td class="py-4 px-5 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center justify-center gap-1.5 sm:gap-2">
                                        <button type="button"
                                                onclick="event.stopPropagation(); toggleMessageStatus({{ $msg->id }}, this)"
                                                data-msg-status-btn="{{ $msg->id }}"
                                                data-status-url="{{ route('admin.messages.status', $msg->id) }}"
                                                data-is-read="{{ $msg->is_read ? '1' : '0' }}"
                                                title="Klik untuk ubah status cepat"
                                                class="inline-flex items-center justify-center gap-2 text-[13px] font-medium text-gray-700 dark:text-[#E5E5E5] hover:bg-gray-100 dark:hover:bg-[#444444] transition cursor-pointer px-2.5 py-1 rounded-lg">
                                            <span data-msg-dot class="w-2 h-2 rounded-full shrink-0 {{ $msg->is_read ? 'bg-[#4ADE80]' : 'bg-[#EF4444]' }}"></span>
                                            <span data-msg-label data-i18n="{{ $msg->is_read ? 'msg_status_read' : 'msg_status_unread' }}">{{ $msg->is_read ? 'Dibaca' : 'Belum Dibaca' }}</span>
                                        </button>
                                        <button type="button"
                                                onclick="event.stopPropagation(); openMessageDetailModal(this.closest('tr'))"
                                                class="text-[#40605D] dark:text-[#8CC0B9] hover:bg-gray-100 dark:hover:bg-[#444444] p-1.5 rounded-lg transition cursor-pointer inline-flex items-center justify-center"
                                                title="Lihat Rincian Pesan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        <button type="button"
                                                onclick="event.stopPropagation(); openDeleteModal('{{ route('admin.messages.delete', $msg->id) }}', 'pesan dari {{ addslashes($msg->name) }}')"
                                                class="text-[#D9534F] dark:text-[#F87171] hover:text-red-700 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-[#4A2626] p-1.5 rounded-lg transition cursor-pointer inline-flex items-center justify-center"
                                                title="Hapus Pesan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="flex-1 flex flex-col items-center justify-center text-center py-16 px-4">
            @if($status !== 'all' || $search !== '')
                <div class="w-12 h-12 rounded-2xl bg-[#E8EFEE] dark:bg-[#3F4E4C] text-[#40605D] dark:text-[#8CC0B9] flex items-center justify-center mb-3.5">
                    <svg class="w-6 h-6" viewBox="0 -960 960 960" fill="currentColor" aria-hidden="true">
                        <path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/>
                    </svg>
                </div>
                <h2 class="text-base font-bold text-[#262626] dark:text-white" data-i18n="messages_empty_filtered_title">Tidak ada pesan yang sesuai dengan filter</h2>
                <p class="text-xs sm:text-sm text-[#5F6672] dark:text-[#C4C9D0] mt-1 max-w-md" data-i18n="messages_empty_filtered_desc">Ubah pilihan filter status atau hapus kata kunci pencarian untuk melihat seluruh pesan pelanggan.</p>
                <a href="{{ route('admin.messages') }}"
                   class="mt-5 inline-flex items-center gap-2 bg-[#40605D] hover:bg-[#344B48] text-white text-xs font-medium px-5 py-2.5 min-h-[44px] rounded-xl transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#40605D]"
                   data-i18n="messages_show_all">
                    Tampilkan Semua Pesan
                </a>
            @else
                <img src="{{ asset('images/empty-message.png') }}"
                     alt="Belum Ada Pesan Masuk"
                     width="180"
                     height="165"
                     loading="lazy"
                     class="w-36 sm:w-44 h-auto mx-auto mb-4 object-contain">
                <h2 class="text-xl font-bold text-[#262626] dark:text-white" data-i18n="messages_empty_title">Belum Ada Pesan Masuk</h2>
                <p class="text-xs sm:text-sm text-[#5F6672] dark:text-[#C4C9D0] mt-1.5 max-w-sm leading-relaxed" data-i18n="messages_empty_desc">Pesan yang dikirim oleh pengunjung melalui formulir kontak di website Toon Burger akan muncul di sini.</p>
                <div class="mt-6">
                    <button type="button" onclick="window.location.reload()" class="px-5 py-2.5 rounded-xl border border-gray-300 dark:border-[#555555] bg-white dark:bg-[#333333] hover:bg-gray-50 dark:hover:bg-[#3D3D3D] text-xs font-semibold text-gray-700 dark:text-[#E5E5E5] transition shadow-xs cursor-pointer" data-i18n="btn_refresh">
                        Refresh Halaman
                    </button>
                </div>
            @endif
        </div>
    @endif

    <!-- Hidden Delete Form -->
    <form id="msg-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@section('admin_modals')
    <!-- Message Detail Modal (Full viewport backdrop) -->
    <div id="messageDetailModal" class="fixed inset-0 z-[99999] hidden flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/60 transition-opacity duration-200" onclick="closeMessageDetailModal()"></div>

        <div id="messageDetailModalCard" class="relative bg-white dark:bg-[#2B2B2B] rounded-3xl max-w-lg w-full p-5 sm:p-7 shadow-2xl z-10 max-h-[85dvh] overflow-y-auto border border-gray-100 dark:border-[#4A4A4A] animate-modal-pop my-auto">
            <div class="flex items-center justify-between gap-3 mb-4 sm:mb-5">
                <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white" data-i18n="msg_detail_title">Detail Pesan Pelanggan</h3>
                <button type="button"
                        onclick="closeMessageDetailModal()"
                        class="w-9 h-9 rounded-full bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] text-gray-700 dark:text-gray-200 flex items-center justify-center font-semibold text-lg cursor-pointer shrink-0 transition"
                        aria-label="Tutup">&times;</button>
            </div>

            <div class="flex items-center justify-between gap-3 pb-4 border-b border-gray-100 dark:border-[#444444]">
                <div class="flex items-center gap-3 min-w-0">
                    <div id="msg-modal-avatar" class="w-11 h-11 rounded-full bg-[#40605D] text-white font-bold text-sm flex items-center justify-center shrink-0">TB</div>
                    <div class="min-w-0">
                        <div id="msg-modal-name" class="font-bold text-sm sm:text-base text-gray-900 dark:text-white truncate">-</div>
                        <div id="msg-modal-time" class="text-xs text-gray-400 dark:text-[#BDBDBD] mt-0.5">-</div>
                    </div>
                </div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-[#3A3A3A] text-xs font-medium text-gray-700 dark:text-[#E5E5E5] shrink-0">
                    <span id="msg-modal-status-dot" class="w-2 h-2 rounded-full bg-[#EF4444]"></span>
                    <span id="msg-modal-status-label">Belum Dibaca</span>
                </span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 py-4 border-b border-gray-100 dark:border-[#444444] text-xs">
                <div class="rounded-xl bg-[#F8F9FA] dark:bg-[#383838] px-3.5 py-2.5">
                    <span class="block text-[11px] text-gray-400 dark:text-[#BDBDBD]" data-i18n="col_msg_phone">Nomor Telfon</span>
                    <span id="msg-modal-phone" class="font-semibold text-gray-800 dark:text-white mt-0.5 block break-all">-</span>
                </div>
                <div class="rounded-xl bg-[#F8F9FA] dark:bg-[#383838] px-3.5 py-2.5">
                    <span class="block text-[11px] text-gray-400 dark:text-[#BDBDBD]" data-i18n="col_msg_email">Email</span>
                    <span id="msg-modal-email" class="font-semibold text-gray-800 dark:text-white mt-0.5 block break-all">-</span>
                </div>
            </div>

            <div class="py-4">
                <span class="block text-[11px] font-semibold uppercase tracking-wide text-gray-400 dark:text-[#BDBDBD] mb-2" data-i18n="col_msg_body">Pesan</span>
                <div id="msg-modal-body" class="rounded-2xl bg-[#F8F9FA] dark:bg-[#383838] border border-gray-200/70 dark:border-[#4A4A4A] p-4 text-xs sm:text-sm text-gray-700 dark:text-[#E5E7EB] leading-relaxed whitespace-pre-line break-words">
                    -
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-2 pt-3 border-t border-gray-100 dark:border-[#444444]">
                <button type="button"
                        onclick="deleteActiveMessage()"
                        class="px-3.5 py-2.5 min-h-[40px] rounded-xl text-xs font-medium text-[#DE3B28] dark:text-[#FCA5A5] bg-red-50 dark:bg-[#4A2626] hover:bg-red-100 dark:hover:bg-[#5E2E2E] transition cursor-pointer"
                        data-i18n="msg_delete">
                    Hapus
                </button>
                <div class="flex items-center gap-2 ml-auto">
                    <button type="button"
                            id="msg-modal-toggle-btn"
                            onclick="toggleActiveMessageStatus()"
                            class="px-3.5 sm:px-4 py-2.5 min-h-[40px] rounded-xl text-xs font-medium text-gray-700 dark:text-white bg-gray-100 dark:bg-[#3C3C3C] hover:bg-gray-200 dark:hover:bg-[#4A4A4A] transition cursor-pointer whitespace-nowrap">
                        Tandai Belum Dibaca
                    </button>
                    <button type="button"
                            onclick="closeMessageDetailModal()"
                            class="px-4 py-2.5 min-h-[40px] rounded-xl text-xs font-medium text-white bg-[#415C58] hover:bg-[#344B48] transition cursor-pointer whitespace-nowrap"
                            data-i18n="msg_close">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

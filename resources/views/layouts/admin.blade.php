@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ route('login') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2D4336">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Toon Burger Admin">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <!-- Prevent logged-out flash & theme flash (FOUC) -->
    <script src="{{ asset('js/admin-head.js') }}"></script>
    <title>@yield('title', 'Admin Panel - Toon Burger')</title>

    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400;1,700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="min-h-screen bg-[#EEF0F2] dark:bg-[#404040] text-[#1F2937] dark:text-[#E5E7EB] antialiased p-2.5 sm:p-5 lg:p-6 flex flex-col md:flex-row gap-3.5 sm:gap-5 lg:gap-6"
      data-logout-url="{{ route('logout') }}"
      data-login-url="{{ route('login') }}"
      data-admin-search-url="{{ route('admin.search.live') }}"
      data-admin-products-url="{{ route('admin.products') }}"
      data-admin-orders-url="{{ route('admin.orders') }}"
      data-admin-dashboard-url="{{ route('admin.dashboard') }}"
      data-admin-profile-url="{{ route('admin.profile') }}"
      data-admin-categories-url="{{ route('admin.categories') }}"
      data-admin-messages-url="{{ route('admin.messages') }}">
    <div id="admin-loader-bar"></div>

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeLogoutModal()"></div>

        <div class="relative bg-white dark:bg-[#303030] rounded-[28px] sm:rounded-[32px] shadow-2xl p-6 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 dark:border-[#4A4A4A] mx-auto my-auto">
            <div class="w-20 h-20 sm:w-[124px] sm:h-[124px] rounded-full border-[5.5px] sm:border-[7.5px] border-[#D46161] flex items-center justify-center mx-auto mb-5 sm:mb-6 bg-white dark:bg-[#303030] shrink-0">
                <svg class="w-9 h-9 sm:w-12 sm:h-12 text-[#D46161]" viewBox="0 0 32 32" fill="currentColor">
                    <path d="M16 5.5c-1.38 0-2.5 1.05-2.4 2.43l.8 12.14c.08 1.15 1.03 2.05 2.18 2.05s2.1-.9 2.18-2.05l.8-12.14c.1-1.38-1.02-2.43-2.4-2.43zm0 19.38a2.56 2.56 0 100 5.12 2.56 2.56 0 000-5.12z"/>
                </svg>
            </div>

            <h3 class="text-xl sm:text-[27px] font-bold text-gray-900 dark:text-white tracking-tight mb-2.5" data-i18n="logout_title">
                Konfirmasi Logout
            </h3>

            <p class="text-gray-500 dark:text-gray-300 text-xs sm:text-sm leading-relaxed max-w-xs mx-auto mb-6 sm:mb-7 font-normal" data-i18n="logout_desc">
                Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <button type="button"
                        onclick="closeLogoutModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-[#2D3139] border border-[#6B7280] rounded-xl px-5 sm:px-7 py-2.5 text-xs sm:text-sm font-medium transition min-w-[110px] sm:min-w-[124px] tb-focus-ring cursor-pointer"
                        data-i18n="cancel">
                    Batalkan
                </button>
                <button type="button"
                        id="admin-modal-logout-submit-btn"
                        onclick="submitLogoutForm()"
                        class="bg-[#B73535] hover:bg-[#9E2A2A] active:scale-95 text-white rounded-xl px-5 sm:px-7 py-2.5 text-xs sm:text-sm font-medium transition min-w-[110px] sm:min-w-[124px] shadow-xs tb-focus-ring cursor-pointer flex items-center justify-center"
                        data-i18n="logout_confirm_btn">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <!-- Global Hidden Form for Logout -->
    <form id="global-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Modal Konfirmasi Hapus -->
    <div id="delete-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeDeleteModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl p-6 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 mx-auto my-auto">
            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-2 border-red-100 bg-red-50/40 flex items-center justify-center mx-auto mb-4 sm:mb-5 text-[#DE3B28]">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-[#DE3B28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>

            <h3 id="delete-modal-title" class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight mb-2" data-i18n="delete_title">
                Konfirmasi Hapus
            </h3>

            <p id="delete-modal-message" class="text-gray-500 text-xs sm:text-sm leading-relaxed max-w-xs mx-auto mb-6 sm:mb-7" data-i18n="delete_desc">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-gray-700 border border-gray-300 rounded-lg px-5 sm:px-7 py-2.5 text-xs font-medium transition min-w-[110px] sm:min-w-[120px] tb-focus-ring cursor-pointer"
                        data-i18n="cancel">
                    Batalkan
                </button>
                <form id="global-delete-form" method="POST" action="" class="inline" onsubmit="return handleGlobalDeleteSubmit(event, this)">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-[#DE3B28] hover:bg-[#C9301F] active:scale-95 text-white rounded-lg px-5 sm:px-7 py-2.5 text-xs font-medium transition min-w-[110px] sm:min-w-[120px] shadow-xs tb-focus-ring cursor-pointer"
                            data-i18n="delete_confirm_btn">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tutup Toko Sekarang -->
    <div id="store-close-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/45 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeStoreModals()"></div>

        <div class="relative bg-white dark:bg-[#303030] rounded-[24px] sm:rounded-[28px] shadow-2xl p-6 sm:p-7 max-w-[440px] w-full text-left z-10 select-none animate-modal-pop border border-gray-100 dark:border-[#4A4A4A] mx-auto my-auto">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-50 dark:bg-[#4A2626] border border-red-100 dark:border-red-900/50 text-[#DC2626] dark:text-[#F87171] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
                <button type="button"
                        onclick="closeStoreModals()"
                        class="w-8 h-8 rounded-full bg-gray-100/90 dark:bg-[#3D3D3D] hover:bg-gray-200 dark:hover:bg-[#4D4D4D] text-gray-500 dark:text-gray-300 flex items-center justify-center transition cursor-pointer"
                        aria-label="Tutup">&times;</button>
            </div>

            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white tracking-tight" data-i18n="store_close_modal_title">
                Tutup Toko Sekarang?
            </h3>

            <p class="text-xs sm:text-[13px] text-gray-500 dark:text-gray-300 leading-relaxed mt-1.5" data-i18n="store_close_modal_desc">
                Pelanggan tidak akan bisa melakukan checkout saat toko berstatus tutup.
            </p>

            <form id="store-close-form" action="{{ route('admin.store.status') }}" method="POST" class="mt-5" onsubmit="return handleStoreStatusSubmit(event, this)">
                @csrf
                <input type="hidden" name="is_open" value="0">
                <input type="hidden" name="closed_reason" id="store-close-reason-input" value="Jam Tutup">

                <div class="text-xs font-semibold text-gray-700 dark:text-gray-200 mb-2.5" data-i18n="store_close_reason_label">
                    Pilih alasan cepat (opsional tampil di web):
                </div>

                @php
                    $quickReasons = [
                        'Stok Habis' => 'store_reason_out_of_stock',
                        'Jam Tutup' => 'store_reason_closing_hours',
                        'Tutup Sementara' => 'store_reason_sudden_close',
                    ];
                @endphp
                <div class="flex flex-wrap gap-2" id="store-close-reasons-group">
                    @foreach($quickReasons as $reasonOption => $reasonKey)
                        @php $isDefault = ($reasonOption === 'Jam Tutup'); @endphp
                        <button type="button"
                                onclick="selectStoreCloseReason(this, '{{ $reasonOption }}')"
                                data-reason="{{ $reasonOption }}"
                                class="store-reason-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border transition cursor-pointer {{ $isDefault ? 'is-selected bg-red-50/90 border-red-400 text-[#DC2626] dark:bg-[#4A2626] dark:border-red-500 dark:text-[#FCA5A5]' : 'bg-white dark:bg-[#3A3A3A] border-gray-200 dark:border-[#525252] text-gray-600 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#454545]' }}">
                            <svg class="store-reason-check w-3.5 h-3.5 {{ $isDefault ? '' : 'hidden' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span data-i18n="{{ $reasonKey }}">{{ $reasonOption }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-2.5 mt-6 pt-4 border-t border-gray-100 dark:border-[#424242]">
                    <button type="button"
                            onclick="closeStoreModals()"
                            data-i18n="btn_cancel"
                            class="px-5 py-2.5 rounded-xl bg-white dark:bg-[#3A3A3A] hover:bg-gray-50 dark:hover:bg-[#454545] border border-gray-300 dark:border-[#555555] text-xs font-semibold text-gray-700 dark:text-gray-200 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            data-i18n="store_close_confirm"
                            class="px-5 py-2.5 rounded-xl bg-[#DC2626] hover:bg-[#B91C1C] active:scale-95 text-white text-xs font-semibold shadow-xs transition cursor-pointer">
                        Ya, Tutup Toko
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Buka Toko Sekarang -->
    <div id="store-open-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/45 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeStoreModals()"></div>

        <div class="relative bg-white dark:bg-[#303030] rounded-[24px] sm:rounded-[28px] shadow-2xl p-6 sm:p-7 max-w-[420px] w-full text-left z-10 select-none animate-modal-pop border border-gray-100 dark:border-[#4A4A4A] mx-auto my-auto">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-emerald-50 dark:bg-[#1E453B] border border-emerald-100 dark:border-emerald-700/50 text-emerald-600 dark:text-[#6EE7B7] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <button type="button"
                        onclick="closeStoreModals()"
                        class="w-8 h-8 rounded-full bg-gray-100/90 dark:bg-[#3D3D3D] hover:bg-gray-200 dark:hover:bg-[#4D4D4D] text-gray-500 dark:text-gray-300 flex items-center justify-center transition cursor-pointer"
                        aria-label="Tutup">&times;</button>
            </div>

            <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white tracking-tight" data-i18n="store_open_modal_title">
                Buka Toko Sekarang?
            </h3>

            <p class="text-xs sm:text-[13px] text-gray-500 dark:text-gray-300 leading-relaxed mt-1.5" data-i18n="store_open_modal_desc">
                Pelanggan akan kembali dapat menambahkan menu ke keranjang dan melakukan checkout di website Toon Burger.
            </p>

            <form id="store-open-form" action="{{ route('admin.store.status') }}" method="POST" class="mt-6 pt-4 border-t border-gray-100 dark:border-[#424242] flex items-center justify-end gap-2.5" onsubmit="return handleStoreStatusSubmit(event, this)">
                @csrf
                <input type="hidden" name="is_open" value="1">
                <button type="button"
                        onclick="closeStoreModals()"
                        data-i18n="btn_cancel"
                        class="px-5 py-2.5 rounded-xl bg-white dark:bg-[#3A3A3A] hover:bg-gray-50 dark:hover:bg-[#454545] border border-gray-300 dark:border-[#555555] text-xs font-semibold text-gray-700 dark:text-gray-200 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        data-i18n="store_open_confirm"
                        class="px-5 py-2.5 rounded-xl bg-[#40605D] hover:bg-[#344B48] active:scale-95 text-white text-xs font-semibold shadow-xs transition cursor-pointer">
                    Ya, Buka Toko
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile sidebar backdrop -->
    <div id="admin-sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 md:z-30 w-68 sm:w-72 md:w-[244px] lg:w-[258px] xl:w-[268px] bg-white text-gray-800 rounded-r-[28px] md:rounded-3xl border border-gray-200/80 shadow-xs flex flex-col justify-between px-5 py-6 flex-shrink-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:fixed md:top-5 md:bottom-auto md:left-5 lg:top-6 lg:left-6 md:min-h-[calc(100vh-2.5rem)] lg:min-h-[calc(100vh-3rem)] md:flex overflow-y-auto md:overflow-visible">
        <div>
            <!-- Logo Section with Mascot (Sesuai Referensi Gambar) -->
            <div class="-mx-5 px-5 pt-4 md:pt-0 pb-4 mb-4 border-b border-gray-200/75 dark:border-[#3F3F3F] flex items-center justify-between md:justify-center relative">
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center group text-center w-full">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger" width="100" height="100" decoding="async" class="h-[88px] sm:h-[94px] lg:h-[100px] w-auto object-contain transition-transform group-hover:scale-105 dark:hidden">
                    <img src="{{ asset('images/toonburger-logo-white.png') }}" alt="Toon Burger" width="100" height="100" loading="lazy" decoding="async" class="h-[88px] sm:h-[94px] lg:h-[100px] w-auto object-contain transition-transform group-hover:scale-105 hidden dark:block">
                </a>
                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden absolute right-3 top-1 text-gray-600 dark:text-gray-200 bg-gray-100/90 dark:bg-[#383838] hover:text-gray-900 p-2 min-w-[40px] min-h-[40px] flex items-center justify-center rounded-full border border-gray-200/80 dark:border-[#525252] transition cursor-pointer" aria-label="Tutup Menu">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Primary Navigation Links (Ordered and positioned exactly as mockup) -->
            <nav class="space-y-2 text-[14.5px] font-medium">

                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M560-600q-17 0-28.5-11.5T520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560ZM160-440q-17 0-28.5-11.5T120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160Zm400 320q-17 0-28.5-11.5T520-160v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560Zm-400 0q-17 0-28.5-11.5T120-160v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160Z"/>
                    </svg>
                    <span data-i18n="nav_dashboard">Dashboard</span>
                </a>

                <!-- 2. Admin Profile -->
                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.profile') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88C7.55 15.8 9.68 15 12 15s4.45.8 6.14 2.12C16.43 19.18 14.03 20 12 20z" clip-rule="evenodd"/>
                    </svg>
                    <span data-i18n="nav_profile">Profil Admin</span>
                </a>

                <!-- 3. Order processing -->
                <a href="{{ route('admin.orders') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.orders*') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6.5 16.5V3.5L7.8 5L9.1 3.5L10.4 5L11.7 3.5L13 5L14.3 3.5L15.6 5L16.9 3.5L18.2 5L19.5 3.5V20" />
                        <path d="M9 8h5M16.2 8h1.4" stroke-width="2" />
                        <path d="M9 11.5h5M16.2 11.5h1.4" stroke-width="2" />
                        <path d="M15.5 16.5H4.8A1.75 1.75 0 0 0 3.05 18.25A1.75 1.75 0 0 0 4.8 20H19.5" />
                        <line x1="15.5" y1="16.5" x2="15.5" y2="20" />
                    </svg>
                    <span data-i18n="nav_orders">Proses Pesanan</span>
                </a>

                <!-- 4. Product Data -->
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.products*') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M160-120q-33 0-56.5-23.5T80-200v-80q0-17 11.5-28.5T120-320h720q17 0 28.5 11.5T880-280v80q0 33-23.5 56.5T800-120H160Zm263-280q-21 20-77 20t-76-20q-20-20-56-20-28 0-45.5 13.5T121-385q-16 5-28.5-6.5T80-420q0-17 11.5-29.5T119-470q17-9 37-19.5t58-10.5q56 0 76 20t56 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 56-20t76-20q36 0 57 10t38 19q16 8 27.5 21t11.5 30q0 17-12 28.5t-28 6.5q-29-8-45.5-21.5T750-420q-36 0-58 20t-78 20q-56 0-77-20t-57-20q-36 0-57 20Zm202.5-426.5q71.5 13.5 128 42t91.5 74Q880-665 880-600q0 17-11.5 28.5T840-560H120q-17 0-28.5-11.5T80-600q0-65 35-110.5t91.5-74q56.5-28.5 128-42T480-840q74 0 145.5 13.5Z"/>
                    </svg>
                    <span data-i18n="nav_products">Data Produk</span>
                </a>

                <!-- 5. Product Categories -->
                <a href="{{ route('admin.categories') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.categories*') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                    </svg>
                    <span data-i18n="nav_categories">Data Kategori</span>
                </a>

                <!-- 6. Pesan Terbaru -->
                <a href="{{ route('admin.messages') }}"
                   class="flex items-center gap-4 px-5 py-4 transition rounded-full {{ request()->routeIs('admin.messages*') ? 'bg-[#40605D] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Z"/>
                    </svg>
                    <span data-i18n="nav_messages">Pesan Terbaru</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Operational Status Widget -->
        @php
            $isStoreOpen = $storeSetting->is_open ?? true;
            $storeHours = $storeSetting->operating_hours ?? '17:00–22:00 WITA';
            $closedReasonText = method_exists($storeSetting, 'displayReason') ? $storeSetting->displayReason() : 'Jam Tutup';
        @endphp
        <div class="pt-4 mt-4 border-t border-gray-200/75 dark:border-[#3F3F3F]">
            <div class="rounded-2xl border p-4 space-y-2.5 transition-colors {{ $isStoreOpen ? 'border-gray-200/90 dark:border-[#4A4A4A] bg-[#F8FAFC] dark:bg-[#383838]' : 'border-red-200 dark:border-red-900/60 bg-red-50/75 dark:bg-[#4A2626]/40' }}">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-xs font-bold text-gray-800 dark:text-white tracking-tight" data-i18n="store_status_label">Status Operasional</span>
                    @if($isStoreOpen)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold tracking-wide bg-emerald-100 text-emerald-700 dark:bg-[#1E453B] dark:text-[#6EE7B7] shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span data-i18n="store_open_badge">BUKA</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10.5px] font-bold tracking-wide bg-red-100 text-red-700 dark:bg-[#5E2828] dark:text-[#FCA5A5] shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                            <span data-i18n="store_closed_badge">TUTUP</span>
                        </span>
                    @endif
                </div>

                @if($isStoreOpen)
                    <p class="text-xs text-gray-500 dark:text-[#BDBDBD] leading-relaxed">
                        <span class="block" data-i18n="store_active_desc">Website aktif menerima pesanan</span>
                        <span class="block font-medium text-gray-600 dark:text-gray-300 mt-0.5">&bull; {{ $storeHours }}</span>
                    </p>
                    <button type="button"
                            onclick="openStoreToggleModal('close')"
                            class="tb-store-toggle-btn w-full py-2.5 px-3.5 rounded-xl border border-gray-300 dark:border-[#525252] bg-white dark:bg-[#2E2E2E] hover:bg-red-50 hover:border-red-300 hover:text-red-700 dark:hover:bg-[#4A2626] dark:hover:text-[#FCA5A5] text-[13px] font-semibold text-gray-700 dark:text-gray-200 transition cursor-pointer active:scale-98"
                            data-i18n="store_close_btn">
                        Tutup Toko
                    </button>
                @else
                    <p class="text-xs text-red-700/90 dark:text-[#FCA5A5] leading-relaxed">
                        <span class="block font-medium" data-i18n="store_closed_desc">Pemesanan pelanggan dinonaktifkan</span>
                        <span class="block mt-0.5">&bull; {{ $closedReasonText }}</span>
                    </p>
                    <button type="button"
                            onclick="openStoreToggleModal('open')"
                            class="tb-store-toggle-btn tb-store-reopen-btn w-full py-2.5 px-3.5 rounded-xl bg-[#40605D] hover:bg-[#344B48] text-white text-[13px] font-semibold transition shadow-2xs cursor-pointer active:scale-98"
                            data-i18n="store_open_btn">
                        Buka Toko
                    </button>
                @endif
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col gap-3.5 sm:gap-5 lg:gap-6 min-w-0 md:ml-[264px] lg:ml-[282px] xl:ml-[292px]">

        <!-- Top Header -->
        <header class="bg-white rounded-3xl border border-gray-200/80 shadow-xs px-3.5 sm:px-8 py-2.5 sm:py-3.5 flex items-center justify-between gap-3 select-none relative z-30">

            <div class="flex items-center gap-2.5 sm:gap-3 flex-1 min-w-0">
                <!-- Hamburger (mobile only) -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden p-2 min-w-[40px] min-h-[40px] flex items-center justify-center text-[#374151] dark:text-[#E5E7EB] hover:bg-gray-100 dark:hover:bg-[#3D3D3D] rounded-xl transition active:scale-95 tb-focus-ring shrink-0" aria-label="Buka Menu Admin">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Brand name (mobile only) -->
                <span class="md:hidden font-extrabold text-sm text-gray-900 dark:text-white tracking-tight truncate">Toon Burger Admin</span>

                <!-- Mobile quick operational status pill -->
                <button type="button"
                        onclick="openStoreToggleModal('{{ $isStoreOpen ? 'close' : 'open' }}')"
                        class="md:hidden inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold shrink-0 cursor-pointer transition {{ $isStoreOpen ? 'bg-emerald-100 text-emerald-700 dark:bg-[#1E453B] dark:text-[#6EE7B7]' : 'bg-red-100 text-red-700 dark:bg-[#5E2828] dark:text-[#FCA5A5]' }}"
                        title="Ubah Status Operasional Toko">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isStoreOpen ? 'bg-emerald-500 animate-pulse' : 'bg-red-600' }}"></span>
                    <span>{{ $isStoreOpen ? 'BUKA' : 'TUTUP' }}</span>
                </button>

                <!-- Search bar (desktop only) -->
                <div class="relative w-full max-w-[560px] hidden md:block">
                    <form action="{{ route('admin.orders') }}" method="GET" class="w-full bg-[#F0F3F7] hover:bg-[#EAEFF4] rounded-full px-5 py-2.5 sm:py-3 flex items-center gap-3.5 transition focus-within:ring-2 focus-within:ring-[#40605D]/30 focus-within:bg-white focus-within:border focus-within:border-gray-300">
                        <svg class="w-4 h-4 text-[#5F6672] dark:text-[#D1D5DB] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               name="q"
                               id="global-header-search"
                               placeholder="Cari Sesuatu..."
                               autocomplete="off"
                               data-i18n-attr="placeholder:search_placeholder"
                               style="background-color: transparent !important; background: transparent !important; border: none !important; outline: none !important; box-shadow: none !important;"
                               class="!bg-transparent bg-transparent border-0 outline-none focus:outline-none focus:ring-0 text-sm text-gray-800 dark:text-white placeholder-[#5F6672] dark:placeholder-[#D1D5DB] w-full font-normal">
                        <button type="button"
                                id="header-search-clear"
                                onclick="clearHeaderSearch()"
                                class="hidden text-[#5F6672] hover:text-gray-800 dark:text-[#D1D5DB] dark:hover:text-white p-0.5 rounded-full transition tb-focus-ring"
                                aria-label="Bersihkan pencarian">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Live Search Results Dropdown -->
                    <div id="header-search-results" class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl border border-gray-200/90 shadow-2xl p-3 z-50 hidden max-h-96 overflow-y-auto animate-modal-pop">
                        <div id="header-search-loading" class="hidden text-center py-4 text-xs text-gray-400">
                            <svg class="w-5 h-5 animate-spin mx-auto text-[#415C58] mb-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span data-i18n="searching">Mencari data...</span>
                        </div>
                        <div id="header-search-content"></div>
                    </div>
                </div>
            </div>

            <!-- Right controls -->
            <div class="flex items-center gap-3 sm:gap-6 shrink-0">
                <!-- Language selector (desktop only) -->
                <div class="relative select-none hidden sm:block">
                    <button type="button"
                            id="header-lang-btn"
                            onclick="toggleLanguageDropdown(event)"
                            class="bg-white border border-gray-200/90 rounded-full px-3.5 py-1.5 flex items-center gap-2.5 text-sm font-medium text-gray-700 shadow-2xs hover:bg-gray-50 active:scale-95 transition cursor-pointer tb-focus-ring">
                        <span id="header-lang-flag" class="w-6 h-6 rounded-full overflow-hidden flex items-center justify-center border border-gray-100 shrink-0">
                            <svg class="w-full h-full" viewBox="0 0 64 64">
                                <clipPath id="circle-flag-id-init"><circle cx="32" cy="32" r="32"/></clipPath>
                                <g clip-path="url(#circle-flag-id-init)">
                                    <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                    <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                </g>
                            </svg>
                        </span>
                        <span id="header-lang-label" class="text-sm font-medium text-gray-700">Indonesia</span>
                        <svg id="header-lang-chevron" class="w-4 h-4 text-gray-700 stroke-[2] transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="header-lang-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl border border-gray-200/90 shadow-xl p-2 z-50 hidden animate-modal-pop">
                        <button type="button" onclick="selectLanguage('Indonesia', 'ID')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-gray-800 hover:bg-gray-100 transition cursor-pointer">
                            <span class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full overflow-hidden flex items-center justify-center border border-gray-200/80 dark:border-white/20 shrink-0" aria-hidden="true">
                                    <svg class="w-full h-full" viewBox="0 0 64 64">
                                        <clipPath id="circle-flag-dropdown-id"><circle cx="32" cy="32" r="32"/></clipPath>
                                        <g clip-path="url(#circle-flag-dropdown-id)">
                                            <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                            <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                        </g>
                                    </svg>
                                </span>
                                <span>Indonesia</span>
                            </span>
                            <svg id="lang-check-id" class="w-4 h-4 text-[#415C58] dark:text-[#8CC0B9]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </button>
                        <button type="button" onclick="selectLanguage('English', 'US')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-gray-800 hover:bg-gray-100 transition mt-1 cursor-pointer">
                            <span class="flex items-center gap-2.5">
                                <span class="w-5 h-5 rounded-full overflow-hidden flex items-center justify-center border border-gray-200/80 dark:border-white/20 shrink-0" aria-hidden="true">
                                    <svg class="w-full h-full" viewBox="0 0 64 64">
                                        <clipPath id="circle-flag-dropdown-us"><circle cx="32" cy="32" r="32"/></clipPath>
                                        <g clip-path="url(#circle-flag-dropdown-us)">
                                            <path fill="#B22234" d="M0 0h64v64H0z"/>
                                            <path stroke="#FFF" stroke-width="5" d="M0 7.5h64M0 17.5h64M0 27.5h64M0 37.5h64M0 47.5h64M0 57.5h64"/>
                                            <path fill="#3C3B6E" d="M0 0h32v35H0z"/>
                                            <circle cx="8" cy="8" r="1.5" fill="#FFF"/>
                                            <circle cx="16" cy="8" r="1.5" fill="#FFF"/>
                                            <circle cx="24" cy="8" r="1.5" fill="#FFF"/>
                                            <circle cx="12" cy="14" r="1.5" fill="#FFF"/>
                                            <circle cx="20" cy="14" r="1.5" fill="#FFF"/>
                                            <circle cx="8" cy="20" r="1.5" fill="#FFF"/>
                                            <circle cx="16" cy="20" r="1.5" fill="#FFF"/>
                                            <circle cx="24" cy="20" r="1.5" fill="#FFF"/>
                                            <circle cx="12" cy="26" r="1.5" fill="#FFF"/>
                                            <circle cx="20" cy="26" r="1.5" fill="#FFF"/>
                                        </g>
                                    </svg>
                                </span>
                                <span>English</span>
                            </span>
                            <svg id="lang-check-en" class="w-4 h-4 text-[#415C58] dark:text-[#8CC0B9] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Profile badge -->
                @php
                    $adminUser = Auth::user();
                    $adminName = $adminUser?->name ?: 'Toon Burger';
                    $adminEmail = $adminUser?->email ?: 'Toonburger@gmail.com';
                    $adminAvatar = $adminUser?->avatar;
                    $adminInitials = strtoupper(substr($adminName, 0, 2));
                @endphp
                <div class="relative select-none">
                    <button type="button" id="header-profile-btn" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 cursor-pointer group tb-focus-ring rounded-xl p-0.5 text-left">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-xs group-hover:scale-105 transition overflow-hidden">
                            @if(!empty($adminAvatar))
                                <img id="header-profile-avatar-img"
                                     src="{{ $adminUser->avatar_url }}"
                                     alt="Avatar"
                                     class="w-full h-full object-cover">
                                <span id="header-profile-avatar-initials" class="hidden">{{ $adminInitials }}</span>
                            @else
                                <img id="header-profile-avatar-img" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                <span id="header-profile-avatar-initials">{{ $adminInitials }}</span>
                            @endif
                        </div>
                        <div class="text-left leading-tight hidden sm:block">
                            <div class="font-bold text-sm text-gray-900 leading-tight">{{ $adminName }}</div>
                            <div class="text-xs text-[#5F6672] font-normal leading-tight mt-0.5">{{ $adminEmail }}</div>
                        </div>
                        <svg id="header-profile-chevron" class="w-4 h-4 text-gray-700 stroke-[2] transition-transform duration-200 ml-1 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="header-profile-dropdown" class="absolute right-0 top-full mt-2 w-56 sm:w-60 bg-white rounded-2xl border border-gray-200/90 shadow-xl p-2 z-50 hidden animate-modal-pop">
                        <!-- 1. Profile -->
                        <a href="{{ route('admin.profile') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 transition">
                            <svg class="w-5 h-5 text-gray-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span data-i18n="dropdown_profile">Profile</span>
                        </a>

                        <!-- Mobile-only language switch item (above Mode Terang / Mode Gelap) -->
                        <button type="button"
                                id="mobile-admin-lang-toggle"
                                onclick="toggleAdminMobileLanguage(event)"
                                aria-label="Ganti Bahasa"
                                class="sm:hidden w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 transition text-left cursor-pointer">
                            <span id="mobile-admin-lang-flag" class="w-5 h-5 rounded-full overflow-hidden inline-flex items-center justify-center border border-gray-200/80 dark:border-white/20 shrink-0 pointer-events-none" aria-hidden="true">
                                <svg class="w-full h-full" viewBox="0 0 64 64">
                                    <clipPath id="circle-flag-mobile-admin-init"><circle cx="32" cy="32" r="32"/></clipPath>
                                    <g clip-path="url(#circle-flag-mobile-admin-init)">
                                        <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                        <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                    </g>
                                </svg>
                            </span>
                            <span id="mobile-admin-lang-label">Indonesia</span>
                        </button>

                        <!-- 2. Mode Gelap / Mode Terang Toggle -->
                        <button type="button" onclick="toggleAdminTheme()" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 transition text-left cursor-pointer">
                            <svg id="header-theme-moon-icon" class="w-5 h-5 text-gray-700 dark:text-gray-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                            <svg id="header-theme-sun-icon" class="w-5 h-5 text-gray-700 dark:text-gray-200 shrink-0 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span id="header-theme-label" data-i18n="dropdown_theme">Mode Gelap</span>
                        </button>

                        <!-- 3. Beranda -->
                        <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100/80 hover:text-gray-900 transition">
                            <svg class="w-5 h-5 text-gray-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span data-i18n="dropdown_home">Beranda</span>
                        </a>

                        <!-- Separator line -->
                        <hr class="my-1.5 border-gray-100">

                        <!-- 4. Logout -->
                        <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-[#DE3B28] hover:bg-red-50/80 transition text-left cursor-pointer">
                            <svg class="w-5 h-5 text-[#DE3B28] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span data-i18n="dropdown_logout">Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash alerts -->
        @if(session('success'))
            <div class="alert-auto-dismiss p-4 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-semibold rounded-2xl flex justify-between items-center shadow-xs" role="alert">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </span>
                <button type="button" onclick="dismissAlert(this.closest('.alert-auto-dismiss'))" class="text-emerald-600 dark:text-emerald-400 text-base font-medium p-1 cursor-pointer">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-auto-dismiss p-4 bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-[#DE3B28] dark:text-red-300 text-xs font-semibold rounded-2xl flex justify-between items-center shadow-xs" role="alert">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#DE3B28] dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </span>
                <button type="button" onclick="dismissAlert(this.closest('.alert-auto-dismiss'))" class="text-[#DE3B28] dark:text-red-400 text-base font-medium p-1 cursor-pointer">&times;</button>
            </div>
        @endif

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0">
            @yield('admin_content')
        </main>
    </div>

    @if(session('store_status_toast') || session('success') || session('error'))
        <div id="admin-flash-data"
             class="hidden"
             aria-hidden="true"
             @if(session('store_status_toast')) data-store-status-toast="{{ json_encode(session('store_status_toast')) }}" @endif
             @if(!session('store_status_toast') && session('success')) data-flash-success="{{ session('success') }}" @endif
             @if(session('error')) data-flash-error="{{ session('error') }}" @endif>
        </div>
    @endif
</body>
</html>

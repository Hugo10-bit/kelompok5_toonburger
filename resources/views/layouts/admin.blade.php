@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/toon-head.png') }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script>
        if (localStorage.getItem('tb_logged_out') === '1') {
            document.documentElement.style.display = 'none';
            window.location.replace("{{ route('login') }}");
        }
    </script>
    <!-- Prevent theme flash (FOUC) -->
    <script>
        if (localStorage.getItem('toon_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <title>@yield('title', 'Admin Panel - Toon Burger')</title>

    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        toon: {
                            granite: '#385A56',
                            'granite-dark': '#2D4B47',
                            'granite-light': '#4E7571',
                            wheat: '#F1D9B3',
                            'wheat-light': '#FDF8F0',
                            rust: '#C93B2B',
                            'rust-dark': '#B33224',
                            cream: '#FAF1E1',
                            dark: '#1F2937',
                            slate: '#4B5563',
                        }
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #EEF0F2;
            color: #1F2937;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F8F6F0;
        }
        ::-webkit-scrollbar-thumb {
            background: #D5CBB9;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #BAAE9A;
        }
        @keyframes modalPop {
            0% {
                opacity: 0;
                transform: scale(0.96);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-modal-pop {
            animation: modalPop 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* =========================================================
           Global Header Search Input (Clean & Transparent in both Light & Dark)
           ========================================================= */
        #global-header-search,
        #global-header-search:focus,
        #global-header-search:active,
        #global-header-search:hover {
            background-color: transparent !important;
            background: transparent !important;
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
            -webkit-appearance: none !important;
            appearance: none !important;
        }

        /* =========================================================
           Subtle Bottom-Only Card Shadows (Light Mode)
           ========================================================= */
        aside#admin-sidebar,
        header,
        .bg-white.rounded-3xl,
        .bg-white.rounded-2xl,
        .bg-white.rounded-\[28px\],
        .bg-white.rounded-\[32px\],
        .grid > .bg-white,
        .lg\:col-span-8.bg-white,
        .lg\:col-span-4.bg-white {
            box-shadow: 0 7px 16px -4px rgba(0, 0, 0, 0.06), 0 2px 4px -2px rgba(0, 0, 0, 0.03) !important;
            transition: box-shadow 0.2s ease, transform 0.2s ease;
        }

        .grid > .bg-white:hover {
            box-shadow: 0 11px 22px -5px rgba(0, 0, 0, 0.09), 0 4px 6px -2px rgba(0, 0, 0, 0.04) !important;
        }

        /* =========================================================
           Dark Mode Precision Styling (Matching User Mockup)
           ========================================================= */
        html.dark {
            color-scheme: dark;
        }
        html.dark body {
            background-color: #404040 !important;
            color: #E5E7EB !important;
        }
        html.dark ::-webkit-scrollbar-track {
            background: #303030;
        }
        html.dark ::-webkit-scrollbar-thumb {
            background: #525252;
            border-radius: 9999px;
        }
        html.dark ::-webkit-scrollbar-thumb:hover {
            background: #666666;
        }

        /* Main surfaces: Sidebar, Top Header, Dashboard wrapper card */
        html.dark aside#admin-sidebar,
        html.dark header,
        html.dark .bg-white {
            background-color: #303030 !important;
            border-color: #404040 !important;
            color: #E5E7EB;
        }

        /* Bottom-only subtle card shadows in Dark Mode */
        html.dark aside#admin-sidebar,
        html.dark header,
        html.dark .bg-white.rounded-3xl,
        html.dark .bg-white.rounded-2xl,
        html.dark .bg-white.rounded-\[28px\],
        html.dark .bg-white.rounded-\[32px\],
        html.dark .grid > .bg-white,
        html.dark .lg\:col-span-8.bg-white,
        html.dark .lg\:col-span-4.bg-white {
            box-shadow: 0 9px 20px -5px rgba(0, 0, 0, 0.48), 0 3px 6px -2px rgba(0, 0, 0, 0.28) !important;
        }

        html.dark .grid > .bg-white:hover {
            box-shadow: 0 13px 26px -6px rgba(0, 0, 0, 0.62), 0 4px 8px -3px rgba(0, 0, 0, 0.35) !important;
        }

        /* 4 Metric cards inside Dashboard */
        html.dark .grid > .bg-white {
            background-color: #3F3F3F !important;
            border-color: #4A4A4A !important;
        }

        /* Sidebar items in dark mode */
        html.dark #admin-sidebar a.bg-\[\#415C58\],
        html.dark #admin-sidebar a.bg-\[\#3E615D\] {
            background-color: #3E615D !important;
            color: #FFFFFF !important;
        }
        html.dark #admin-sidebar a:not(.bg-\[\#415C58\]):not(.bg-\[\#3E615D\]) {
            color: #D1D5DB !important;
        }
        html.dark #admin-sidebar a:not(.bg-\[\#415C58\]):not(.bg-\[\#3E615D\]):hover {
            background-color: #3D3D3D !important;
            color: #FFFFFF !important;
        }
        html.dark #admin-sidebar button {
            color: #D1D5DB;
        }
        html.dark #admin-sidebar button:hover {
            background-color: #3D3D3D !important;
        }

        /* Header elements */
        html.dark header form,
        html.dark header .bg-\[\#F0F3F7\],
        html.dark header .hover\:bg-\[\#EAEFF4\]:hover {
            background-color: #525252 !important;
            border-color: #5E5E5E !important;
        }
        html.dark header form:focus-within {
            background-color: #525252 !important;
            border-color: #707070 !important;
            box-shadow: 0 0 0 2px rgba(62, 97, 93, 0.4) !important;
        }
        html.dark header input#global-header-search,
        html.dark header input#global-header-search:focus {
            background-color: transparent !important;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            color: #FFFFFF !important;
        }
        html.dark header input#global-header-search::placeholder {
            color: #B0B0B0 !important;
        }
        html.dark #header-lang-btn {
            background-color: #303030 !important;
            border-color: #525252 !important;
            color: #FFFFFF !important;
        }
        html.dark #header-profile-btn .text-gray-900 {
            color: #FFFFFF !important;
        }
        html.dark #header-profile-btn .text-gray-400 {
            color: #B0B0B0 !important;
        }
        html.dark #header-profile-chevron {
            color: #D1D5DB !important;
        }

        /* Header Dropdown (Mockup has #525252 charcoal background with #606060 border) */
        html.dark #header-profile-dropdown,
        html.dark #header-lang-dropdown,
        html.dark #header-search-results {
            background-color: #525252 !important;
            border-color: #606060 !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6), 0 8px 10px -6px rgba(0, 0, 0, 0.6) !important;
        }
        html.dark #header-profile-dropdown a,
        html.dark #header-profile-dropdown button {
            color: #FFFFFF !important;
        }
        html.dark #header-profile-dropdown svg {
            color: #E5E7EB !important;
        }
        html.dark #header-profile-dropdown a:hover,
        html.dark #header-profile-dropdown button:hover {
            background-color: #606060 !important;
            color: #FFFFFF !important;
        }
        html.dark #header-profile-dropdown hr {
            border-color: #666666 !important;
        }
        html.dark #header-profile-dropdown button.text-\[\#DE3B28\],
        html.dark #header-profile-dropdown button.text-\[\#DE3B28\] svg {
            color: #EF4444 !important;
        }
        html.dark #header-profile-dropdown button.text-\[\#DE3B28\]:hover {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #F87171 !important;
        }

        html.dark #header-lang-dropdown button {
            color: #FFFFFF !important;
        }
        html.dark #header-lang-dropdown button:hover {
            background-color: #606060 !important;
            color: #FFFFFF !important;
        }

        /* Modals */
        html.dark #logout-confirm-modal .bg-white,
        html.dark #delete-confirm-modal .bg-white,
        html.dark [id$="-modal"] .bg-white {
            background-color: #303030 !important;
            border-color: #4A4A4A !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
        }

        /* Typography & Borders */
        html.dark .text-gray-900,
        html.dark .text-gray-800 {
            color: #FFFFFF !important;
        }
        html.dark .text-gray-700 {
            color: #E5E7EB !important;
        }
        html.dark .text-gray-600,
        html.dark .text-gray-500,
        html.dark .text-gray-400 {
            color: #B0B0B0 !important;
        }

        html.dark .border-gray-100,
        html.dark .border-gray-200,
        html.dark .border-gray-200\/80,
        html.dark .border-gray-200\/90,
        html.dark .border-gray-300,
        html.dark hr {
            border-color: #3F3F3F !important;
        }

        /* Table inside Pesanan Terbaru (Latest Orders) */
        html.dark table thead tr {
            background-color: #4A4A4A !important;
            border-color: #525252 !important;
        }
        html.dark table thead th {
            color: #D1D5DB !important;
        }
        html.dark table tbody tr {
            background-color: #303030 !important;
            border-color: #3F3F3F !important;
        }
        html.dark table tbody tr:hover {
            background-color: #383838 !important;
        }
        /* Detail button pill in table */
        html.dark table tbody a[data-i18n="dash_detail"] {
            background-color: transparent !important;
            border-color: #888888 !important;
            color: #FFFFFF !important;
        }
        html.dark table tbody a[data-i18n="dash_detail"]:hover {
            background-color: #525252 !important;
            border-color: #AAAAAA !important;
        }

        /* Menu Terlaris (Best Selling) items in dark mode: grey pill #696969 with dark circle #303030 */
        html.dark .bg-\[\#F0F2F4\] {
            background-color: #696969 !important;
            color: #FFFFFF !important;
        }
        html.dark .bg-\[\#F0F2F4\]:hover {
            background-color: #757575 !important;
        }
        html.dark .bg-\[\#F0F2F4\] h4 {
            color: #FFFFFF !important;
        }
        html.dark .bg-\[\#F0F2F4\] span {
            color: #E0E0E0 !important;
        }
        html.dark .bg-\[\#F0F2F4\] span.bg-\[\#3D5A58\] {
            background-color: #303030 !important;
            color: #FFFFFF !important;
        }

        /* Metric card status badges */
        html.dark .bg-\[\#E8F8F0\],
        html.dark .bg-emerald-50 {
            background-color: #1E453B !important;
            color: #34D399 !important;
        }
        html.dark .bg-\[\#FEE2E2\],
        html.dark .bg-red-50 {
            background-color: #4A2626 !important;
            color: #F87171 !important;
        }
        html.dark .bg-amber-50,
        html.dark .bg-orange-50 {
            background-color: #4A3A20 !important;
            color: #FBBF24 !important;
        }
        html.dark .bg-blue-50 {
            background-color: #243852 !important;
            color: #60A5FA !important;
        }

        /* Form elements (input, select, textarea) */
        html.dark input:not([type="checkbox"]):not([type="radio"]):not(#global-header-search),
        html.dark select,
        html.dark textarea {
            background-color: #3F3F3F !important;
            border-color: #525252 !important;
            color: #FFFFFF !important;
        }
        html.dark input:not([type="checkbox"]):not([type="radio"]):not(#global-header-search)::placeholder,
        html.dark textarea::placeholder {
            color: #9CA3AF !important;
        }
        html.dark input:focus:not(#global-header-search),
        html.dark select:focus,
        html.dark textarea:focus {
            border-color: #3E615D !important;
        }
    </style>
</head>
<body class="min-h-screen bg-[#EEF0F2] dark:bg-[#404040] text-[#1F2937] dark:text-[#E5E7EB] transition-colors duration-200 antialiased p-3 sm:p-5 lg:p-6 flex flex-col md:flex-row gap-5 lg:gap-6 pb-20 md:pb-0">

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeLogoutModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl p-8 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 mx-auto my-auto">
            <div class="w-20 h-20 rounded-full border-[3px] border-[#DE3B28]/80 flex items-center justify-center mx-auto mb-5 text-[#DE3B28]">
                <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 tracking-tight mb-2.5" data-i18n="logout_title">
                Konfirmasi Logout
            </h3>

            <p class="text-gray-500 text-xs sm:text-sm leading-relaxed max-w-xs mx-auto mb-7" data-i18n="logout_desc">
                Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button"
                        onclick="closeLogoutModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-gray-700 border border-gray-300 rounded-lg px-7 py-2.5 text-xs font-bold transition min-w-[120px] focus:outline-none cursor-pointer"
                        data-i18n="cancel">
                    Batalkan
                </button>
                <button type="button"
                        id="admin-modal-logout-submit-btn"
                        onclick="submitLogoutForm()"
                        class="bg-[#DE3B28] hover:bg-[#C9301F] active:scale-95 text-white rounded-lg px-7 py-2.5 text-xs font-bold transition min-w-[120px] shadow-xs focus:outline-none cursor-pointer flex items-center justify-center"
                        data-i18n="logout_confirm_btn">
                    Ya, Keluar
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

        <div class="relative bg-white rounded-3xl shadow-2xl p-8 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 mx-auto my-auto">
            <div class="w-20 h-20 rounded-full border-2 border-red-100 bg-red-50/40 flex items-center justify-center mx-auto mb-5 text-[#DE3B28]">
                <svg class="w-10 h-10 text-[#DE3B28]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </div>

            <h3 id="delete-modal-title" class="text-2xl font-bold text-gray-900 tracking-tight mb-2.5" data-i18n="delete_title">
                Konfirmasi Hapus
            </h3>

            <p id="delete-modal-message" class="text-gray-500 text-xs sm:text-sm leading-relaxed max-w-xs mx-auto mb-7" data-i18n="delete_desc">
                Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="flex items-center justify-center gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-gray-700 border border-gray-300 rounded-lg px-7 py-2.5 text-xs font-bold transition min-w-[120px] focus:outline-none cursor-pointer"
                        data-i18n="cancel">
                    Batalkan
                </button>
                <form id="global-delete-form" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-[#DE3B28] hover:bg-[#C9301F] active:scale-95 text-white rounded-lg px-7 py-2.5 text-xs font-bold transition min-w-[120px] shadow-xs focus:outline-none cursor-pointer"
                            data-i18n="delete_confirm_btn">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile sidebar backdrop -->
    <div id="admin-sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 sm:w-72 lg:w-[270px] bg-white text-gray-800 rounded-[36px] border border-gray-200/80 shadow-xs flex flex-col justify-between p-6 flex-shrink-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:flex md:self-start md:sticky md:top-6 md:min-h-[calc(100vh-3rem)] overflow-y-auto">
        <div>
            <!-- Logo Section with Mascot + TOON BURGER text -->
            <div class="pt-2 pb-8 flex items-center justify-between md:justify-center relative">
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center group text-center w-full">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger" class="h-28 sm:h-32 w-auto object-contain transition group-hover:scale-105 block dark:hidden">
                    <img src="{{ asset('images/toonburger-logo-white.png') }}" alt="Toon Burger" class="h-28 sm:h-32 w-auto object-contain transition group-hover:scale-105 hidden dark:block">
                </a>
                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden absolute right-0 top-0 text-gray-400 hover:text-gray-700 p-1.5 rounded-xl hover:bg-gray-100 transition" aria-label="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Primary Navigation Links (Ordered and positioned exactly as mockup) -->
            <nav class="space-y-3 text-sm font-medium">

                <!-- 1. Dashboards -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M560-600q-17 0-28.5-11.5T520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560ZM160-440q-17 0-28.5-11.5T120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160Zm400 320q-17 0-28.5-11.5T520-160v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560Zm-400 0q-17 0-28.5-11.5T120-160v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160Z"/>
                    </svg>
                    <span data-i18n="nav_dashboard">Dashboards</span>
                </a>

                <!-- 2. Admin Profile -->
                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.profile') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 4c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm0 14c-2.03 0-4.43-.82-6.14-2.88C7.55 15.8 9.68 15 12 15s4.45.8 6.14 2.12C16.43 19.18 14.03 20 12 20z" clip-rule="evenodd"/>
                    </svg>
                    <span data-i18n="nav_profile">Admin Profile</span>
                </a>

                <!-- 3. Order processing -->
                <a href="{{ route('admin.orders') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.orders*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6.5 16.5V3.5L7.8 5L9.1 3.5L10.4 5L11.7 3.5L13 5L14.3 3.5L15.6 5L16.9 3.5L18.2 5L19.5 3.5V20" />
                        <path d="M9 8h5M16.2 8h1.4" stroke-width="2" />
                        <path d="M9 11.5h5M16.2 11.5h1.4" stroke-width="2" />
                        <path d="M15.5 16.5H4.8A1.75 1.75 0 0 0 3.05 18.25A1.75 1.75 0 0 0 4.8 20H19.5" />
                        <line x1="15.5" y1="16.5" x2="15.5" y2="20" />
                    </svg>
                    <span data-i18n="nav_orders">Order Processing</span>
                </a>

                <!-- 4. Product Data -->
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.products*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 -960 960 960" fill="currentColor">
                        <path d="M160-120q-33 0-56.5-23.5T80-200v-80q0-17 11.5-28.5T120-320h720q17 0 28.5 11.5T880-280v80q0 33-23.5 56.5T800-120H160Zm263-280q-21 20-77 20t-76-20q-20-20-56-20-28 0-45.5 13.5T121-385q-16 5-28.5-6.5T80-420q0-17 11.5-29.5T119-470q17-9 37-19.5t58-10.5q56 0 76 20t56 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 56-20t76-20q36 0 57 10t38 19q16 8 27.5 21t11.5 30q0 17-12 28.5t-28 6.5q-29-8-45.5-21.5T750-420q-36 0-58 20t-78 20q-56 0-77-20t-57-20q-36 0-57 20Zm202.5-426.5q71.5 13.5 128 42t91.5 74Q880-665 880-600q0 17-11.5 28.5T840-560H120q-17 0-28.5-11.5T80-600q0-65 35-110.5t91.5-74q56.5-28.5 128-42T480-840q74 0 145.5 13.5Z"/>
                    </svg>
                    <span data-i18n="nav_products">Product Data</span>
                </a>

                <!-- 5. Product Categories -->
                <a href="{{ route('admin.categories') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.categories*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                    </svg>
                    <span data-i18n="nav_categories">Product Categories</span>
                </a>
            </nav>
        </div>

        <!-- Secondary Bottom Section (Halaman Utama & Logout dinonaktifkan/dihapus) -->
        {{--
        <div class="pt-8 space-y-2 text-sm font-medium">
            <a href="{{ route('home') }}"
               class="flex items-center gap-4 px-5 py-3.5 transition rounded-full text-[#374151] hover:bg-gray-100/80 hover:text-gray-900">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5 L10.8 3.5 C11.5 2.8 12.5 2.8 13.2 3.5 L21 10.5 V19 C21 20.1 20.1 21 19 21 H5 C3.9 21 3 20.1 3 19 Z" />
                    <path d="M9 21 V15.5 C9 14.7 9.7 14 10.5 14 H13.5 C14.3 14 15 14.7 15 15.5 V21" />
                </svg>
                <span data-i18n="nav_homepage">Home page</span>
            </a>

            <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-4 px-5 py-3.5 text-[#DE3B28] hover:bg-red-50/80 rounded-full transition font-medium group text-left">
                <svg class="w-5 h-5 flex-shrink-0 text-[#DE3B28] transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4 H6 C4.9 4 4 4.9 4 6 V18 C4 19.1 4.9 20 6 20 H11" />
                    <path d="M8 12 H19" />
                    <path d="M15 8 L19 12 L15 16" />
                </svg>
                <span data-i18n="nav_logout">Logout</span>
            </button>
        </div>
        --}}
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col gap-5 lg:gap-6 min-w-0">

        <!-- Top Header -->
        <header class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs px-4 sm:px-8 py-3 sm:py-3.5 flex items-center justify-between gap-3 select-none relative z-30">

            <div class="flex items-center gap-3 flex-1 min-w-0">
                <!-- Hamburger (mobile only) -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition active:scale-95 focus:outline-none shrink-0" aria-label="Buka Menu Admin">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Brand name (mobile only) -->
                <span class="md:hidden font-extrabold text-sm text-gray-900 tracking-tight">Toon Burger Admin</span>

                <!-- Search bar (desktop only) -->
                <div class="relative w-full max-w-[560px] hidden md:block">
                    <form action="{{ route('admin.orders') }}" method="GET" class="w-full bg-[#F0F3F7] hover:bg-[#EAEFF4] rounded-full px-5 py-2.5 sm:py-3 flex items-center gap-3.5 transition focus-within:ring-2 focus-within:ring-[#415C58]/20 focus-within:bg-white focus-within:border focus-within:border-gray-300">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               name="q"
                               id="global-header-search"
                               placeholder="Cari Sesuatu..."
                               autocomplete="off"
                               data-i18n-attr="placeholder:search_placeholder"
                               style="background-color: transparent !important; background: transparent !important; border: none !important; outline: none !important; box-shadow: none !important;"
                               class="!bg-transparent bg-transparent border-0 outline-none focus:outline-none focus:ring-0 text-sm text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-300 w-full font-normal">
                        <button type="button"
                                id="header-search-clear"
                                onclick="clearHeaderSearch()"
                                class="hidden text-gray-400 hover:text-gray-600 p-0.5 rounded-full transition focus:outline-none"
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
                            class="bg-white border border-gray-200/90 rounded-full px-3.5 py-1.5 flex items-center gap-2.5 text-sm font-medium text-gray-700 shadow-2xs hover:bg-gray-50 active:scale-95 transition cursor-pointer focus:outline-none">
                        <span id="header-lang-flag" class="w-6 h-6 rounded-full overflow-hidden flex items-center justify-center border border-gray-100 shrink-0">
                            <svg class="w-full h-full" viewBox="0 0 64 64">
                                <clipPath id="circle-flag-header"><circle cx="32" cy="32" r="32"/></clipPath>
                                <g clip-path="url(#circle-flag-header)">
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
                        <span id="header-lang-label" class="text-sm font-medium text-gray-700">English</span>
                        <svg id="header-lang-chevron" class="w-4 h-4 text-gray-700 stroke-[2] transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="header-lang-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-2xl border border-gray-200/90 shadow-xl p-2 z-50 hidden animate-modal-pop">
                        <button type="button" onclick="selectLanguage('English', 'US')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-800 hover:bg-gray-100 transition">
                            <span class="flex items-center gap-2.5"><span class="text-base">🇺🇸</span><span>English</span></span>
                            <svg id="lang-check-en" class="w-4 h-4 text-[#415C58]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </button>
                        <button type="button" onclick="selectLanguage('Bahasa Indonesia', 'ID')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold text-gray-800 hover:bg-gray-100 transition mt-1">
                            <span class="flex items-center gap-2.5"><span class="text-base">🇮🇩</span><span>Bahasa Indonesia</span></span>
                            <svg id="lang-check-id" class="w-4 h-4 text-[#415C58] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Profile badge -->
                <div class="relative select-none">
                    <button type="button" id="header-profile-btn" onclick="toggleProfileDropdown(event)" class="flex items-center gap-3 cursor-pointer group focus:outline-none text-left">
                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm sm:text-base shrink-0 shadow-xs group-hover:scale-105 transition">Tb</div>
                        <div class="text-left leading-tight hidden sm:block">
                            <div class="font-bold text-sm text-gray-900 leading-tight">Toon Burger</div>
                            <div class="text-xs text-gray-400 font-normal leading-tight mt-0.5">Toonburger@gmail.com</div>
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
                        <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-[#DE3B28] hover:bg-red-50/80 transition text-left cursor-pointer">
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
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-2xl flex justify-between items-center shadow-xs">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ session('success') }}</span>
                </span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 text-base font-bold">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-[#DE3B28] text-xs font-semibold rounded-2xl flex justify-between items-center shadow-xs">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#DE3B28] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </span>
                <button onclick="this.parentElement.remove()" class="text-[#DE3B28] text-base font-bold">&times;</button>
            </div>
        @endif

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0">
            @yield('admin_content')
        </main>
    </div>

    <!-- Mobile bottom navigation bar -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200/80 flex items-stretch" style="padding-bottom: env(safe-area-inset-bottom);">
        <a href="{{ route('admin.dashboard') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.dashboard') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M560-600q-17 0-28.5-11.5T520-640v-160q0-17 11.5-28.5T560-840h240q17 0 28.5 11.5T840-800v160q0 17-11.5 28.5T800-600H560ZM160-440q-17 0-28.5-11.5T120-480v-320q0-17 11.5-28.5T160-840h240q17 0 28.5 11.5T440-800v320q0 17-11.5 28.5T400-440H160Zm400 320q-17 0-28.5-11.5T520-160v-320q0-17 11.5-28.5T560-520h240q17 0 28.5 11.5T840-480v320q0 17-11.5 28.5T800-120H560Zm-400 0q-17 0-28.5-11.5T120-160v-160q0-17 11.5-28.5T160-360h240q17 0 28.5 11.5T440-320v160q0 17-11.5 28.5T400-120H160Z"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_dashboard">Dashboard</span>
        </a>
        <a href="{{ route('admin.orders') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.orders*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6.5 16.5V3.5L7.8 5L9.1 3.5L10.4 5L11.7 3.5L13 5L14.3 3.5L15.6 5L16.9 3.5L18.2 5L19.5 3.5V20" />
                <path d="M9 8h5M16.2 8h1.4" stroke-width="2" />
                <path d="M9 11.5h5M16.2 11.5h1.4" stroke-width="2" />
                <path d="M15.5 16.5H4.8A1.75 1.75 0 0 0 3.05 18.25A1.75 1.75 0 0 0 4.8 20H19.5" />
                <line x1="15.5" y1="16.5" x2="15.5" y2="20" />
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_orders_short">Pesanan</span>
        </a>
        <a href="{{ route('admin.products') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.products*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M160-120q-33 0-56.5-23.5T80-200v-80q0-17 11.5-28.5T120-320h720q17 0 28.5 11.5T880-280v80q0 33-23.5 56.5T800-120H160Zm263-280q-21 20-77 20t-76-20q-20-20-56-20-28 0-45.5 13.5T121-385q-16 5-28.5-6.5T80-420q0-17 11.5-29.5T119-470q17-9 37-19.5t58-10.5q56 0 76 20t56 20q36 0 57-20t77-20q56 0 77 20t57 20q36 0 56-20t76-20q36 0 57 10t38 19q16 8 27.5 21t11.5 30q0 17-12 28.5t-28 6.5q-29-8-45.5-21.5T750-420q-36 0-58 20t-78 20q-56 0-77-20t-57-20q-36 0-57 20Zm202.5-426.5q71.5 13.5 128 42t91.5 74Q880-665 880-600q0 17-11.5 28.5T840-560H120q-17 0-28.5-11.5T80-600q0-65 35-110.5t91.5-74q56.5-28.5 128-42T480-840q74 0 145.5 13.5Z"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_products_short">Produk</span>
        </a>
        <a href="{{ route('admin.categories') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.categories*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_categories_short">Kategori</span>
        </a>
        <button type="button" onclick="confirmLogout(event)"
                class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] text-[#DE3B28] transition active:opacity-70">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4 H6 C4.9 4 4 4.9 4 6 V18 C4 19.1 4.9 20 6 20 H11"/>
                <path d="M8 12 H19"/>
                <path d="M15 8 L19 12 L15 16"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_logout_short">Keluar</span>
        </button>
    </nav>

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('admin-sidebar-backdrop');
            if (!sidebar || !backdrop) return;

            const isClosed = sidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function confirmLogout(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            closeAllHeaderDropdowns();
            const modal = document.getElementById('logout-confirm-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
            return false;
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logout-confirm-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        function submitLogoutForm() {
            try {
                localStorage.setItem('tb_logged_out', '1');
            } catch (e) {}
            const btn = document.getElementById('admin-modal-logout-submit-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `
                    <svg class="w-3.5 h-3.5 animate-spin mr-1.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Keluar...
                `;
            }
            const form = document.getElementById('global-logout-form');
            if (form) {
                form.submit();
            } else {
                window.location.href = "{{ route('logout') }}";
            }
        }

        // Global Delete Modal Handler
        function openDeleteModal(actionUrl, itemName = 'data ini') {
            const modal = document.getElementById('delete-confirm-modal');
            const form = document.getElementById('global-delete-form');
            const message = document.getElementById('delete-modal-message');
            if (modal && form) {
                form.action = actionUrl;
                if (message) {
                    const lang = window._tbLang || 'ID';
                    if (lang === 'ID') {
                        message.textContent = `Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini tidak dapat dibatalkan.`;
                    } else {
                        message.textContent = `Are you sure you want to delete ${itemName}? This action cannot be undone.`;
                    }
                }
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('delete-confirm-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLogoutModal();
                closeDeleteModal();
                closeAllHeaderDropdowns();
            }
        });

        // Header dropdowns and live search handler

        function closeAllHeaderDropdowns() {
            const langDropdown = document.getElementById('header-lang-dropdown');
            const langChevron = document.getElementById('header-lang-chevron');
            if (langDropdown) langDropdown.classList.add('hidden');
            if (langChevron) langChevron.style.transform = 'rotate(0deg)';

            const profileDropdown = document.getElementById('header-profile-dropdown');
            const profileChevron = document.getElementById('header-profile-chevron');
            if (profileDropdown) profileDropdown.classList.add('hidden');
            if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';

            const searchResults = document.getElementById('header-search-results');
            if (searchResults) searchResults.classList.add('hidden');
        }

        function toggleLanguageDropdown(e) {
            if (e) e.stopPropagation();
            const dropdown = document.getElementById('header-lang-dropdown');
            const chevron = document.getElementById('header-lang-chevron');
            const profileDropdown = document.getElementById('header-profile-dropdown');
            const profileChevron = document.getElementById('header-profile-chevron');
            const searchResults = document.getElementById('header-search-results');

            if (profileDropdown) profileDropdown.classList.add('hidden');
            if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
            if (searchResults) searchResults.classList.add('hidden');

            if (dropdown) {
                const isHidden = dropdown.classList.toggle('hidden');
                if (chevron) {
                    chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            }
        }

        const _tbTranslations = {
            ID: {
                // Layout: Nav
                nav_dashboard: 'Dashboards',
                nav_profile: 'Profil Admin',
                nav_orders: 'Proses Pesanan',
                nav_orders_short: 'Pesanan',
                nav_products: 'Data Produk',
                nav_products_short: 'Produk',
                nav_categories: 'Data Kategori',
                nav_categories_short: 'Kategori',
                nav_homepage: 'Halaman Utama',
                nav_logout: 'Keluar',
                nav_logout_short: 'Keluar',
                // Layout: Modals
                logout_title: 'Konfirmasi Keluar',
                logout_desc: 'Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.',
                logout_confirm_btn: 'Ya, Keluar',
                delete_title: 'Konfirmasi Hapus',
                delete_desc: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
                delete_confirm_btn: 'Ya, Hapus',
                cancel: 'Batalkan',
                // Header
                search_placeholder: 'Cari Sesuatu...',
                searching: 'Mencari data...',
                role_admin: 'Administrator',
                // Dashboard
                dash_greeting: 'Halo, Admin Toon Burger',
                dash_subtitle: 'Pantau performa penjualan, dan pesanan aktif Toon Burger hari ini.',
                dash_metric_profit: 'Pendapatan Hari Ini',
                dash_metric_orders: 'Pesanan Hari Ini',
                dash_metric_progress: 'Pesanan Dalam Proses',
                dash_metric_products: 'Total Produk',
                dash_up5: 'Naik 5% dari kemarin',
                dash_up2: 'Naik 2% dari kemarin',
                dash_needs_processing: 'Perlu Segera Di Proses',
                dash_active: 'Aktif',
                dash_out_of_stock: 'Habis',
                dash_latest_order: 'Pesanan Terbaru',
                dash_see_all: 'Lihat semua',
                dash_col_order_num: 'No. Pesanan',
                dash_col_customer: 'Nama Pelanggan',
                dash_col_total: 'Total',
                dash_col_status: 'Status',
                dash_col_action: 'Aksi',
                dash_detail: 'Detail',
                dash_best_selling: 'Menu Terlaris',
                dash_products_sold: 'Produk Terjual',
                // Orders
                orders_title: 'Proses Pesanan',
                orders_subtitle: 'Kelola alur dan status pesanan pelanggan secara realtime.',
                order_detail_title: 'Detail Pesanan',
                order_detail_subtitle: 'Konfirmasi dan kelola status pesanan ini.',
                orders_refresh: 'Segarkan',
                orders_tab_all: 'Semua',
                orders_tab_pending: 'Menunggu',
                orders_tab_processing: 'Diproses',
                orders_tab_ready: 'Siap Diambil',
                orders_tab_completed: 'Selesai',
                orders_tab_cancelled: 'Dibatalkan',
                orders_empty_title: 'Tidak ada pesanan dalam status ini',
                orders_empty_desc: 'Saat ada pesanan baru masuk, pesanan akan segera tampil di sini.',
                orders_status_completed: 'Selesai',
                orders_status_ready: 'Siap Diambil',
                orders_status_processing: 'Diproses',
                orders_status_cancelled: 'Dibatalkan',
                orders_status_pending: 'Menunggu',
                orders_total: 'Total',
                orders_accept: 'Terima Pesanan',
                orders_mark_ready: 'Pesanan Siap',
                orders_complete: 'Selesaikan Pesanan',
                orders_done_badge: 'Pesanan Selesai',
                orders_cancelled_badge: 'Pesanan Dibatalkan',
                orders_view_detail: 'Lihat Detail',
                orders_reject: 'Tolak Pesanan',
                // Order Detail
                order_detail_back: 'Kembali ke Proses Pesanan',
                order_detail_kitchen_status: 'Status Dapur',
                order_status_kitchen_pending: '• Menunggu Konfirmasi',
                order_status_kitchen_confirmed: '• Pesanan Dikonfirmasi',
                order_status_kitchen_preparing: '• Pesanan Sedang Dimasak',
                order_status_kitchen_ready: '• Pesanan Siap Saji',
                order_status_kitchen_completed: '• Pesanan Selesai',
                order_status_kitchen_cancelled: '• Pesanan Dibatalkan',
                order_detail_payment_status: 'Status Pembayaran',
                order_detail_paid: 'Lunas',
                order_detail_unpaid: 'Belum Lunas',
                order_detail_refunded: 'Refund',
                stepper_pending: 'Menunggu',
                stepper_cooking: 'Dimasak',
                stepper_ready: 'Siap Saji',
                stepper_completed: 'Selesai',
                order_detail_order_type: 'Tipe Pesanan',
                order_detail_table: 'Meja',
                order_detail_customer_name: 'Nama Pemesan',
                order_detail_customer_phone: 'No. Telepon',
                order_detail_payment_method: 'Metode Pembayaran',
                order_detail_notes: 'Catatan Pesanan',
                order_detail_no_notes: 'Tanpa catatan',
                order_detail_items_title: 'Rincian Pesanan',
                order_detail_item_note: 'Catatan:',
                order_detail_subtotal: 'Subtotal',
                order_detail_discount: 'Diskon',
                order_detail_tax: 'Pajak',
                order_detail_total: 'Total',
                order_detail_print_receipt: 'Cetak Struk',
                order_detail_accept_cook: 'Terima & Masak Pesanan',
                order_detail_mark_ready: 'Tandai Siap Saji',
                order_detail_complete: 'Selesaikan Pesanan',
                order_detail_cancel: 'Batalkan Pesanan',
                // Products
                products_title: 'Kelola Data Produk',
                products_subtitle: 'Kelola daftar menu dan produk Toon Burger',
                products_search: 'Cari nama menu...',
                products_add_btn: 'Tambah Produk',
                products_col_no: 'No',
                products_col_menu: 'Menu / Produk',
                products_col_category: 'Kategori',
                products_col_price: 'Harga',
                products_col_stock: 'Stok',
                products_col_status: 'Status',
                products_col_action: 'Aksi',
                products_available: 'Tersedia',
                products_out: 'Habis',
                products_empty_title: 'Belum Ada Menu',
                products_empty_desc: 'Klik tombol + Tambah Produk untuk memasukkan menu baru.',
                // Add Product Modal
                products_add_modal_title: 'Tambah Produk Baru',
                products_add_modal_desc: 'Lengkapi informasi menu Toon Burger yang akan ditambahkan.',
                products_label_name: 'Nama Produk',
                products_label_category: 'Kategori',
                products_label_price: 'Harga (Rp)',
                products_label_stock: 'Stok (Porsi)',
                products_label_photo: 'Upload Foto',
                products_label_desc: 'Deskripsi',
                products_add_submit: 'Tambah Produk',
                // Edit Product Modal
                products_edit_modal_title: 'Edit Menu',
                products_edit_modal_desc: 'Perbarui rincian, harga, atau foto menu Toon Burger.',
                products_edit_photo: 'Ganti Foto Menu',
                products_save_changes: 'Simpan Perubahan',
                products_all_categories: 'Semua Kategori',
                products_unit_portion: 'Porsi',
                products_placeholder_name: 'Nama Produk Baru',
                products_placeholder_desc: 'Deskripsi menu Toon Burger...',
                products_toggle_status_title: 'Klik untuk ubah ketersediaan',
                products_edit_btn_title: 'Edit Produk',
                products_delete_btn_title: 'Hapus Produk',
                // Categories
                categories_title: 'Kelola Kategori Produk',
                categories_subtitle: 'Kelola kategori untuk pengelompokan menu Toon Burger',
                categories_search: 'Cari kategori...',
                categories_add_btn: 'Tambah Kategori',
                categories_col_no: 'No',
                categories_col_name: 'Nama Kategori',
                categories_col_action: 'Aksi',
                categories_empty_title: 'Belum Ada Kategori',
                categories_empty_desc: 'Klik tombol + Tambah Kategori untuk membuat kategori menu baru.',
                categories_add_modal_title: 'Tambah Kategori',
                categories_label_name: 'Nama Kategori',
                categories_save: 'Simpan',
                categories_edit_modal_title: 'Edit Kategori',
                categories_save_changes: 'Simpan Perubahan',
                // Coupons
                coupons_tab: 'Voucher & Kupon Promo',
                tables_tab: 'Meja Restoran',
                pos_tab: 'Buka Kasir / POS',
                coupons_title: 'Voucher & Kupon Promo',
                coupons_subtitle: 'Buat kode voucher diskon baru dan pantau penggunaan promo pelanggan Toon Burger.',
                coupons_add_btn: '+ Buat Voucher Baru',
                coupons_col_code: 'Kode Kupon',
                coupons_col_type: 'Tipe & Nilai Diskon',
                coupons_col_min: 'Min. Belanja & Max Diskon',
                coupons_col_usage: 'Penggunaan',
                coupons_col_status: 'Status',
                coupons_col_action: 'Aksi',
                // Tables
                tables_title: 'Manajemen Meja Restoran',
                tables_subtitle: 'Pantau ketersediaan meja, status terisi, dan tautan QR pemesanan pelanggan Toon Burger.',
                tables_open_menu: 'Buka Menu Meja Ini',
                tables_change: 'Ubah',
                // General
                btn_cancel: 'Batal',
                transaction: 'Transaksi',
                queue: 'Antrean',
                currency: 'Rp',
                // Header Dropdown (Top Right)
                dropdown_profile: 'Profile',
                dropdown_theme: 'Mode Gelap',
                dropdown_home: 'Beranda',
                dropdown_logout: 'Logout',
            },
            EN: {
                // Layout: Nav
                nav_dashboard: 'Dashboards',
                nav_profile: 'Admin Profile',
                nav_orders: 'Order Processing',
                nav_orders_short: 'Orders',
                nav_products: 'Product Data',
                nav_products_short: 'Products',
                nav_categories: 'Product Categories',
                nav_categories_short: 'Categories',
                nav_homepage: 'Home page',
                nav_logout: 'Logout',
                nav_logout_short: 'Logout',
                // Layout: Modals
                logout_title: 'Confirm Logout',
                logout_desc: 'Are you sure you want to log out? You will need to log in again to access the admin panel.',
                logout_confirm_btn: 'Yes, Logout',
                delete_title: 'Confirm Delete',
                delete_desc: 'Are you sure you want to delete this item? This action cannot be undone.',
                delete_confirm_btn: 'Yes, Delete',
                cancel: 'Cancel',
                // Header
                search_placeholder: 'Search for something...',
                searching: 'Searching...',
                role_admin: 'Administrator',
                // Dashboard
                dash_greeting: 'Hello, Toon Burger Admin.',
                dash_subtitle: "Monitor Toon Burger's sales performance and active orders for today.",
                dash_metric_profit: "Today's Profits",
                dash_metric_orders: "Today's Orders",
                dash_metric_progress: 'Order in Progress',
                dash_metric_products: 'Total Products',
                dash_up5: 'Up 5% from yesterday.',
                dash_up2: 'Up 2% from yesterday.',
                dash_needs_processing: 'Needs to be processed immediately.',
                dash_active: 'Active',
                dash_out_of_stock: 'Out of Stock',
                dash_latest_order: 'Latest Order',
                dash_see_all: 'See all',
                dash_col_order_num: 'Order Number',
                dash_col_customer: 'Customer Name',
                dash_col_total: 'Total',
                dash_col_status: 'Status',
                dash_col_action: 'Action',
                dash_detail: 'Detail',
                dash_best_selling: 'Best Selling Menu',
                dash_products_sold: 'Products Sold',
                // Orders
                orders_title: 'Order Processing',
                orders_subtitle: 'Manage order flow and customer order status in real time.',
                order_detail_title: 'Order Details',
                order_detail_subtitle: 'Confirm and manage the status of this order.',
                orders_refresh: 'Refresh',
                orders_tab_all: 'All',
                orders_tab_pending: 'Pending',
                orders_tab_processing: 'Processing',
                orders_tab_ready: 'Ready to Serve',
                orders_tab_completed: 'Completed',
                orders_tab_cancelled: 'Cancelled',
                orders_empty_title: 'No orders with this status',
                orders_empty_desc: 'New orders will appear here when they come in.',
                orders_status_completed: 'Completed',
                orders_status_ready: 'Ready to Serve',
                orders_status_processing: 'Processing',
                orders_status_cancelled: 'Cancelled',
                orders_status_pending: 'Pending',
                orders_total: 'Total',
                orders_accept: 'Accept Order',
                orders_mark_ready: 'Order Ready',
                orders_complete: 'Complete Order',
                orders_done_badge: 'Order Completed',
                orders_cancelled_badge: 'Order Cancelled',
                orders_view_detail: 'View Detail',
                orders_reject: 'Reject Order',
                // Order Detail
                order_detail_back: 'Back to Order Processing',
                order_detail_kitchen_status: 'Kitchen Status',
                order_status_kitchen_pending: '• Awaiting Confirmation',
                order_status_kitchen_confirmed: '• Order Confirmed',
                order_status_kitchen_preparing: '• Order Cooking',
                order_status_kitchen_ready: '• Order Ready to Serve',
                order_status_kitchen_completed: '• Order Completed',
                order_status_kitchen_cancelled: '• Order Cancelled',
                order_detail_payment_status: 'Payment Status',
                order_detail_paid: 'Paid',
                order_detail_unpaid: 'Unpaid',
                order_detail_refunded: 'Refunded',
                stepper_pending: 'Pending',
                stepper_cooking: 'Cooking',
                stepper_ready: 'Ready to Serve',
                stepper_completed: 'Completed',
                order_detail_order_type: 'Order Type',
                order_detail_table: 'Table',
                order_detail_customer_name: 'Customer Name',
                order_detail_customer_phone: 'Phone Number',
                order_detail_payment_method: 'Payment Method',
                order_detail_notes: 'Order Notes',
                order_detail_no_notes: 'No notes',
                order_detail_items_title: 'Order Items',
                order_detail_item_note: 'Note:',
                order_detail_subtotal: 'Subtotal',
                order_detail_discount: 'Discount',
                order_detail_tax: 'Tax',
                order_detail_total: 'Total',
                order_detail_print_receipt: 'Print Receipt',
                order_detail_accept_cook: 'Accept & Cook Order',
                order_detail_mark_ready: 'Mark Ready to Serve',
                order_detail_complete: 'Complete Order',
                order_detail_cancel: 'Cancel Order',
                // Products
                products_title: 'Manage Product Data',
                products_subtitle: 'Manage the menu and product list of Toon Burger',
                products_search: 'Search menu name...',
                products_add_btn: 'Add Product',
                products_col_no: 'No',
                products_col_menu: 'Menu / Product',
                products_col_category: 'Category',
                products_col_price: 'Price',
                products_col_stock: 'Stock',
                products_col_status: 'Status',
                products_col_action: 'Action',
                products_available: 'Available',
                products_out: 'Out of Stock',
                products_empty_title: 'No menu items yet',
                products_empty_desc: 'Click + Add Product to add a new menu item.',
                // Add Product Modal
                products_add_modal_title: 'Add New Product',
                products_add_modal_desc: 'Fill in the details for the new Toon Burger menu item.',
                products_label_name: 'Product Name',
                products_label_category: 'Category',
                products_label_price: 'Price (IDR)',
                products_label_stock: 'Stock (Portions)',
                products_label_photo: 'Upload Photo',
                products_label_desc: 'Description',
                products_add_submit: 'Add Product',
                // Edit Product Modal
                products_edit_modal_title: 'Edit Menu',
                products_edit_modal_desc: 'Update the details, price, or photo of this menu item.',
                products_edit_photo: 'Replace Menu Photo',
                products_save_changes: 'Save Changes',
                products_all_categories: 'All Categories',
                products_unit_portion: 'Portions',
                products_placeholder_name: 'New Product Name',
                products_placeholder_desc: 'Toon Burger menu description...',
                products_toggle_status_title: 'Click to change availability',
                products_edit_btn_title: 'Edit Product',
                products_delete_btn_title: 'Delete Product',
                // Categories
                categories_title: 'Manage Product Categories',
                categories_subtitle: 'Manage categories for Toon Burger menu grouping',
                categories_search: 'Search category...',
                categories_add_btn: 'Add Category',
                categories_col_no: 'No',
                categories_col_name: 'Category Name',
                categories_col_action: 'Action',
                categories_empty_title: 'No Categories Yet',
                categories_empty_desc: 'Click + Add Category to create a new menu category.',
                categories_add_modal_title: 'Add Category',
                categories_label_name: 'Category Name',
                categories_save: 'Save',
                categories_edit_modal_title: 'Edit Category',
                categories_save_changes: 'Save Changes',
                // Coupons
                coupons_tab: 'Vouchers & Promo Coupons',
                tables_tab: 'Restaurant Tables',
                pos_tab: 'Open Cashier / POS',
                coupons_title: 'Vouchers & Promo Coupons',
                coupons_subtitle: 'Create new discount voucher codes and track Toon Burger customer promotions.',
                coupons_add_btn: '+ Create New Voucher',
                coupons_col_code: 'Coupon Code',
                coupons_col_type: 'Discount Type & Value',
                coupons_col_min: 'Min. Spend & Max Discount',
                coupons_col_usage: 'Usage',
                coupons_col_status: 'Status',
                coupons_col_action: 'Action',
                // Tables
                tables_title: 'Restaurant Table Management',
                tables_subtitle: 'Monitor table availability, occupied status, and QR order links for Toon Burger customers.',
                tables_open_menu: 'Open Table Menu',
                tables_change: 'Update',
                // General
                btn_cancel: 'Cancel',
                transaction: 'Transaction',
                queue: 'Queue',
                currency: 'IDR',
                // Header Dropdown (Top Right)
                dropdown_profile: 'Profile',
                dropdown_theme: 'Dark Mode',
                dropdown_home: 'Home',
                dropdown_logout: 'Logout',
            }
        };

        function applyTranslations(lang) {
            const isEn = (lang === 'EN' || lang === 'US');
            const dict = _tbTranslations[isEn ? 'EN' : 'ID'] || _tbTranslations['ID'];
            const currencyStr = isEn ? 'IDR' : 'Rp';

            // Text content
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key] !== undefined) el.textContent = dict[key];
            });

            // Currency elements
            document.querySelectorAll('[data-i18n="currency"], [data-currency], .currency-prefix').forEach(el => {
                el.textContent = currencyStr;
            });

            // Attribute translation (e.g. placeholder)
            document.querySelectorAll('[data-i18n-attr]').forEach(el => {
                el.getAttribute('data-i18n-attr').split(';').forEach(pair => {
                    const [attr, key] = pair.split(':');
                    if (dict[key] !== undefined) el.setAttribute(attr.trim(), dict[key]);
                });
            });

            // Special dynamic options (e.g. Category select)
            const optAllCat = document.getElementById('opt-all-categories');
            if (optAllCat && dict['products_all_categories']) {
                const count = optAllCat.getAttribute('data-count');
                optAllCat.textContent = `${dict['products_all_categories']}${count ? ' (' + count + ')' : ''}`;
            }
        }

        function selectLanguage(lang, code) {
            window._tbLang = code;
            const label = document.getElementById('header-lang-label');
            if (label) label.textContent = lang;

            const checkEn = document.getElementById('lang-check-en');
            const checkId = document.getElementById('lang-check-id');
            if (checkEn && checkId) {
                if (code === 'US') {
                    checkEn.classList.remove('hidden');
                    checkId.classList.add('hidden');
                } else {
                    checkEn.classList.add('hidden');
                    checkId.classList.remove('hidden');
                }
            }

            const flagContainer = document.getElementById('header-lang-flag');
            if (flagContainer) {
                if (code === 'US') {
                    flagContainer.innerHTML = `
                        <svg class="w-full h-full" viewBox="0 0 64 64">
                            <clipPath id="circle-flag-header"><circle cx="32" cy="32" r="32"/></clipPath>
                            <g clip-path="url(#circle-flag-header)">
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
                        </svg>`;
                } else {
                    flagContainer.innerHTML = `
                        <svg class="w-full h-full" viewBox="0 0 64 64">
                            <clipPath id="circle-flag-id"><circle cx="32" cy="32" r="32"/></clipPath>
                            <g clip-path="url(#circle-flag-id)">
                                <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                            </g>
                        </svg>`;
                }
            }

            applyTranslations(code === 'US' ? 'EN' : 'ID');
            updateAdminThemeUI(getAdminTheme());

            try {
                localStorage.setItem('tb_admin_lang', code);
            } catch (err) {}

            const dropdown = document.getElementById('header-lang-dropdown');
            const chevron = document.getElementById('header-lang-chevron');
            if (dropdown) dropdown.classList.add('hidden');
            if (chevron) chevron.style.transform = 'rotate(0deg)';
        }

        function toggleProfileDropdown(e) {
            if (e) e.stopPropagation();
            const dropdown = document.getElementById('header-profile-dropdown');
            const chevron = document.getElementById('header-profile-chevron');
            const langDropdown = document.getElementById('header-lang-dropdown');
            const langChevron = document.getElementById('header-lang-chevron');
            const searchResults = document.getElementById('header-search-results');

            if (langDropdown) langDropdown.classList.add('hidden');
            if (langChevron) langChevron.style.transform = 'rotate(0deg)';
            if (searchResults) searchResults.classList.add('hidden');

            if (dropdown) {
                const isHidden = dropdown.classList.toggle('hidden');
                if (chevron) {
                    chevron.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            }
        }

        // ==========================================
        // Theme Management (Light / Dark Mode)
        // ==========================================
        function getAdminTheme() {
            return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }

        function updateAdminThemeUI(theme) {
            const isDark = (theme === 'dark');
            const moonIcon = document.getElementById('header-theme-moon-icon');
            const sunIcon = document.getElementById('header-theme-sun-icon');
            const themeLabel = document.getElementById('header-theme-label');
            const isEn = (window._tbLang === 'US' || window._tbLang === 'EN');

            if (moonIcon && sunIcon) {
                if (isDark) {
                    moonIcon.classList.add('hidden');
                    sunIcon.classList.remove('hidden');
                } else {
                    moonIcon.classList.remove('hidden');
                    sunIcon.classList.add('hidden');
                }
            }

            if (themeLabel) {
                if (isDark) {
                    themeLabel.textContent = isEn ? 'Light Mode' : 'Mode Terang';
                } else {
                    themeLabel.textContent = isEn ? 'Dark Mode' : 'Mode Gelap';
                }
            }
        }

        function setAdminTheme(theme) {
            try {
                localStorage.setItem('toon_theme', theme);
            } catch (err) {}

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            updateAdminThemeUI(theme);
        }

        function toggleAdminTheme() {
            const current = getAdminTheme();
            const next = (current === 'dark') ? 'light' : 'dark';
            setAdminTheme(next);
        }

        let searchDebounceTimer = null;
        const searchInput = document.getElementById('global-header-search');
        const searchClearBtn = document.getElementById('header-search-clear');
        const searchResults = document.getElementById('header-search-results');
        const searchLoading = document.getElementById('header-search-loading');
        const searchContent = document.getElementById('header-search-content');

        function clearHeaderSearch() {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
            }
            if (searchClearBtn) searchClearBtn.classList.add('hidden');
            if (searchResults) searchResults.classList.add('hidden');
            if (searchContent) searchContent.innerHTML = '';
        }

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                clearTimeout(searchDebounceTimer);

                if (query.length > 0) {
                    if (searchClearBtn) searchClearBtn.classList.remove('hidden');
                } else {
                    if (searchClearBtn) searchClearBtn.classList.add('hidden');
                }

                if (query.length < 1) {
                    if (searchResults) searchResults.classList.add('hidden');
                    if (searchContent) searchContent.innerHTML = '';
                    return;
                }

                if (searchResults) searchResults.classList.remove('hidden');
                if (searchLoading) searchLoading.classList.remove('hidden');
                if (searchContent) searchContent.innerHTML = '';

                searchDebounceTimer = setTimeout(() => {
                    fetch(`{{ route('admin.search.live') }}?q=${encodeURIComponent(query)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Network error');
                        return res.json();
                    })
                    .then(data => {
                        if (searchLoading) searchLoading.classList.add('hidden');
                        renderHeaderSearchResults(data, query);
                    })
                    .catch(err => {
                        if (searchLoading) searchLoading.classList.add('hidden');
                        if (searchContent) {
                            searchContent.innerHTML = `<div class="text-xs text-gray-500 py-3 text-center">Gagal memuat hasil pencarian.</div>`;
                        }
                    });
                }, 200);
            });

            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0 && searchResults) {
                    searchResults.classList.remove('hidden');
                }
            });
        }

        function escapeHeaderHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function renderHeaderSearchResults(data, query) {
            if (!searchContent) return;

            const isEn = (window._tbLang === 'US');
            const hasProducts = data.products && data.products.length > 0;
            const hasOrders = data.orders && data.orders.length > 0;
            const hasCategories = data.categories && data.categories.length > 0;

            if (!hasProducts && !hasOrders && !hasCategories) {
                searchContent.innerHTML = `
                    <div class="text-center py-6 text-gray-400">
                        <svg class="w-7 h-7 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-xs font-medium text-gray-500">${isEn ? 'No results for' : 'Tidak ada hasil untuk'} "<span class="font-bold text-gray-800">${escapeHeaderHtml(query)}</span>"</p>
                        <p class="text-[11px] text-gray-400 mt-1">${isEn ? 'Try another keyword or check spelling.' : 'Coba kata kunci lain atau periksa ejaan.'}</p>
                    </div>
                `;
                return;
            }

            let html = '<div class="space-y-3.5">';

            if (hasProducts) {
                html += `
                    <div>
                        <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                            <span>${isEn ? 'Products' : 'Produk'} (${data.products.length})</span>
                            <a href="{{ route('admin.products') }}?search=${encodeURIComponent(query)}" class="text-[#415C58] hover:underline normal-case font-semibold">${isEn ? 'All Products' : 'Semua Produk'} &rarr;</a>
                        </div>
                        <div class="space-y-1 mt-1.5">
                `;
                data.products.forEach(p => {
                    html += `
                        <a href="${p.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center text-xs shrink-0 font-bold text-[#FFA000]">
                                    🍔
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-gray-800 group-hover:text-[#415C58] transition truncate">${escapeHeaderHtml(p.name)}</div>
                                    <div class="text-[11px] text-gray-500 font-medium">${isEn && p.price_formatted ? p.price_formatted.replace(/^Rp\s*/i, 'IDR ') : p.price_formatted}</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full ${p.is_available ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'}">
                                ${p.is_available ? (isEn ? 'Available' : 'Tersedia') : (isEn ? 'Out of Stock' : 'Habis')}
                            </span>
                        </a>
                    `;
                });
                html += `</div></div>`;
            }

            if (hasOrders) {
                html += `
                    <div>
                        <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                            <span>${isEn ? 'Orders' : 'Pesanan'} (${data.orders.length})</span>
                            <a href="{{ route('admin.orders') }}?search=${encodeURIComponent(query)}" class="text-[#415C58] hover:underline normal-case font-semibold">${isEn ? 'All Orders' : 'Semua Pesanan'} &rarr;</a>
                        </div>
                        <div class="space-y-1 mt-1.5">
                `;
                data.orders.forEach(o => {
                    html += `
                        <a href="${o.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center text-xs shrink-0 font-bold text-blue-600">
                                    🧾
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs font-bold text-gray-800 group-hover:text-[#415C58] transition truncate">${escapeHeaderHtml(o.order_number)} <span class="text-gray-400 font-normal">(${escapeHeaderHtml(o.customer_name)})</span></div>
                                    <div class="text-[11px] text-gray-500 font-medium">${isEn && o.total_formatted ? o.total_formatted.replace(/^Rp\s*/i, 'IDR ') : o.total_formatted}</div>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 capitalize">
                                ${escapeHeaderHtml(o.status)}
                            </span>
                        </a>
                    `;
                });
                html += `</div></div>`;
            }

            if (hasCategories) {
                html += `
                    <div>
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">${isEn ? 'Categories' : 'Kategori'}</div>
                        <div class="flex flex-wrap gap-1.5 mt-2 px-2">
                `;
                data.categories.forEach(c => {
                    html += `
                        <a href="${c.url}" class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 hover:bg-[#415C58] hover:text-white text-gray-700 rounded-lg text-xs font-medium transition">
                            <span>🏷️</span>
                            <span>${escapeHeaderHtml(c.name)}</span>
                        </a>
                    `;
                });
                html += `</div></div>`;
            }

            html += '</div>';
            searchContent.innerHTML = html;
        }

        // Global Outside Click
        document.addEventListener('click', function(e) {
            const langDropdown = document.getElementById('header-lang-dropdown');
            const langBtn = document.getElementById('header-lang-btn');
            const langChevron = document.getElementById('header-lang-chevron');
            if (langDropdown && !langDropdown.contains(e.target) && (!langBtn || !langBtn.contains(e.target))) {
                langDropdown.classList.add('hidden');
                if (langChevron) langChevron.style.transform = 'rotate(0deg)';
            }

            const profileDropdown = document.getElementById('header-profile-dropdown');
            const profileBtn = document.getElementById('header-profile-btn');
            const profileChevron = document.getElementById('header-profile-chevron');
            if (profileDropdown && !profileDropdown.contains(e.target) && (!profileBtn || !profileBtn.contains(e.target))) {
                profileDropdown.classList.add('hidden');
                if (profileChevron) profileChevron.style.transform = 'rotate(0deg)';
            }

            const searchInput = document.getElementById('global-header-search');
            const searchResults = document.getElementById('header-search-results');
            if (searchResults && searchInput && !searchResults.contains(e.target) && !searchInput.contains(e.target)) {
                searchResults.classList.add('hidden');
            }
        });

        // Restore theme preference
        try {
            const savedTheme = localStorage.getItem('toon_theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            setAdminTheme(savedTheme);
        } catch (err) {}

        // Restore language preference
        try {
            const savedLang = localStorage.getItem('tb_admin_lang') || 'ID';
            window._tbLang = savedLang;
            if (savedLang === 'US') {
                selectLanguage('English', 'US');
            } else {
                selectLanguage('Bahasa Indonesia', 'ID');
            }
        } catch (err) {}

        // Reload page on Back / Forward navigation to prevent displaying cached authenticated views after logout
        window.addEventListener('pageshow', function (event) {
            if (localStorage.getItem('tb_logged_out') === '1') {
                document.documentElement.style.display = 'none';
                window.location.replace("{{ route('login') }}");
                return;
            }

            const navEntries = window.performance && window.performance.getEntriesByType ? window.performance.getEntriesByType("navigation") : [];
            const isBackForward = event.persisted || 
                (navEntries.length > 0 && navEntries[0].type === 'back_forward') || 
                (window.performance && window.performance.navigation && window.performance.navigation.type === 2);

            if (isBackForward) {
                document.documentElement.style.display = 'none';
                window.location.reload();
            }
        });
    </script>
</body>
</html>

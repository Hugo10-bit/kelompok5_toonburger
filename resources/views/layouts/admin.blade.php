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
    <title>@yield('title', 'Admin Panel - Toon Burger')</title>

    <!-- Google Fonts: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;0,900;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
    </style>
</head>
<body class="min-h-screen bg-[#EEF0F2] text-[#1F2937] antialiased p-3 sm:p-5 lg:p-6 flex flex-col md:flex-row gap-5 lg:gap-6 pb-20 md:pb-0">

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
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger" class="h-28 sm:h-32 w-auto object-contain transition group-hover:scale-105">
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
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <!-- 4 Bars with outline -->
                        <rect x="3" y="14" width="2.5" height="7" rx="0.8" />
                        <rect x="8" y="10" width="2.5" height="11" rx="0.8" />
                        <rect x="13" y="12" width="2.5" height="9" rx="0.8" />
                        <rect x="18" y="7" width="2.5" height="14" rx="0.8" />
                        <!-- Connecting line with 4 small circles -->
                        <path d="M4.25 11 L9.25 6.5 L14.25 9.5 L19.25 4" />
                        <circle cx="4.25" cy="11" r="1.3" fill="none" stroke="currentColor" stroke-width="1.8" />
                        <circle cx="9.25" cy="6.5" r="1.3" fill="none" stroke="currentColor" stroke-width="1.8" />
                        <circle cx="14.25" cy="9.5" r="1.3" fill="none" stroke="currentColor" stroke-width="1.8" />
                        <circle cx="19.25" cy="4" r="1.3" fill="none" stroke="currentColor" stroke-width="1.8" />
                    </svg>
                    <span data-i18n="nav_dashboard">Dashboards</span>
                </a>

                <!-- 2. Admin Profile -->
                <a href="{{ route('admin.profile') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.profile') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="7" r="3" />
                        <rect x="4.5" y="14" width="15" height="6.5" rx="3.25" />
                    </svg>
                    <span data-i18n="nav_profile">Admin Profile</span>
                </a>

                <!-- 3. Order processing -->
                <a href="{{ route('admin.orders') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.orders*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Receipt outline with top-left folded tab and zigzag bottom -->
                        <path d="M7 4 H18.5 A 1 1 0 0 1 19.5 5 V 20 L 16.5 18.5 L 13.5 20 L 10.5 18.5 L 7.5 20 V 7.5" />
                        <path d="M7.5 7.5 H 4.5 C 3.9 7.5 3.5 7.1 3.5 6.5 V 4.5 C 3.5 4.2 3.8 4 4.1 4 H 7.5" />
                        <line x1="9.5" y1="8.5" x2="16.5" y2="8.5" />
                        <line x1="9.5" y1="12" x2="16.5" y2="12" />
                        <line x1="9.5" y1="15.5" x2="13.5" y2="15.5" />
                    </svg>
                    <span data-i18n="nav_orders">Order Processing</span>
                </a>

                <!-- 4. Product Data -->
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.products*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Burger (left) -->
                        <path d="M 3.5 10 C 3.5 6.8 6 5 10 5 C 13.5 5 15.8 6.5 16.2 9.5 H 3.5 Z" />
                        <line x1="3.5" y1="13" x2="16.5" y2="13" />
                        <line x1="3.5" y1="17" x2="16.5" y2="17" />
                        <!-- Drink with straw (right) -->
                        <line x1="18.5" y1="2.5" x2="18.5" y2="6.5" />
                        <line x1="16" y1="6.5" x2="21" y2="6.5" />
                        <path d="M 20.5 6.5 L 19.5 17.5 C 19.4 18.6 18.5 19.5 17.4 19.5 H 16" />
                    </svg>
                    <span data-i18n="nav_products">Product Data</span>
                </a>

                <!-- 5. Product Categories -->
                <a href="{{ route('admin.categories') }}"
                   class="flex items-center gap-4 px-5 py-3.5 transition rounded-full {{ request()->routeIs('admin.categories*') ? 'bg-[#415C58] text-white font-medium shadow-xs' : 'text-[#374151] hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <!-- Front price tag -->
                        <path d="M 8.5 3.5 H 15.5 A 1 1 0 0 1 16.2 3.8 L 21.2 8.8 A 1 1 0 0 1 21.2 10.2 L 14.2 17.2 A 1 1 0 0 1 12.8 17.2 L 7.8 12.2 A 1 1 0 0 1 7.5 11.5 V 4.5 A 1 1 0 0 1 8.5 3.5 Z" />
                        <circle cx="12" cy="7.5" r="1.3" fill="currentColor" />
                        <!-- Back tag outline -->
                        <path d="M 5 8.5 L 3.2 10.3 A 1 1 0 0 0 3.2 11.7 L 10.2 18.7 A 1 1 0 0 0 11.6 18.7 L 13.5 16.8" />
                    </svg>
                    <span data-i18n="nav_categories">Product Categories</span>
                </a>
            </nav>
        </div>

        <!-- Secondary Bottom Section (Mockup: Home page and Logout) -->
        <div class="pt-8 space-y-2 text-sm font-medium">
            <!-- Home page -->
            <a href="{{ route('home') }}"
               class="flex items-center gap-4 px-5 py-3.5 transition rounded-full text-[#374151] hover:bg-gray-100/80 hover:text-gray-900">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5 L10.8 3.5 C11.5 2.8 12.5 2.8 13.2 3.5 L21 10.5 V19 C21 20.1 20.1 21 19 21 H5 C3.9 21 3 20.1 3 19 Z" />
                    <path d="M9 21 V15.5 C9 14.7 9.7 14 10.5 14 H13.5 C14.3 14 15 14.7 15 15.5 V21" />
                </svg>
                <span data-i18n="nav_homepage">Home page</span>
            </a>

            <!-- Logout Button -->
            <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-4 px-5 py-3.5 text-[#DE3B28] hover:bg-red-50/80 rounded-full transition font-medium group text-left">
                <svg class="w-5 h-5 flex-shrink-0 text-[#DE3B28] transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4 H6 C4.9 4 4 4.9 4 6 V18 C4 19.1 4.9 20 6 20 H11" />
                    <path d="M8 12 H19" />
                    <path d="M15 8 L19 12 L15 16" />
                </svg>
                <span data-i18n="nav_logout">Logout</span>
            </button>
        </div>
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
                               placeholder="Search for something..."
                               autocomplete="off"
                               data-i18n-attr="placeholder:search_placeholder"
                               class="bg-transparent text-sm text-gray-800 placeholder-gray-400 outline-none w-full font-normal">
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
                    <div id="header-profile-dropdown" class="absolute right-0 top-full mt-2 w-64 bg-white rounded-2xl border border-gray-200/90 shadow-xl p-3 z-50 hidden animate-modal-pop">
                        <div class="px-3 py-2 border-b border-gray-100 pb-3 mb-2 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shrink-0">Tb</div>
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-xs text-gray-900 truncate">Toon Burger</div>
                                <div class="text-[11px] text-gray-400 truncate">Toonburger@gmail.com</div>
                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#E8F8F0] text-[#10B981]" data-i18n="role_admin">Administrator</span>
                            </div>
                        </div>
                        <div>
                            <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 text-xs font-semibold transition">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span data-i18n="nav_logout">Logout</span>
                            </button>
                        </div>
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
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="14" width="2.5" height="7" rx="0.8"/>
                <rect x="8" y="10" width="2.5" height="11" rx="0.8"/>
                <rect x="13" y="12" width="2.5" height="9" rx="0.8"/>
                <rect x="18" y="7" width="2.5" height="14" rx="0.8"/>
                <path d="M4.25 11 L9.25 6.5 L14.25 9.5 L19.25 4"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_dashboard">Dashboard</span>
        </a>
        <a href="{{ route('admin.orders') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.orders*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7 4 H18.5 A 1 1 0 0 1 19.5 5 V 20 L 16.5 18.5 L 13.5 20 L 10.5 18.5 L 7.5 20 V 7.5"/>
                <line x1="9.5" y1="8.5" x2="16.5" y2="8.5"/>
                <line x1="9.5" y1="12" x2="16.5" y2="12"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_orders_short">Pesanan</span>
        </a>
        <a href="{{ route('admin.products') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.products*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M 3.5 10 C 3.5 6.8 6 5 10 5 C 13.5 5 15.8 6.5 16.2 9.5 H 3.5 Z"/>
                <line x1="3.5" y1="13" x2="16.5" y2="13"/>
                <line x1="3.5" y1="17" x2="16.5" y2="17"/>
            </svg>
            <span class="text-[10px] font-semibold leading-none" data-i18n="nav_products_short">Produk</span>
        </a>
        <a href="{{ route('admin.categories') }}"
           class="flex-1 flex flex-col items-center justify-center gap-1 py-2.5 min-h-[56px] transition {{ request()->routeIs('admin.categories*') ? 'text-[#385A56]' : 'text-gray-400 active:text-[#385A56]' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M 8.5 3.5 H 15.5 A 1 1 0 0 1 16.2 3.8 L 21.2 8.8 A 1 1 0 0 1 21.2 10.2 L 14.2 17.2 A 1 1 0 0 1 12.8 17.2 L 7.8 12.2 A 1 1 0 0 1 7.5 11.5 V 4.5 A 1 1 0 0 1 8.5 3.5 Z"/>
                <circle cx="12" cy="7.5" r="1.3" fill="currentColor"/>
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
                nav_categories: 'Kategori Produk',
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
                search_placeholder: 'Cari sesuatu...',
                searching: 'Mencari data...',
                role_admin: 'Administrator',
                // Dashboard
                dash_greeting: 'Halo, Admin Toon Burger.',
                dash_subtitle: 'Pantau performa penjualan dan pesanan aktif hari ini.',
                dash_metric_profit: 'Keuntungan Hari Ini',
                dash_metric_orders: 'Pesanan Hari Ini',
                dash_metric_progress: 'Pesanan Diproses',
                dash_metric_products: 'Total Produk',
                dash_up5: 'Naik 5% dari kemarin.',
                dash_up2: 'Naik 2% dari kemarin.',
                dash_needs_processing: 'Perlu segera diproses.',
                dash_active: 'Aktif',
                dash_out_of_stock: 'Habis',
                dash_latest_order: 'Pesanan Terbaru',
                dash_see_all: 'Lihat semua',
                dash_col_order_num: 'Nomor Pesanan',
                dash_col_customer: 'Nama Pelanggan',
                dash_col_total: 'Total',
                dash_col_status: 'Status',
                dash_col_action: 'Aksi',
                dash_detail: 'Detail',
                dash_best_selling: 'Menu Terlaris',
                // Orders
                orders_title: 'Proses Pesanan',
                orders_subtitle: 'Kelola alur dan status pesanan pelanggan secara realtime.',
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
                // Orders
                orders_title: 'Order Processing',
                orders_subtitle: 'Manage order flow and customer order status in real time.',
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
                products_label_price: 'Price (Rp)',
                products_label_stock: 'Stock (Portions)',
                products_label_photo: 'Upload Photo',
                products_label_desc: 'Description',
                products_add_submit: 'Add Product',
                // Edit Product Modal
                products_edit_modal_title: 'Edit Menu',
                products_edit_modal_desc: 'Update the details, price, or photo of this menu item.',
                products_edit_photo: 'Replace Menu Photo',
                products_save_changes: 'Save Changes',
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
            }
        };

        function applyTranslations(lang) {
            const dict = _tbTranslations[lang] || _tbTranslations['ID'];
            // Text content
            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (dict[key] !== undefined) el.textContent = dict[key];
            });
            // Attribute translation (e.g. placeholder)
            document.querySelectorAll('[data-i18n-attr]').forEach(el => {
                el.getAttribute('data-i18n-attr').split(';').forEach(pair => {
                    const [attr, key] = pair.split(':');
                    if (dict[key] !== undefined) el.setAttribute(attr.trim(), dict[key]);
                });
            });
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
                                    <div class="text-[11px] text-gray-500 font-medium">${p.price_formatted}</div>
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
                                    <div class="text-[11px] text-gray-500 font-medium">${o.total_formatted}</div>
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

        // Restore language preference
        try {
            const savedLang = localStorage.getItem('tb_admin_lang') || 'ID';
            window._tbLang = savedLang;
            if (savedLang === 'US') {
                selectLanguage('English', 'US');
            } else {
                selectLanguage('Bahasa Indonesia', 'ID');
            }
        } catch (e) {}
    </script>
</body>
</html>

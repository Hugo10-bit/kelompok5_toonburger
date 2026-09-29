<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/toon-head.png') }}">
    <title>@yield('title', 'Toon Burger - Smash Burger & Takeaway Hub')</title>

    <!-- Google Fonts: Poppins + Nunito -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Nunito:wght@900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bites: {
                            yellow: '#FFC72C',
                            'yellow-dark': '#E8A400',
                            orange: '#F9961F',
                            red: '#D92625',
                            'red-dark': '#A51B12',
                            dark: '#121212',
                            card: '#1E1E1E',
                            cream: '#FFFDF9',
                            bg: '#F8F6F0',
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; overflow-x: clip; }
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: clip;
            max-width: 100vw;
            animation: pageEnter 0.25s ease-out;
            transition: opacity 0.22s ease-out;
            caret-color: #D92625;
        }
        body.page-exiting {
            opacity: 0 !important;
        }
        *:focus-visible {
            outline: 2px solid #D92625;
            outline-offset: 2px;
        }
        /* Custom Themed Scrollbar */
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
        @keyframes pageEnter {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        #page-loader-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3.5px;
            width: 100%;
            transform: scaleX(0);
            transform-origin: left;
            background: linear-gradient(90deg, #FFC72C, #F9961F, #D92625);
            z-index: 99999;
            transition: transform 0.35s ease, opacity 0.3s ease;
            pointer-events: none;
            box-shadow: 0 0 10px rgba(249, 150, 31, 0.7);
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
            animation: modalPop 0.16s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-full bg-bites-bg text-gray-900 flex flex-col antialiased">
    <!-- Top Progress Bar for Smooth Navigation -->
    <div id="page-loader-bar"></div>

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4"
         style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; margin: 0; z-index: 999999; align-items: center; justify-content: center;">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-[3px] transition-opacity duration-200"
             style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;"
             onclick="closeLogoutModal()"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl p-8 sm:p-10 max-w-[460px] w-full text-center z-10 select-none animate-modal-pop border border-[#EFE5D0] mx-auto my-auto">
            <div class="w-[92px] h-[92px] rounded-full border-[4.5px] border-[#9AA887] flex items-center justify-center mx-auto mb-6 bg-white shadow-2xs">
                <svg class="w-10 h-10 text-[#9AA887]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5c-.83 0-1.5.67-1.5 1.5v7.2c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V6c0-.83-.67-1.5-1.5-1.5zM12 17.2a1.8 1.8 0 100 3.6 1.8 1.8 0 000-3.6z"/>
                </svg>
            </div>

            <h3 class="text-2xl sm:text-[27px] font-bold text-[#2D3139] tracking-tight mb-3">
                Konfirmasi Logout
            </h3>

            <p class="text-[#555C68] text-sm sm:text-[14.5px] leading-relaxed max-w-sm mx-auto mb-8 font-normal">
                Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses akun Anda.
            </p>

            <div class="flex items-center justify-center gap-3.5 sm:gap-4">
                <button type="button"
                        onclick="closeLogoutModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-[#2D3139] border border-[#4B5563] rounded-lg px-8 py-2.5 text-sm font-semibold transition min-w-[130px] focus:outline-none cursor-pointer">
                    Batalkan
                </button>
                <button type="button"
                        id="modal-logout-submit-btn"
                        onclick="submitLogoutForm()"
                        class="bg-[#DE3B28] hover:bg-[#C9301F] active:scale-95 text-white rounded-lg px-8 py-2.5 text-sm font-semibold transition min-w-[130px] shadow-xs focus:outline-none cursor-pointer flex items-center justify-center">
                    ya, keluar
                </button>
            </div>
        </div>
    </div>

    <!-- Global Hidden Form for Logout -->
    <form id="global-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Navbar -->
    <header class="sticky top-0 z-40 px-3 sm:px-6 lg:px-8 pt-3 sm:pt-4 pb-2 select-none">
        <div class="w-full max-w-[1440px] xl:max-w-[1520px] mx-auto relative">
            <div class="flex items-center justify-between px-5 sm:px-7 lg:px-8 py-2.5 sm:py-3 rounded-full shadow-lg border border-white/20 backdrop-blur-md transition relative"
                 style="background-color: #3b6e64;">

                <!-- Brand logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 group shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Toon Burger Logo"
                         class="h-8 sm:h-9 w-auto object-contain transition group-hover:scale-105">
                    <span class="font-black text-white text-base sm:text-lg uppercase tracking-wide shrink-0"
                          style="font-family: 'Nunito', 'Arial Black', sans-serif; letter-spacing: 0.04em;">
                        TOON BURGER
                    </span>
                </a>

                <!-- Nav links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm">
                    <a href="{{ route('home') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-bold
                              {{ request()->routeIs('home') ? 'bg-white/20 text-white shadow-2xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        Beranda
                    </a>
                    <a href="{{ route('menu') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-bold
                              {{ request()->routeIs('menu*') ? 'bg-white/20 text-white shadow-2xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        Menu
                    </a>
                    <a href="{{ route('about') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-bold
                              {{ request()->routeIs('about') ? 'bg-white/20 text-white shadow-2xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        Tentang
                    </a>
                    <a href="{{ route('contact') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-bold
                              {{ request()->routeIs('contact') ? 'bg-white/20 text-white shadow-2xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Search bar -->
                <div class="relative hidden md:block w-48 sm:w-60 lg:w-72 xl:w-80">
                    <form action="{{ route('menu') }}" method="GET" class="w-full bg-[#F5F6FA] hover:bg-white focus-within:bg-white focus-within:ring-2 focus-within:ring-white/50 rounded-full px-4 py-2 flex items-center gap-2.5 transition shadow-2xs">
                        <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text"
                               name="q"
                               id="home-navbar-search"
                               placeholder="Cheese Burger..."
                               autocomplete="off"
                               class="bg-transparent text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none w-full font-normal">
                        <button type="button"
                                id="home-search-clear"
                                onclick="clearHomeNavbarSearch()"
                                class="hidden text-gray-400 hover:text-gray-600 p-0.5 rounded-full transition focus:outline-none"
                                aria-label="Bersihkan pencarian">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>

                    <!-- Live search dropdown -->
                    <div id="home-search-dropdown" class="absolute left-0 right-0 top-full mt-2 bg-white rounded-2xl border border-gray-200 shadow-2xl p-2.5 z-50 hidden max-h-80 overflow-y-auto animate-modal-pop">
                        <div id="home-search-loading" class="hidden text-center py-3 text-xs text-gray-400">
                            <svg class="w-4 h-4 animate-spin mx-auto text-[#3b6e64] mb-1" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mencari menu...
                        </div>
                        <div id="home-search-content"></div>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    <!-- Cart drawer button -->
                    <button type="button"
                            onclick="toggleCartDrawer()"
                            id="cart-btn"
                            class="relative w-10 h-10 rounded-full bg-[#E2E8F0]/90 hover:bg-white flex items-center justify-center text-gray-800 shadow-xs transition active:scale-95 focus:outline-none cursor-pointer shrink-0"
                            aria-label="Keranjang Belanja">
                        <svg class="w-5 h-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        <span id="cart-badge"
                              class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-[#DE3B28] text-white text-[10.5px] font-extrabold flex items-center justify-center border-2 border-white leading-none shadow-xs">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                        </span>
                    </button>

                    @auth
                        <!-- User profile dropdown -->
                        <div class="relative" id="user-dropdown-container">
                            <button type="button"
                                    onclick="toggleUserDropdown(event)"
                                    id="user-menu-button"
                                    class="flex items-center gap-2.5 cursor-pointer group focus:outline-none text-left select-none">
                                <div class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition shrink-0">
                                    {{ strtoupper(substr(Auth::user()->name ?? 'Tb', 0, 2)) }}
                                </div>
                                <div class="text-left leading-tight hidden xl:block">
                                    <div class="font-bold text-sm text-white leading-tight">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <div class="text-xs text-white/70 font-normal leading-tight mt-0.5 truncate max-w-[140px]">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>
                                <svg id="user-menu-arrow" class="w-4 h-4 text-white/80 stroke-[2] transition-transform duration-200 hidden sm:block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2.5 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 p-3 z-50 animate-modal-pop">
                                <div class="px-2 py-2 border-b border-gray-100 pb-3 mb-2 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'Tb', 0, 2)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-xs text-gray-900 truncate">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div class="text-[11px] text-gray-400 truncate">
                                            {{ Auth::user()->email }}
                                        </div>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#E8F8F0] text-[#10B981] capitalize">
                                            {{ Auth::user()->role }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-1 text-xs font-medium text-gray-700">
                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <span>Pesanan Saya</span>
                                    </a>
                                    @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition text-[#3b6e64] font-semibold">
                                            <svg class="w-4 h-4 text-[#3b6e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            <span>Dashboard Admin</span>
                                        </a>
                                        <a href="{{ route('admin.pos') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition text-amber-600 font-semibold">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                            <span>Kasir POS</span>
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 text-xs font-semibold transition">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            <span>Logout</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-1 text-xs sm:text-sm font-bold text-white shrink-0 select-none">
                            <a href="{{ route('login') }}" class="hover:text-yellow-300 transition px-2 py-1">
                                Login
                            </a>
                            <span class="text-white/50">/</span>
                            <a href="{{ route('register') }}" class="hover:text-yellow-300 transition px-2 py-1">
                                Register
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Hamburger Menu Button -->
                    <button type="button"
                            onclick="toggleMobileNav()"
                            id="mobile-nav-toggle"
                            class="lg:hidden p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition focus:outline-none"
                            aria-label="Toggle Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
              <div id="mobile-nav-menu" class="hidden lg:hidden absolute top-full left-0 right-0 z-50 mt-2.5 rounded-2xl overflow-hidden shadow-2xl p-3 border border-gray-200 bg-white text-gray-800">
                <div class="space-y-1 text-sm font-semibold">
                    <!-- Mobile Search -->
                    <div class="mb-2 pt-1">
                        <form action="{{ route('menu') }}" method="GET" class="w-full bg-[#F5F6FA] rounded-full px-4 py-2 flex items-center gap-2.5 shadow-2xs">
                            <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                   name="q"
                                   placeholder="Cheese Burger..."
                                   class="bg-transparent text-xs text-gray-800 placeholder-gray-400 outline-none w-full font-normal">
                        </form>
                    </div>

                    <a href="{{ route('home') }}" data-page-transition onclick="toggleMobileNav()"
                       class="block px-4 py-2 rounded-xl transition
                                        {{ request()->routeIs('home') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                        Beranda
                    </a>
                    <a href="{{ route('menu') }}" data-page-transition onclick="toggleMobileNav()"
                       class="block px-4 py-2 rounded-xl transition
                                        {{ request()->routeIs('menu*') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                        Menu
                    </a>
                    <a href="{{ route('about') }}" data-page-transition onclick="toggleMobileNav()"
                       class="block px-4 py-2 rounded-xl transition
                                        {{ request()->routeIs('about') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                        Tentang
                    </a>
                    <a href="{{ route('contact') }}" data-page-transition onclick="toggleMobileNav()"
                       class="block px-4 py-2 rounded-xl transition
                                        {{ request()->routeIs('contact') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                        Kontak
                    </a>
                    @auth
                        <a href="{{ route('orders.index') }}" onclick="toggleMobileNav()"
                                    class="block px-4 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                            Pesanan Saya
                        </a>
                        <button type="button" onclick="confirmLogout(event)"
                            class="w-full text-left block px-4 py-2 rounded-xl text-red-700 hover:text-red-800 hover:bg-red-50 transition font-semibold">
                            Logout
                        </button>
                    @endauth
            </div>
        </div>
    </div>
</header>




    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm font-medium px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold">[Sukses]</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-900 font-bold">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
            <div class="bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-medium px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold">[Perhatian]</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-900 font-bold">&times;</button>
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER (PERSIS FOTO media_1790644528320.png) -->
    @include('partials.footer')

    <!-- CART FLOATING CARD -->
    <div id="cart-backdrop" onclick="toggleCartDrawer()" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity duration-300"></div>
    <div id="cart-drawer" class="fixed top-20 right-4 w-[90vw] max-w-sm bg-white rounded-3xl shadow-2xl border border-gray-200/60 z-50 flex flex-col max-h-[calc(100vh-6rem)] overflow-hidden pointer-events-none opacity-0 invisible" style="transform: scale(0.95) translateY(-8px); transition: transform 0.25s cubic-bezier(0.16,1,0.3,1), opacity 0.2s ease;">

        <!-- Cart Header (Fixed Top) -->
        <div class="p-4 sm:p-4.5 bg-gray-50/90 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-bites-yellow flex items-center justify-center font-extrabold text-xs text-bites-dark shadow-xs">TB</div>
                <div>
                    <h3 class="font-extrabold text-gray-900 text-sm leading-tight">Keranjang Pesanan</h3>
                    <p class="text-[11px] text-gray-500" id="cart-items-count-text">0 menu dipilih</p>
                </div>
            </div>
            <button onclick="toggleCartDrawer()" class="text-gray-400 hover:text-gray-700 hover:bg-gray-200 w-7 h-7 rounded-full flex items-center justify-center text-lg font-bold transition">&times;</button>
        </div>

        <!-- Cart Body (Items + Promo + Summary + Button all flowing together) -->
        <div class="overflow-y-auto p-4 space-y-3.5 flex-1 hide-scrollbar">

            <!-- Items Container -->
            <div id="cart-items-container" class="space-y-2.5">
                <div class="text-center py-10 text-gray-400">
                    <div class="font-bold text-sm mb-1">[Kosong]</div>
                    <p class="text-xs font-medium">Keranjang Anda masih kosong</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Pilih menu favorit Anda di katalog!</p>
                </div>
            </div>

            <!-- Coupon Box (directly under items) -->
            <div id="cart-coupon-section" class="pt-2 border-t border-gray-100">
                <label class="block text-[11px] font-bold text-gray-700 mb-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-bites-orange" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                    Punya Kupon Promo?
                </label>
                <div class="flex gap-1.5">
                    <input type="text" id="coupon-input" placeholder="KODE PROMO (misal: TOONBURGER50)" class="flex-1 bg-gray-50 border border-gray-300 rounded-xl px-3 py-1.5 text-xs uppercase font-bold tracking-wider focus:outline-none focus:border-bites-orange focus:bg-white transition">
                    <button onclick="applyCoupon()" class="bg-gray-900 hover:bg-black text-white text-xs font-extrabold px-3.5 py-1.5 rounded-xl transition shadow-xs active:scale-95">
                        Pakai
                    </button>
                </div>
                <div id="applied-coupon-badge" class="hidden text-xs bg-green-50 text-green-700 border border-green-200 p-2 rounded-xl flex items-center justify-between font-medium mt-1.5">
                    <div class="flex items-center gap-1">
                        <span class="text-green-600 font-bold">✓</span>
                        <span id="coupon-text">Promo Terpasang</span>
                    </div>
                    <button onclick="removeCoupon()" class="text-red-500 hover:text-red-700 font-bold px-1">&times;</button>
                </div>
            </div>

            <!-- Price Breakdown (directly under coupon) -->
            <div id="cart-summary-section" class="bg-gray-50 rounded-2xl p-3.5 border border-gray-200/80 space-y-1.5 text-xs text-gray-600">
                <div class="flex justify-between">
                    <span>Subtotal Menu:</span>
                    <span id="cart-subtotal" class="font-bold text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between text-green-600 font-medium">
                    <span>Diskon Promo:</span>
                    <span id="cart-discount" class="font-bold">- Rp 0</span>
                </div>
                <div class="flex justify-between">
                    <span>Pajak PB1 (10%):</span>
                    <span id="cart-tax" class="font-semibold text-gray-900">Rp 0</span>
                </div>
                <div class="flex justify-between text-xs font-black text-gray-900 pt-1.5 border-t border-gray-200">
                    <span>Total Tagihan:</span>
                    <span id="cart-total" class="text-bites-red font-black text-sm">Rp 0</span>
                </div>
            </div>

            <!-- Checkout Action Button (Ends right here!) -->
            <div id="cart-action-section" class="pt-0.5 pb-1">
                <a href="{{ route('orders.checkout') }}" id="checkout-btn" class="w-full bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-black py-3 px-4 rounded-2xl flex items-center justify-center gap-2 shadow-md hover:shadow-lg transition active:scale-98 text-xs sm:text-sm">
                    <span>Lanjut ke Pembayaran</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- PRODUCT DETAIL & CUSTOMIZATION MODAL -->
    <div id="product-modal-backdrop" onclick="closeProductModal()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 hidden"></div>
    <div id="product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl animate-fade-in" onclick="event.stopPropagation()">

            <!-- Modal Header / Image -->
            <div class="relative bg-gradient-to-tr from-amber-500 to-orange-400 h-48 overflow-hidden flex items-center justify-center">
                <img id="modal-product-image" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E" alt="Menu" class="w-full h-full object-cover">
                <button onclick="closeProductModal()" class="absolute top-3 right-3 bg-black/50 hover:bg-black/80 text-white rounded-full w-8 h-8 flex items-center justify-center text-lg font-bold transition">
                    &times;
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto flex-1 space-y-4">
                <div>
                    <div class="flex items-start justify-between gap-2">
                        <h3 id="modal-product-name" class="font-extrabold text-xl text-gray-900 leading-tight">Product Name</h3>
                        <span id="modal-product-price" class="text-bites-red font-black text-lg whitespace-nowrap">Rp 0</span>
                    </div>
                    <p id="modal-product-desc" class="text-xs text-gray-500 mt-1 leading-relaxed">Description</p>
                    <div class="flex items-center gap-3 mt-2 text-[11px] text-gray-500 font-medium">
                        <span id="modal-product-calories" class="bg-gray-100 px-2 py-0.5 rounded font-semibold">0 kcal</span>
                        <span id="modal-product-time" class="hidden">0 menit</span>
                    </div>
                </div>

                <!-- Dynamic Options Form -->
                <form id="product-options-form" class="space-y-4 pt-2 border-t border-gray-100">
                    <input type="hidden" id="modal-product-id" name="product_id" value="">

                    <div id="modal-options-container" class="space-y-4">
                        <!-- Filled by JS -->
                    </div>

                    <!-- Notes -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Koki (Opsional):</label>
                        <input type="text" id="modal-notes" name="notes" placeholder="Contoh: Jangan pakai bawang bombay, extra saus..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 text-xs focus:ring-2 focus:ring-bites-orange focus:outline-none">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between gap-3">
                <div class="flex items-center border border-gray-300 rounded-xl bg-white overflow-hidden">
                    <button type="button" onclick="adjustModalQty(-1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 font-bold text-sm">-</button>
                    <input type="number" id="modal-quantity" value="1" min="1" readonly class="w-10 text-center font-bold text-xs text-gray-900 border-none focus:outline-none">
                    <button type="button" onclick="adjustModalQty(1)" class="px-3 py-2 text-gray-600 hover:bg-gray-100 font-bold text-sm">+</button>
                </div>

                <button type="button" onclick="submitAddToCart()" class="flex-1 bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-extrabold py-3 px-4 rounded-xl flex items-center justify-between text-xs sm:text-sm shadow-md transition active:scale-98">
                    <span>+ Tambahkan ke Keranjang</span>
                    <span id="modal-total-btn-price" class="font-black">Rp 0</span>
                </button>
            </div>

        </div>
    </div>

    <!-- GLOBAL JAVASCRIPT FOR CART & MODALS -->
    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentModalProduct = null;

        function formatRupiah(num) {
            return 'Rp ' + Number(num).toLocaleString('id-ID');
        }

        function openCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const backdrop = document.getElementById('cart-backdrop');
            if (!drawer) return;
            drawer.classList.remove('invisible', 'pointer-events-none', 'opacity-0');
            drawer.classList.add('opacity-100');
            drawer.style.transform = 'scale(1) translateY(0)';
            if (backdrop) backdrop.classList.remove('hidden');
        }

        function closeCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const backdrop = document.getElementById('cart-backdrop');
            if (!drawer) return;
            drawer.style.transform = 'scale(0.95) translateY(-8px)';
            drawer.classList.add('pointer-events-none', 'opacity-0');
            drawer.classList.remove('opacity-100');
            if (backdrop) backdrop.classList.add('hidden');
            setTimeout(() => {
                if (drawer.classList.contains('opacity-0')) {
                    drawer.classList.add('invisible');
                }
            }, 250);
        }

        function toggleCartDrawer() {
            const drawer = document.getElementById('cart-drawer');
            const isClosed = !drawer || drawer.classList.contains('invisible') || drawer.classList.contains('opacity-0');

            if (isClosed) {
                // Scroll to top first, then open cart
                window.scrollTo({ top: 0, behavior: 'smooth' });
                const alreadyAtTop = window.scrollY < 5;
                const delay = alreadyAtTop ? 0 : 400;
                setTimeout(() => {
                    openCartDrawer();
                    refreshCart();
                }, delay);
            } else {
                closeCartDrawer();
            }
        }

        async function refreshCart() {
            try {
                const res = await fetch('{{ route("cart.index") }}');
                const data = await res.json();
                renderCart(data);
            } catch (e) {
                console.error(e);
            }
        }

        function renderCart(cart) {
            const container = document.getElementById('cart-items-container');
            const badge = document.getElementById('cart-badge');
            const countText = document.getElementById('cart-items-count-text');
            const checkoutTotal = document.getElementById('checkout-btn-total');
            const couponSection = document.getElementById('cart-coupon-section');
            const summarySection = document.getElementById('cart-summary-section');

            badge.innerText = cart.item_count || 0;
            countText.innerText = `${cart.item_count || 0} menu dipilih`;

            document.getElementById('cart-subtotal').innerText = formatRupiah(cart.subtotal);
            document.getElementById('cart-discount').innerText = '- ' + formatRupiah(cart.discount);
            document.getElementById('cart-tax').innerText = formatRupiah(cart.tax);
            document.getElementById('cart-total').innerText = formatRupiah(cart.total);
            if (checkoutTotal) {
                checkoutTotal.innerText = formatRupiah(cart.total);
            }

            const couponBadge = document.getElementById('applied-coupon-badge');
            const couponText = document.getElementById('coupon-text');
            if (cart.coupon) {
                couponBadge.classList.remove('hidden');
                couponText.innerText = `Promo ${cart.coupon.code} aktif (-${formatRupiah(cart.discount)})`;
            } else {
                couponBadge.classList.add('hidden');
            }

            const actionSection = document.getElementById('cart-action-section');

            if (!cart.items || cart.items.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-16 text-gray-400">
                        <div class="font-bold text-sm mb-1">[Kosong]</div>
                        <p class="text-sm font-medium">Keranjang Anda masih kosong</p>
                        <p class="text-xs text-gray-400 mt-1">Pilih menu favorit Anda di katalog!</p>
                    </div>`;
                if (couponSection) couponSection.classList.add('hidden');
                if (summarySection) summarySection.classList.add('hidden');
                if (actionSection) actionSection.classList.add('hidden');
                return;
            }

            if (couponSection) couponSection.classList.remove('hidden');
            if (summarySection) summarySection.classList.remove('hidden');
            if (actionSection) actionSection.classList.remove('hidden');

            container.innerHTML = cart.items.map(item => `
                <div class="bg-gray-50 border border-gray-200/80 rounded-2xl p-3.5 flex gap-3 items-center">
                    <img src="${item.image ? '/' + item.image : '/images/burger-bg.jpg'}" alt="${item.name}" class="w-16 h-16 object-cover rounded-xl border border-gray-200 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-1">
                            <h4 class="font-bold text-xs text-gray-900 truncate">${item.name}</h4>
                            <button onclick="removeCartItem('${item.cart_key}')" class="text-gray-400 hover:text-red-500 text-sm font-bold">&times;</button>
                        </div>
                        <div class="text-[11px] text-gray-500 font-semibold mt-0.5">${formatRupiah(item.unit_price)}</div>

                        ${item.options && item.options.length ? `
                            <div class="text-[10px] text-gray-400 mt-1 flex flex-wrap gap-1">
                                ${item.options.map(o => `<span class="bg-white px-1.5 py-0.5 rounded border border-gray-200">+ ${o.value_name}</span>`).join('')}
                            </div>
                        ` : ''}

                        ${item.notes ? `<div class="text-[10px] text-amber-700 italic mt-0.5 truncate">"${item.notes}"</div>` : ''}

                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-200/50">
                            <span class="font-black text-xs text-gray-900">${formatRupiah(item.total_price)}</span>
                            <div class="flex items-center border border-gray-300 rounded-lg bg-white overflow-hidden text-xs">
                                <button onclick="updateCartQty('${item.cart_key}', ${item.quantity - 1})" class="px-2 py-0.5 text-gray-600 hover:bg-gray-100 font-bold">-</button>
                                <span class="px-2 font-bold text-gray-900">${item.quantity}</span>
                                <button onclick="updateCartQty('${item.cart_key}', ${item.quantity + 1})" class="px-2 py-0.5 text-gray-600 hover:bg-gray-100 font-bold">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        async function updateCartQty(cartKey, qty) {
            const res = await fetch('{{ route("cart.update") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ cart_key: cartKey, quantity: qty })
            });
            const data = await res.json();
            if (data.cart) renderCart(data.cart);
        }

        async function removeCartItem(cartKey) {
            const res = await fetch('{{ route("cart.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ cart_key: cartKey })
            });
            const data = await res.json();
            if (data.cart) renderCart(data.cart);
        }

        async function applyCoupon() {
            const code = document.getElementById('coupon-input').value;
            if (!code) return;
            const res = await fetch('{{ route("cart.coupon.apply") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body: JSON.stringify({ code })
            });
            const data = await res.json();
            if (data.success) {
                document.getElementById('coupon-input').value = '';
                renderCart(data.cart);
            } else {
                alert(data.message || 'Kupon tidak dapat digunakan.');
            }
        }

        async function removeCoupon() {
            const res = await fetch('{{ route("cart.coupon.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN }
            });
            const data = await res.json();
            if (data.cart) renderCart(data.cart);
        }

        async function openProductModal(productId) {
            try {
                const res = await fetch(`/product/${productId}`);
                const data = await res.json();
                if (!data.success) return;

                currentModalProduct = data.product;
                document.getElementById('modal-product-id').value = currentModalProduct.id;
                document.getElementById('modal-product-name').innerText = currentModalProduct.name;
                document.getElementById('modal-product-desc').innerText = currentModalProduct.description || 'Pilihan terbaik dari Toon Burger.';
                document.getElementById('modal-product-price').innerText = formatRupiah(currentModalProduct.price);
                document.getElementById('modal-product-image').src = currentModalProduct.image ? '/' + currentModalProduct.image : '/images/burger-bg.jpg';
                document.getElementById('modal-product-calories').innerText = `${currentModalProduct.calories || 450} kcal`;
                document.getElementById('modal-product-time').innerText = `${currentModalProduct.prep_time_minutes || 8} menit`;
                document.getElementById('modal-quantity').value = 1;
                document.getElementById('modal-notes').value = '';

                const optContainer = document.getElementById('modal-options-container');
                if (currentModalProduct.options && currentModalProduct.options.length > 0) {
                    optContainer.innerHTML = currentModalProduct.options.map(opt => `
                        <div class="bg-gray-50 p-3.5 rounded-2xl border border-gray-200/80">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-xs font-bold text-gray-900">${opt.name}</h5>
                                ${opt.is_required ? `<span class="text-[10px] bg-red-100 text-red-700 font-bold px-1.5 py-0.5 rounded">Wajib</span>` : `<span class="text-[10px] text-gray-400">Opsional</span>`}
                            </div>
                            <div class="space-y-1.5">
                                ${opt.values.map(val => `
                                    <label class="flex items-center justify-between p-2 rounded-xl bg-white border border-gray-200 cursor-pointer hover:border-bites-orange transition text-xs">
                                        <div class="flex items-center gap-2">
                                            <input type="${opt.type === 'single' ? 'radio' : 'checkbox'}"
                                                   name="option_${opt.id}${opt.type === 'single' ? '' : '[]'}"
                                                   value="${val.id}"
                                                   data-price="${val.additional_price}"
                                                   ${val.is_default ? 'checked' : ''}
                                                   onchange="recalculateModalPrice()"
                                                   class="text-bites-orange focus:ring-bites-orange">
                                            <span class="font-medium text-gray-800">${val.name}</span>
                                        </div>
                                        <span class="font-bold text-gray-600 text-[11px]">
                                            ${Number(val.additional_price) > 0 ? '+ ' + formatRupiah(val.additional_price) : 'Gratis'}
                                        </span>
                                    </label>
                                `).join('')}
                            </div>
                        </div>
                    `).join('');
                } else {
                    optContainer.innerHTML = `<p class="text-xs text-gray-400 italic">Menu standar siap saji.</p>`;
                }

                recalculateModalPrice();
                document.getElementById('product-modal').classList.remove('hidden');
                document.getElementById('product-modal-backdrop').classList.remove('hidden');
            } catch (e) {
                console.error(e);
            }
        }

        function closeProductModal() {
            document.getElementById('product-modal').classList.add('hidden');
            document.getElementById('product-modal-backdrop').classList.add('hidden');
        }

        function adjustModalQty(delta) {
            const input = document.getElementById('modal-quantity');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            input.value = val;
            recalculateModalPrice();
        }

        function recalculateModalPrice() {
            if (!currentModalProduct) return;
            let unit = Number(currentModalProduct.price);

            const checkedInputs = document.querySelectorAll('#modal-options-container input:checked');
            checkedInputs.forEach(inp => {
                unit += Number(inp.getAttribute('data-price') || 0);
            });

            const qty = parseInt(document.getElementById('modal-quantity').value) || 1;
            const total = unit * qty;

            document.getElementById('modal-total-btn-price').innerText = formatRupiah(total);
        }

        async function submitAddToCart() {
            if (!currentModalProduct) return;

            const selectedOptions = [];
            document.querySelectorAll('#modal-options-container input:checked').forEach(inp => {
                selectedOptions.push(inp.value);
            });

            const qty = parseInt(document.getElementById('modal-quantity').value) || 1;
            const notes = document.getElementById('modal-notes').value;

            try {
                const res = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({
                        product_id: currentModalProduct.id,
                        quantity: qty,
                        options: selectedOptions,
                        notes: notes
                    })
                });

                const data = await res.json();
                if (data.success) {
                    closeProductModal();
                    renderCart(data.cart);
                    animateCartBadge();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    const delay = window.scrollY < 5 ? 0 : 400;
                    setTimeout(() => openCartDrawer(), delay);
                    showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang.');
                }
            } catch (e) {
                console.error(e);
            }
        }

        async function quickAddToCart(productId) {
            try {
                const res = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({ product_id: productId, quantity: 1 })
                });
                const data = await res.json();
                if (data.success) {
                    renderCart(data.cart);
                    animateCartBadge();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    const delay = window.scrollY < 5 ? 0 : 400;
                    setTimeout(() => openCartDrawer(), delay);
                    showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
                } else {
                    alert(data.message || 'Gagal menambahkan ke keranjang.');
                }
            } catch (e) {
                console.error(e);
            }
        }

        function animateCartBadge() {
            const badge = document.getElementById('cart-badge');
            const cartBtn = document.getElementById('cart-btn');
            if (badge) {
                badge.classList.remove('scale-125');
                badge.classList.add('scale-125');
                setTimeout(() => {
                    badge.classList.remove('scale-125');
                }, 300);
            }
            if (cartBtn) {
                cartBtn.classList.add('scale-105');
                setTimeout(() => {
                    cartBtn.classList.remove('scale-105');
                }, 200);
            }
        }

        function showCartToast(message) {
            let toast = document.getElementById('cart-toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'cart-toast-notification';
                toast.className = 'fixed bottom-6 right-6 z-50 bg-gray-900 text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-3 transition-all duration-300 transform translate-y-20 opacity-0 pointer-events-auto border border-gray-800';
                toast.innerHTML = `
                    <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0 font-black text-xs shadow-xs">
                        ✓
                    </div>
                    <div class="text-xs font-semibold" id="cart-toast-text"></div>
                    <button onclick="toggleCartDrawer()" class="ml-2 bg-bites-yellow hover:bg-bites-yellow-dark text-gray-900 text-[11px] font-black px-2.5 py-1 rounded-xl transition">
                        Buka
                    </button>
                `;
                document.body.appendChild(toast);
            }

            const textElem = document.getElementById('cart-toast-text');
            if (textElem) textElem.innerText = message;
            toast.classList.remove('translate-y-20', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            if (window._cartToastTimeout) clearTimeout(window._cartToastTimeout);
            window._cartToastTimeout = setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        function toggleMobileNav() {
            const menu = document.getElementById('mobile-nav-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        }

        document.addEventListener('click', (event) => {
            const menu = document.getElementById('mobile-nav-menu');
            const toggle = document.getElementById('mobile-nav-toggle');
            if (!menu || !toggle || menu.classList.contains('hidden')) return;

            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        function toggleUserDropdown(event) {
            if (event) event.stopPropagation();
            const menu = document.getElementById('user-dropdown-menu');
            const arrow = document.getElementById('user-menu-arrow');
            if (!menu) return;

            const isHidden = menu.classList.contains('hidden');
            if (isHidden) {
                menu.classList.remove('hidden');
                if (arrow) arrow.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        }

        // Close user dropdown when clicking outside
        document.addEventListener('click', (event) => {
            const container = document.getElementById('user-dropdown-container');
            const menu = document.getElementById('user-dropdown-menu');
            const arrow = document.getElementById('user-menu-arrow');
            if (container && menu && !container.contains(event.target)) {
                menu.classList.add('hidden');
                if (arrow) arrow.classList.remove('rotate-180');
            }
        });

        function confirmLogout(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            const userMenu = document.getElementById('user-dropdown-menu');
            const userArrow = document.getElementById('user-menu-arrow');
            if (userMenu) userMenu.classList.add('hidden');
            if (userArrow) userArrow.classList.remove('rotate-180');
            const mobileMenu = document.getElementById('mobile-nav-menu');
            if (mobileMenu) mobileMenu.classList.add('hidden');

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
            const btn = document.getElementById('modal-logout-submit-btn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `
                    <svg class="w-4 h-4 animate-spin mr-1.5" fill="none" viewBox="0 0 24 24">
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

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLogoutModal();
                const userMenu = document.getElementById('user-dropdown-menu');
                const userArrow = document.getElementById('user-menu-arrow');
                if (userMenu) userMenu.classList.add('hidden');
                if (userArrow) userArrow.classList.remove('rotate-180');
                const homeSearchDropdown = document.getElementById('home-search-dropdown');
                if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
            }
        });

        // Live search handler
        let homeSearchDebounce = null;
        const homeSearchInput = document.getElementById('home-navbar-search');
        const homeSearchClear = document.getElementById('home-search-clear');
        const homeSearchDropdown = document.getElementById('home-search-dropdown');
        const homeSearchLoading = document.getElementById('home-search-loading');
        const homeSearchContent = document.getElementById('home-search-content');

        function clearHomeNavbarSearch() {
            if (homeSearchInput) {
                homeSearchInput.value = '';
                homeSearchInput.focus();
            }
            if (homeSearchClear) homeSearchClear.classList.add('hidden');
            if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
            if (homeSearchContent) homeSearchContent.innerHTML = '';
        }

        if (homeSearchInput) {
            homeSearchInput.addEventListener('input', function() {
                const q = this.value.trim();
                clearTimeout(homeSearchDebounce);

                if (q.length > 0) {
                    if (homeSearchClear) homeSearchClear.classList.remove('hidden');
                } else {
                    if (homeSearchClear) homeSearchClear.classList.add('hidden');
                }

                if (q.length < 1) {
                    if (homeSearchDropdown) homeSearchDropdown.classList.add('hidden');
                    if (homeSearchContent) homeSearchContent.innerHTML = '';
                    return;
                }

                if (homeSearchDropdown) homeSearchDropdown.classList.remove('hidden');
                if (homeSearchLoading) homeSearchLoading.classList.remove('hidden');
                if (homeSearchContent) homeSearchContent.innerHTML = '';

                homeSearchDebounce = setTimeout(() => {
                    fetch(`{{ route('menu.search.live') }}?q=${encodeURIComponent(q)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (homeSearchLoading) homeSearchLoading.classList.add('hidden');
                        renderHomeSearchResults(data, q);
                    })
                    .catch(err => {
                        if (homeSearchLoading) homeSearchLoading.classList.add('hidden');
                        if (homeSearchContent) {
                            homeSearchContent.innerHTML = `<div class="text-xs text-gray-500 py-3 text-center">Gagal memuat hasil menu.</div>`;
                        }
                    });
                }, 200);
            });

            homeSearchInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0 && homeSearchDropdown) {
                    homeSearchDropdown.classList.remove('hidden');
                }
            });
        }

        function escapeHomeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
        }

        function renderHomeSearchResults(data, query) {
            if (!homeSearchContent) return;

            if (!data.products || data.products.length === 0) {
                homeSearchContent.innerHTML = `
                    <div class="text-center py-5 text-gray-400">
                        <svg class="w-6 h-6 mx-auto text-gray-300 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-gray-600">Tidak ada menu untuk "<span class="text-gray-900">${escapeHomeHtml(query)}</span>"</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">Coba cari Cheese Burger, Beef, atau Chicken.</p>
                    </div>
                `;
                return;
            }

            let html = `
                <div class="space-y-1">
                    <div class="flex items-center justify-between text-[11px] font-bold text-gray-400 uppercase tracking-wider px-2 py-1 border-b border-gray-100">
                        <span>Menu Terkait (${data.products.length})</span>
                        <a href="{{ route('menu') }}?q=${encodeURIComponent(query)}" class="text-[#3b6e64] hover:underline normal-case font-bold">Lihat Semua Menu &rarr;</a>
                    </div>
            `;

            data.products.forEach(p => {
                html += `
                    <a href="${p.url}" class="flex items-center justify-between p-2 rounded-xl hover:bg-gray-50 transition group">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <img src="${p.image}" alt="${escapeHomeHtml(p.name)}" class="w-9 h-9 rounded-lg object-cover shrink-0 bg-gray-100 border border-gray-100" onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}';">
                            <div class="min-w-0">
                                <div class="text-xs font-bold text-gray-800 group-hover:text-[#3b6e64] transition truncate">${escapeHomeHtml(p.name)}</div>
                                <div class="text-[11px] font-extrabold text-[#FFA000]">${p.price_formatted}</div>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-white bg-[#3b6e64] hover:bg-[#2d554d] px-2.5 py-1 rounded-lg transition shrink-0">
                            Pesan
                        </span>
                    </a>
                `;
            });

            html += `</div>`;
            homeSearchContent.innerHTML = html;
        }

        // Close search dropdown on click outside
        document.addEventListener('click', (event) => {
            const searchContainer = document.getElementById('home-navbar-search')?.closest('.relative');
            const searchDropdown = document.getElementById('home-search-dropdown');
            if (searchContainer && searchDropdown && !searchContainer.contains(event.target)) {
                searchDropdown.classList.add('hidden');
            }
        });

        // Smooth Page Transition Handler
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('page-loader-bar');
            if (loader) {
                loader.style.transform = 'scaleX(1)';
                setTimeout(() => { loader.style.opacity = '0'; }, 200);
            }

            document.addEventListener('click', (e) => {
                const link = e.target.closest('a');
                if (!link || !link.hasAttribute('data-page-transition')) return;

                const href = link.getAttribute('href');
                const target = link.getAttribute('target');

                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.startsWith('mailto:') || href.startsWith('tel:') || target === '_blank' || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey) {
                    return;
                }

                if (link.hostname === window.location.hostname) {
                    if (loader) {
                        loader.style.opacity = '1';
                        loader.style.transform = 'scaleX(0.7)';
                    }
                    document.body.classList.add('page-exiting');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.remove('page-exiting');
        });

        window.addEventListener('pageshow', () => {
            document.body.classList.remove('page-exiting');
            const loader = document.getElementById('page-loader-bar');
            if (loader) {
                loader.style.transform = 'scaleX(1)';
                setTimeout(() => { loader.style.opacity = '0'; loader.style.transform = 'scaleX(0)'; }, 200);
            }
        });
    </script>
</body>
</html>

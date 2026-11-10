<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @if(request()->routeIs('welcome', 'home', 'menu*'))
    <link rel="preload" as="image" href="{{ asset('images/hero-burger.png') }}" fetchpriority="high">
    @endif
    <title>@yield('title', 'Toon Burger - Smash Burger & Takeaway Hub')</title>

    <!-- Google Fonts: BBH Hegarty + Bebas Neue + Poppins + Nunito + Luckiest Guy -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Hegarty&family=Bebas+Neue&family=Luckiest+Guy&family=Poppins:wght@300;400;500;600;700;800;900&family=Nunito:wght@900&display=swap" rel="stylesheet">

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
                        luckiest: ['"BBH Hegarty"', '"Luckiest Guy"', 'cursive', 'sans-serif'],
                        brand: ['"BBH Hegarty"', 'sans-serif'],
                        hegarty: ['"BBH Hegarty"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; overflow-x: clip; }
        .font-brand {
            font-family: 'BBH Hegarty', cursive, sans-serif;
            letter-spacing: 0.03em;
        }
        .retro-grid-bg {
            background-color: #FAF5E8;
            background-image: 
                linear-gradient(to right, rgba(59, 92, 86, 0.07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59, 92, 86, 0.07) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        @keyframes marquee {
            0% { transform: translate3d(0%, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 25s linear infinite;
            will-change: transform;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: clip;
            max-width: 100vw;
            caret-color: #D92625;
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

        /* ═══════════════════════════════════════════════
           TOON BURGER INTERACTIVE MICRO-ANIMATIONS
           ═══════════════════════════════════════════════ */
        /* 1. Cartoon Floating Bob for Hero Burger */
        @keyframes toonBobAnimation {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-10px) rotate(-1.5deg);
            }
        }
        .toon-bob {
            animation: toonBobAnimation 4s ease-in-out infinite;
        }

        /* 2. Comic Sparkle Accent (Static lightweight layer, no infinite GPU repaint) */
        .comic-sparkle {
            opacity: 0.92;
        }

        /* 3. Comic Badge Interactive */
        .comic-badge-interactive {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .comic-badge-interactive:hover {
            transform: scale(1.08) rotate(3deg);
        }

        /* 4. Squash & Stretch Button Micro-interaction */
        .toon-btn-bounce {
            transition: transform 0.16s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.16s ease, filter 0.16s ease;
        }
        .toon-btn-bounce:hover {
            transform: translateY(-2px);
        }
        .toon-btn-bounce:active {
            transform: scale(0.92) translateY(2px) !important;
        }

        /* 5. 3D Card Hover Tilt */
        .toon-tilt-card {
            transform-style: preserve-3d;
            transition: transform 0.25s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.25s ease;
        }

        /* 6. Cartoon Cart Punch Jiggle */
        @keyframes cartPunch {
            0% { transform: scale(1) rotate(0deg); }
            20% { transform: scale(1.32) rotate(-12deg); }
            45% { transform: scale(0.92) rotate(8deg); }
            70% { transform: scale(1.15) rotate(-4deg); }
            100% { transform: scale(1) rotate(0deg); }
        }
        .animate-cart-punch {
            animation: cartPunch 0.45s cubic-bezier(0.34, 1.56, 0.64, 1) forwards !important;
        }

        /* 7. Flying Cart Particle */
        .flying-cart-particle {
            position: fixed;
            z-index: 999999;
            pointer-events: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: contain;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.3));
            transition: transform 0.65s cubic-bezier(0.2, 0.8, 0.25, 1), opacity 0.65s ease;
            will-change: transform, opacity;
        }

        /* 8. Scroll Reveal */
        .toon-reveal {
            opacity: 0;
            transform: translateY(16px);
            transition: opacity 0.45s cubic-bezier(0.25, 1, 0.5, 1), transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .toon-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Accessibility: Respect Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            .toon-bob, .comic-sparkle, .animate-cart-punch, .animate-marquee {
                animation: none !important;
            }
            .toon-tilt-card, .toon-btn-bounce, .toon-reveal {
                transform: none !important;
                transition: none !important;
                opacity: 1 !important;
            }
        }
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
    <header class="sticky top-0 z-50 px-2 sm:px-6 lg:px-8 pt-2.5 sm:pt-4 pb-2 select-none">
        <div class="w-full max-w-[1440px] xl:max-w-[1520px] mx-auto relative">
            <div class="flex items-center justify-between px-3.5 sm:px-7 lg:px-8 py-2 sm:py-3 rounded-full border border-white/25 transition-all duration-300 relative shadow-[0_10px_30px_-5px_rgba(0,0,0,0.25)] backdrop-blur-xs"
                 style="background-color: rgba(45, 72, 67, 0.65); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);">

                <!-- Brand logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 sm:gap-2.5 group shrink-0 min-w-0">
                    <img src="{{ asset('images/toon-head.png') }}" alt="Toon Burger Logo"
                         class="h-9 sm:h-12 md:h-14 w-auto object-contain transition group-hover:scale-105 drop-shadow-xs shrink-0">
                    <span class="font-normal text-white text-lg sm:text-2xl uppercase tracking-wider shrink-0 leading-none pt-0.5"
                          style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.06em;">
                        TOON BURGER
                    </span>
                </a>

                <!-- Nav links -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm">
                    <a href="{{ route('home') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-bold
                              {{ request()->routeIs('home', 'welcome') || request()->is('/') ? 'bg-white/20 text-white shadow-2xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
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
                                <div class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition shrink-0 overflow-hidden">
                                    @if(!empty(Auth::user()->avatar))
                                        <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                                             alt="Avatar"
                                             class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr(Auth::user()->name ?? 'Tb', 0, 2)) }}
                                    @endif
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
                                    <div class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shrink-0 overflow-hidden">
                                        @if(!empty(Auth::user()->avatar))
                                            <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                                                 alt="Avatar"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr(Auth::user()->name ?? 'Tb', 0, 2)) }}
                                        @endif
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
                        <div class="hidden sm:flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-bold shrink-0 select-none">
                            <a href="{{ route('login') }}" class="text-white hover:text-white/80 transition px-2 py-1 font-semibold">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-[#F5A623] hover:bg-[#E0961F] active:scale-95 text-slate-900 font-bold px-4 py-1.5 rounded-xl transition shadow-xs">
                                Sign In
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Hamburger Menu Button -->
                    <button type="button"
                            onclick="toggleMobileNav()"
                            id="mobile-nav-toggle"
                            class="lg:hidden p-2 text-white/80 hover:text-white hover:bg-white/10 rounded-full transition focus:outline-none shrink-0"
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
                                        {{ request()->routeIs('home', 'welcome') || request()->is('/') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
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
                    @else
                        <div class="pt-2.5 mt-2 border-t border-gray-100 flex items-center gap-2">
                            <a href="{{ route('login') }}" onclick="toggleMobileNav()"
                               class="flex-1 text-center py-2.5 rounded-xl border border-gray-300 text-gray-800 hover:bg-gray-50 text-xs font-bold transition">
                                Login
                            </a>
                            <a href="{{ route('register') }}" onclick="toggleMobileNav()"
                               class="flex-1 text-center py-2.5 rounded-xl bg-[#F5A623] hover:bg-[#E0961F] text-slate-900 text-xs font-bold transition shadow-xs">
                                Sign In
                            </a>
                        </div>
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

    <!-- MAIN CONTENT (Safe bottom padding for mobile dock) -->
    <main class="flex-1 pb-16 md:pb-0">
        @yield('content')
    </main>

    <!-- FOOTER (PERSIS FOTO media_1790644528320.png) -->
    @include('partials.footer')

    <!-- ═══════════════════════════════════════════════
         FLUTTER-STYLE MOBILE BOTTOM NAVIGATION DOCK
         (Sticky, Touch-Friendly 44px+ hit targets, Safe Area)
         ═══════════════════════════════════════════════ -->
    <nav aria-label="Mobile Navigation"
         class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-black/10 px-3 py-1.5 shadow-[0_-4px_24px_rgba(0,0,0,0.08)] flex items-center justify-around select-none">
        <!-- 1. Beranda -->
        <a href="{{ route('home') }}"
           class="flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-1 px-2 rounded-2xl transition active:scale-95 {{ request()->routeIs('home', 'welcome') || request()->is('/') ? 'text-[#27443E] font-black' : 'text-gray-500 font-medium hover:text-gray-900' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('home', 'welcome') || request()->is('/') ? 'stroke-[2.5]' : 'stroke-[1.8]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="text-[10px] mt-0.5 tracking-tight">Beranda</span>
            @if(request()->routeIs('home', 'welcome') || request()->is('/'))
                <span class="w-1.5 h-1.5 bg-[#27443E] rounded-full mt-0.5"></span>
            @endif
        </a>

        <!-- 2. Menu -->
        <a href="{{ route('menu') }}"
           class="flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-1 px-2 rounded-2xl transition active:scale-95 {{ request()->routeIs('menu*') ? 'text-[#27443E] font-black' : 'text-gray-500 font-medium hover:text-gray-900' }}">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 4c-4.97 0-9 2.69-9 6h18c0-3.31-4.03-6-9-6zm-9 8v2h18v-2H3zm0 4c0 2.21 1.79 4 4 4h10c2.21 0 4-1.79 4-4H3z"/>
            </svg>
            <span class="text-[10px] mt-0.5 tracking-tight">Menu</span>
            @if(request()->routeIs('menu*'))
                <span class="w-1.5 h-1.5 bg-[#27443E] rounded-full mt-0.5"></span>
            @endif
        </a>

        <!-- 3. Keranjang (Pusat / Floating Action) -->
        <button type="button"
                id="mobile-dock-cart-btn"
                onclick="toggleCartDrawer()"
                class="relative flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-0.5 px-2 rounded-2xl text-gray-700 transition active:scale-95 cursor-pointer">
            <div class="relative w-9 h-9 rounded-full bg-[#27443E] text-white flex items-center justify-center shadow-[0_2px_8px_rgba(39,68,62,0.35)]">
                <svg class="w-4.5 h-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 0 1-8 0"/>
                </svg>
                <span id="mobile-dock-cart-badge"
                      class="absolute -top-1 -right-1 min-w-[17px] h-[17px] px-1 rounded-full bg-[#DE3B28] text-white text-[10px] font-extrabold flex items-center justify-center border border-white leading-none shadow-xs">
                    {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                </span>
            </div>
            <span class="text-[10px] mt-0.5 text-[#27443E] font-bold tracking-tight">Pesanan</span>
        </button>

        <!-- 4. Kontak -->
        <a href="{{ route('contact') }}"
           class="flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-1 px-2 rounded-2xl transition active:scale-95 {{ request()->routeIs('contact') ? 'text-[#27443E] font-black' : 'text-gray-500 font-medium hover:text-gray-900' }}">
            <svg class="w-5 h-5 {{ request()->routeIs('contact') ? 'stroke-[2.5]' : 'stroke-[1.8]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="text-[10px] mt-0.5 tracking-tight">Kontak</span>
            @if(request()->routeIs('contact'))
                <span class="w-1.5 h-1.5 bg-[#27443E] rounded-full mt-0.5"></span>
            @endif
        </a>

        <!-- 5. Akun / Login -->
        @auth
            <a href="{{ route('orders.index') }}"
               class="flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-1 px-2 rounded-2xl transition active:scale-95 {{ request()->routeIs('orders*') ? 'text-[#27443E] font-black' : 'text-gray-500 font-medium hover:text-gray-900' }}">
                <div class="w-6 h-6 rounded-full bg-[#FFA000] text-white flex items-center justify-center text-[10px] font-black">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="text-[10px] mt-0.5 tracking-tight truncate max-w-[48px]">Akun</span>
            </a>
        @else
            <a href="{{ route('login') }}"
               class="flex flex-col items-center justify-center min-w-[56px] min-h-[44px] py-1 px-2 rounded-2xl transition active:scale-95 {{ request()->routeIs('login') ? 'text-[#27443E] font-black' : 'text-gray-500 font-medium hover:text-gray-900' }}">
                <svg class="w-5 h-5 stroke-[1.8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span class="text-[10px] mt-0.5 tracking-tight">Masuk</span>
            </a>
        @endauth
    </nav>

    <!-- CART FLOATING CARD -->
    @php
        $initialCartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
    @endphp
    <div id="cart-backdrop" onclick="toggleCartDrawer()" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity duration-300"></div>
    <div id="cart-drawer" class="fixed top-16 sm:top-20 inset-x-3 sm:inset-x-auto sm:right-4 w-auto sm:w-[92vw] max-w-[385px] bg-white rounded-[20px] shadow-2xl border border-gray-200/80 z-50 flex flex-col max-h-[calc(100vh-5.5rem)] overflow-hidden pointer-events-none opacity-0 invisible" style="transform: scale(0.95) translateY(-8px); transition: transform 0.25s cubic-bezier(0.16,1,0.3,1), opacity 0.2s ease;">

        <!-- Cart Header (Fixed Top) -->
        <div class="px-6 py-5 bg-white border-b border-[#E5E7EB] flex-shrink-0">
            <h3 class="font-semibold text-[#2E3137] text-[18px] leading-snug">Keranjang Pesanan</h3>
            <p class="text-[13px] text-[#737373] mt-1 font-normal" id="cart-items-count-text">{{ $initialCartCount }} Menu Dipilih</p>
        </div>

        <!-- Scrollable Burger Orders Container (Only this section scrolls!) -->
        <div id="cart-items-container" class="overflow-y-auto px-5 pt-4 pb-2 space-y-3.5 {{ $initialCartCount > 0 ? 'max-h-[348px]' : '' }}">
            <div class="py-7 px-4 flex flex-col items-center text-center">
                <img src="{{ asset('images/empty-cart.png') }}"
                     alt="Keranjang Kosong"
                     class="w-[175px] h-auto object-contain mx-auto mb-6 select-none pointer-events-none">
                <h4 class="font-semibold text-[#52565E] text-[18px] leading-snug tracking-tight">
                    Keranjangmu masih kosong nih
                </h4>
                <p class="text-[13px] text-[#737373] leading-[1.5] mt-1.5 mx-auto font-normal">
                    <span class="block sm:whitespace-nowrap">Yuk, pilih burger favoritmu dan mulai ngisi</span>
                    <span class="block">perut kosongmu hari ini</span>
                </p>
                <button type="button"
                        onclick="startOrderFromCart()"
                        class="mt-6 bg-[#3E5B56] hover:bg-[#324B47] active:scale-95 text-white font-semibold text-[13.5px] px-8 py-3 rounded-[10px] transition cursor-pointer inline-flex items-center justify-center min-h-[44px] shadow-2xs">
                    Mulai Pesan Sekarang
                </button>
            </div>
        </div>

        <!-- Fixed Bottom Footer (Subtotal Menu + Checkout Button stay fixed and never scroll) -->
        <div id="cart-fixed-footer" class="{{ $initialCartCount > 0 ? '' : 'hidden' }} flex-shrink-0 px-5 pt-2 pb-5 bg-white space-y-4">
            <!-- Hidden Coupon Elements Preserved for JS Compatibility -->
            <div id="cart-coupon-section" class="hidden">
                <input type="text" id="coupon-input">
                <div id="applied-coupon-badge" class="hidden"><span id="coupon-text"></span></div>
            </div>

            <!-- Price Breakdown (Fixed) -->
            <div id="cart-summary-section" class="bg-[#F4F5F7] rounded-[14px] px-4 py-3.5 space-y-2 text-[12px] text-[#6A6F77]">
                <div class="flex items-center justify-between">
                    <span>Subtotal Menu:</span>
                    <span id="cart-subtotal" class="font-medium text-[#52565E]">Rp 0</span>
                </div>
                <div id="cart-discount-row" class="hidden items-center justify-between text-[#13653F]">
                    <span>Diskon Promo:</span>
                    <span id="cart-discount" class="font-medium">- Rp 0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Pajak PPN (11%)</span>
                    <span id="cart-tax" class="font-medium text-[#52565E]">Rp 0</span>
                </div>
                <div class="flex items-center justify-between text-[12.5px] font-semibold text-[#2E3137] pt-2.5 mt-1 border-t border-[#E5E7EB]">
                    <span>Total Tagihan:</span>
                    <span id="cart-total" class="font-semibold text-[#2E3137]">Rp 0</span>
                </div>
            </div>

            <!-- Checkout Action Button (Fixed) -->
            <div id="cart-action-section">
                <a href="{{ route('orders.checkout') }}"
                   id="checkout-btn"
                   class="w-full bg-[#3E5B56] hover:bg-[#324B47] active:scale-98 text-white font-semibold py-3.5 px-4 rounded-[10px] flex items-center justify-center transition text-[13.5px] shadow-2xs min-h-[44px]">
                    Lanjutkan Ke pembayaran
                </a>
            </div>
        </div>
    </div>

    <!-- PRODUCT DETAIL & CUSTOMIZATION MODAL (Matching Figma Mockup) -->
    <div id="product-modal-backdrop" onclick="closeProductModal()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 hidden transition-opacity duration-300"></div>
    <div id="product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 hidden" onclick="closeProductModal()">
        <div class="bg-white rounded-[28px] sm:rounded-[34px] max-w-[760px] w-full max-h-[92vh] overflow-y-auto relative p-5 sm:p-7 md:p-8 shadow-2xl border border-gray-150 animate-modal-pop" onclick="event.stopPropagation()">

            <!-- Close Button (Top Right) -->
            <button type="button"
                    onclick="closeProductModal()"
                    class="absolute top-4 right-4 sm:top-5 sm:right-5 w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition text-2xl font-light cursor-pointer z-20"
                    aria-label="Tutup">
                &times;
            </button>

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-7 items-stretch">
                <!-- Left Column: Product Image on Colored Card Background -->
                <div id="modal-product-card-bg"
                     class="w-full aspect-[1.1] sm:aspect-auto sm:h-full min-h-[220px] sm:min-h-[300px] md:min-h-[320px] rounded-[22px] overflow-hidden flex items-center justify-center p-5 sm:p-6 relative transition-colors duration-300"
                     style="background-color: #FFC83B;">
                    <img id="modal-product-image"
                         src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
                         alt="Product"
                         class="w-full max-w-[210px] sm:max-w-[250px] h-auto object-contain drop-shadow-[0_14px_22px_rgba(0,0,0,0.18)] select-none">
                </div>

                <!-- Right Column: Details, Notes, and Action Button -->
                <div class="flex flex-col justify-between pt-1 sm:pt-0">
                    <div>
                        <!-- Category Badge -->
                        <span id="modal-product-badge" class="text-xs font-bold text-gray-400 uppercase tracking-wider block">
                            BURGER
                        </span>

                        <!-- Product Name -->
                        <h3 id="modal-product-name" class="font-black text-xl sm:text-2xl text-[#2D3B36] uppercase leading-tight mt-1">
                            Burger Name
                        </h3>

                        <!-- Price -->
                        <div id="modal-product-price" class="font-extrabold text-base sm:text-lg text-[#2D3B36] mt-1.5 tracking-tight">
                            RP 0
                        </div>

                        <!-- Appetizing Description -->
                        <p id="modal-product-desc" class="text-xs sm:text-[13px] text-gray-500 leading-relaxed mt-2.5 sm:mt-3">
                            Deskripsi menu lezat dari Toon Burger.
                        </p>

                        <input type="hidden" id="modal-product-id" value="">

                        <!-- Optional Product Options Container (if any) -->
                        <div id="modal-options-container" class="space-y-2 mt-3 hidden">
                            <!-- Filled dynamically if product has options -->
                        </div>

                        <!-- Order Notes Field -->
                        <div class="mt-4">
                            <label for="modal-notes" class="block text-xs font-bold text-[#2D3B36] mb-1.5">
                                Catatan Pesanan
                            </label>
                            <textarea id="modal-notes"
                                      rows="2"
                                      placeholder="Contoh: saus dipisah, tanpa selada..."
                                      class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-[13px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#385850] focus:ring-1 focus:ring-[#385850] resize-none transition leading-relaxed"></textarea>
                        </div>
                    </div>

                    <!-- Bottom Action Row: Stepper [-] 1 [+] and Compact Add to Cart Button -->
                    <div class="flex items-center gap-2.5 sm:gap-3 mt-4 sm:mt-5 pt-1">
                        <!-- Stepper [-] 1 [+] (Tombol Kurang & Tambah Burger) -->
                        <div class="inline-flex items-center border border-gray-200 rounded-xl bg-white px-2 py-1 shadow-2xs gap-2 shrink-0">
                            <button type="button"
                                    onclick="adjustModalQty(-1)"
                                    class="w-5 h-5 flex items-center justify-center text-gray-500 hover:text-gray-900 text-xs font-bold transition cursor-pointer select-none"
                                    aria-label="Kurang burger">&minus;</button>
                            <span id="modal-quantity" class="w-4 text-center font-bold text-xs text-gray-900 select-none">1</span>
                            <button type="button"
                                    onclick="adjustModalQty(1)"
                                    class="w-5 h-5 flex items-center justify-center text-gray-500 hover:text-gray-900 text-xs font-bold transition cursor-pointer select-none"
                                    aria-label="Tambah burger">&plus;</button>
                        </div>

                        <!-- CTA Button (Dikecilkan, Ringkas & Proporsional) -->
                        <button type="button"
                                id="modal-submit-btn"
                                onclick="submitAddToCart()"
                                class="bg-[#385850] hover:bg-[#2C463F] active:scale-[0.98] text-white font-bold text-xs py-2 px-3.5 sm:px-4 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-xs cursor-pointer transition whitespace-nowrap">
                            <span>Tambahkan ke keranjang</span>
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                                <path d="M3 6h18"/>
                                <path d="M16 10a4 4 0 0 1-8 0"/>
                            </svg>
                        </button>
                    </div>
                </div>
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

        function startOrderFromCart() {
            closeCartDrawer();
            const menuUrl = '{{ route("menu") }}';
            if (window.location.pathname === '/menu') {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else if (typeof window.tbAppNavigate === 'function') {
                window.tbAppNavigate(menuUrl, true);
            } else {
                window.location.href = menuUrl;
            }
        }

        function renderCart(cart) {
            const container = document.getElementById('cart-items-container');
            const badge = document.getElementById('cart-badge');
            const mobileDockBadge = document.getElementById('mobile-dock-cart-badge');
            const countText = document.getElementById('cart-items-count-text');
            const checkoutTotal = document.getElementById('checkout-btn-total');
            const fixedFooter = document.getElementById('cart-fixed-footer');
            const summarySection = document.getElementById('cart-summary-section');
            const actionSection = document.getElementById('cart-action-section');
            const discountRow = document.getElementById('cart-discount-row');

            if (badge) badge.innerText = cart.item_count || 0;
            if (mobileDockBadge) mobileDockBadge.innerText = cart.item_count || 0;
            countText.innerText = `${cart.item_count || 0} Menu Dipilih`;

            document.getElementById('cart-subtotal').innerText = formatRupiah(cart.subtotal);
            document.getElementById('cart-discount').innerText = '- ' + formatRupiah(cart.discount);
            document.getElementById('cart-tax').innerText = formatRupiah(cart.tax);
            document.getElementById('cart-total').innerText = formatRupiah(cart.total);
            if (checkoutTotal) {
                checkoutTotal.innerText = formatRupiah(cart.total);
            }

            if (discountRow) {
                if (cart.discount && Number(cart.discount) > 0) {
                    discountRow.classList.remove('hidden');
                    discountRow.classList.add('flex');
                } else {
                    discountRow.classList.add('hidden');
                    discountRow.classList.remove('flex');
                }
            }

            const couponBadge = document.getElementById('applied-coupon-badge');
            const couponText = document.getElementById('coupon-text');
            if (couponBadge && couponText) {
                if (cart.coupon) {
                    couponBadge.classList.remove('hidden');
                    couponText.innerText = `Promo ${cart.coupon.code} aktif (-${formatRupiah(cart.discount)})`;
                } else {
                    couponBadge.classList.add('hidden');
                }
            }

            if (!cart.items || cart.items.length === 0) {
                container.classList.remove('max-h-[348px]');
                container.innerHTML = `
                    <div class="py-7 px-4 flex flex-col items-center text-center">
                        <img src="{{ asset('images/empty-cart.png') }}"
                             alt="Keranjang Kosong"
                             class="w-[175px] h-auto object-contain mx-auto mb-6 select-none pointer-events-none">
                        <h4 class="font-semibold text-[#52565E] text-[18px] leading-snug tracking-tight">
                            Keranjangmu masih kosong nih
                        </h4>
                        <p class="text-[13px] text-[#737373] leading-[1.5] mt-1.5 mx-auto font-normal">
                            <span class="block sm:whitespace-nowrap">Yuk, pilih burger favoritmu dan mulai ngisi</span>
                            <span class="block">perut kosongmu hari ini</span>
                        </p>
                        <button type="button"
                                onclick="startOrderFromCart()"
                                class="mt-6 bg-[#3E5B56] hover:bg-[#324B47] active:scale-95 text-white font-semibold text-[13.5px] px-8 py-3 rounded-[10px] transition cursor-pointer inline-flex items-center justify-center min-h-[44px] shadow-2xs">
                            Mulai Pesan Sekarang
                        </button>
                    </div>`;
                if (fixedFooter) fixedFooter.classList.add('hidden');
                if (summarySection) summarySection.classList.add('hidden');
                if (actionSection) actionSection.classList.add('hidden');
                return;
            }

            container.classList.add('max-h-[348px]');
            if (fixedFooter) fixedFooter.classList.remove('hidden');
            if (summarySection) summarySection.classList.remove('hidden');
            if (actionSection) actionSection.classList.remove('hidden');

            container.innerHTML = cart.items.map(item => `
                <div class="bg-[#F4F5F7] rounded-[14px] p-3.5 flex gap-3.5 items-center">
                    <img src="${item.image ? '/' + item.image : '/images/burger-bg.jpg'}"
                         alt="${item.name}"
                         class="w-[74px] h-[74px] object-cover rounded-[10px] flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-[14.5px] text-[#33373D] truncate leading-snug">${item.name}</h4>
                        <div class="text-[13.5px] text-[#6A6F77] font-normal mt-0.5">${formatRupiah(item.unit_price)}</div>

                        <div class="flex items-center justify-between mt-2.5 pt-2.5 border-t border-[#E5E7EB]">
                            <div class="inline-flex items-center bg-white border border-[#E5E7EB] rounded-[6px] px-1 py-0.5 shadow-2xs">
                                <button type="button"
                                        onclick="updateCartQty('${item.cart_key}', ${item.quantity - 1})"
                                        class="w-5 h-5 flex items-center justify-center text-[#6A6F77] hover:text-[#2E3137] text-xs font-medium cursor-pointer transition"
                                        aria-label="Kurangi jumlah">-</button>
                                <span class="px-2 text-[11.5px] font-medium text-[#2E3137] select-none">${item.quantity}</span>
                                <button type="button"
                                        onclick="updateCartQty('${item.cart_key}', ${item.quantity + 1})"
                                        class="w-5 h-5 flex items-center justify-center text-[#6A6F77] hover:text-[#2E3137] text-xs font-medium cursor-pointer transition"
                                        aria-label="Tambah jumlah">+</button>
                            </div>
                            <span class="font-semibold text-[14.5px] text-[#2E3137]">${formatRupiah(item.total_price)}</span>
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
                document.getElementById('modal-product-name').innerText = (currentModalProduct.name || '').toUpperCase();
                document.getElementById('modal-product-badge').innerText = (currentModalProduct.badge || 'BURGER').toUpperCase();
                document.getElementById('modal-product-desc').innerText = currentModalProduct.description || 'Pilihan terbaik dari Toon Burger.';
                document.getElementById('modal-product-price').innerText = (currentModalProduct.formatted_price || formatRupiah(currentModalProduct.price)).toUpperCase();
                document.getElementById('modal-product-image').src = currentModalProduct.image ? '/' + currentModalProduct.image : '/images/burger-bg.jpg';

                const cardBg = document.getElementById('modal-product-card-bg');
                if (cardBg) {
                    cardBg.style.backgroundColor = currentModalProduct.bg || '#FFC83B';
                }

                const qtyEl = document.getElementById('modal-quantity');
                if (qtyEl) {
                    if ('value' in qtyEl) qtyEl.value = '1';
                    else qtyEl.innerText = '1';
                }

                const notesEl = document.getElementById('modal-notes');
                if (notesEl) notesEl.value = '';

                const optContainer = document.getElementById('modal-options-container');
                if (optContainer) {
                    if (currentModalProduct.options && currentModalProduct.options.length > 0) {
                        optContainer.classList.remove('hidden');
                        optContainer.innerHTML = currentModalProduct.options.map(opt => `
                            <div class="bg-gray-50 p-2.5 rounded-xl border border-gray-200/70">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-[11px] font-bold text-gray-800">${opt.name}</span>
                                    ${opt.is_required ? `<span class="text-[9px] bg-red-100 text-red-700 font-bold px-1.5 py-0.5 rounded">Wajib</span>` : `<span class="text-[9px] text-gray-400">Opsional</span>`}
                                </div>
                                <div class="space-y-1">
                                    ${opt.values.map(val => `
                                        <label class="flex items-center justify-between p-1.5 rounded-lg bg-white border border-gray-200 cursor-pointer hover:border-[#385850] transition text-xs">
                                            <div class="flex items-center gap-1.5">
                                                <input type="${opt.type === 'single' ? 'radio' : 'checkbox'}"
                                                       name="option_${opt.id}${opt.type === 'single' ? '' : '[]'}"
                                                       value="${val.id}"
                                                       data-price="${val.additional_price}"
                                                       ${val.is_default ? 'checked' : ''}
                                                       onchange="recalculateModalPrice()"
                                                       class="text-[#385850] focus:ring-[#385850]">
                                                <span class="text-[11px] font-medium text-gray-700">${val.name}</span>
                                            </div>
                                            <span class="font-bold text-gray-500 text-[10px]">
                                                ${Number(val.additional_price) > 0 ? '+ ' + formatRupiah(val.additional_price) : 'Gratis'}
                                            </span>
                                        </label>
                                    `).join('')}
                                </div>
                            </div>
                        `).join('');
                    } else {
                        optContainer.classList.add('hidden');
                        optContainer.innerHTML = '';
                    }
                }

                recalculateModalPrice();
                document.getElementById('product-modal').classList.remove('hidden');
                document.getElementById('product-modal-backdrop').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } catch (e) {
                console.error(e);
            }
        }

        function closeProductModal() {
            const modal = document.getElementById('product-modal');
            const backdrop = document.getElementById('product-modal-backdrop');
            if (modal) modal.classList.add('hidden');
            if (backdrop) backdrop.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function adjustModalQty(delta) {
            const qtyEl = document.getElementById('modal-quantity');
            if (!qtyEl) return;
            let val = parseInt(qtyEl.innerText || '1') + delta;
            if (val < 1) val = 1;
            qtyEl.innerText = val;
            recalculateModalPrice();
        }

        function recalculateModalPrice() {
            if (!currentModalProduct) return;
            let unit = Number(currentModalProduct.price);

            const checkedInputs = document.querySelectorAll('#modal-options-container input:checked');
            checkedInputs.forEach(inp => {
                unit += Number(inp.getAttribute('data-price') || 0);
            });

            const qtyEl = document.getElementById('modal-quantity');
            const qty = parseInt(qtyEl ? (qtyEl.innerText || qtyEl.value || '1') : '1') || 1;
            const total = unit * qty;

            const priceEl = document.getElementById('modal-product-price');
            if (priceEl) {
                priceEl.innerText = formatRupiah(total).toUpperCase();
            }
        }

        async function submitAddToCart() {
            if (!currentModalProduct) return;

            const selectedOptions = [];
            document.querySelectorAll('#modal-options-container input:checked').forEach(inp => {
                selectedOptions.push(inp.value);
            });

            const qtyEl = document.getElementById('modal-quantity');
            const qty = parseInt(qtyEl ? (qtyEl.value || qtyEl.innerText || '1') : '1') || 1;
            const notesEl = document.getElementById('modal-notes');
            const notes = notesEl ? notesEl.value : '';
            const submitBtn = document.getElementById('modal-submit-btn');

            try {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-75');
                }

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
                    const delay = window.scrollY < 5 ? 0 : 300;
                    setTimeout(() => openCartDrawer(), delay);
                    showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
                } else {
                    closeProductModal();
                    if (data.cart) renderCart(data.cart);
                    openCartDrawer();
                    showCartToast(data.message || 'Gagal menambahkan ke keranjang.');
                }
            } catch (e) {
                console.error(e);
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75');
                }
            }
        }

        // Close product modal with Escape key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeProductModal();
            }
        });

        // Fly to Cart Animation
        function flyToCart(originElement) {
            if (!originElement) return;
            const cartBtn = document.getElementById('cart-btn');
            if (!cartBtn) return;

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                animateCartBadge();
                return;
            }

            const startRect = originElement.getBoundingClientRect();
            const endRect = cartBtn.getBoundingClientRect();

            const flyer = document.createElement('img');
            flyer.src = '{{ asset("images/toon-head.png") }}';
            flyer.alt = 'Toon Mascot';
            flyer.className = 'flying-cart-particle';

            const startX = startRect.left + (startRect.width / 2) - 20;
            const startY = startRect.top + (startRect.height / 2) - 20;
            const targetX = endRect.left + (endRect.width / 2) - 20;
            const targetY = endRect.top + (endRect.height / 2) - 20;

            flyer.style.left = `${startX}px`;
            flyer.style.top = `${startY}px`;
            flyer.style.transform = 'scale(0.8) rotate(0deg)';
            flyer.style.opacity = '1';

            document.body.appendChild(flyer);

            // Force reflow
            void flyer.offsetWidth;

            const deltaX = targetX - startX;
            const deltaY = targetY - startY;

            flyer.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(0.35) rotate(360deg)`;
            flyer.style.opacity = '0.6';

            setTimeout(() => {
                flyer.remove();
                animateCartBadge();
            }, 620);
        }

        async function quickAddToCart(productId) {
            try {
                const clickedEl = (window.event && window.event.target) ? window.event.target.closest('button, .group, div') : null;
                if (clickedEl) {
                    flyToCart(clickedEl);
                }

                const res = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                    body: JSON.stringify({ product_id: productId, quantity: 1 })
                });
                const data = await res.json();
                if (data.success) {
                    renderCart(data.cart);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    const delay = window.scrollY < 5 ? 0 : 400;
                    setTimeout(() => openCartDrawer(), delay);
                    showCartToast(data.message || 'Menu berhasil ditambahkan ke keranjang!');
                } else {
                    if (data.cart) renderCart(data.cart);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    const delay = window.scrollY < 5 ? 0 : 400;
                    setTimeout(() => openCartDrawer(), delay);
                    showCartToast(data.message || 'Gagal menambahkan ke keranjang.');
                }
            } catch (e) {
                console.error(e);
            }
        }

        function animateCartBadge() {
            const badge = document.getElementById('cart-badge');
            const cartBtn = document.getElementById('cart-btn');
            const mobileDockBtn = document.getElementById('mobile-dock-cart-btn');
            const mobileDockBadge = document.getElementById('mobile-dock-cart-badge');

            if (cartBtn) {
                cartBtn.classList.remove('animate-cart-punch');
                void cartBtn.offsetWidth;
                cartBtn.classList.add('animate-cart-punch');
                setTimeout(() => {
                    cartBtn.classList.remove('animate-cart-punch');
                }, 500);
            }
            if (mobileDockBtn) {
                mobileDockBtn.classList.remove('animate-cart-punch');
                void mobileDockBtn.offsetWidth;
                mobileDockBtn.classList.add('animate-cart-punch');
                setTimeout(() => {
                    mobileDockBtn.classList.remove('animate-cart-punch');
                }, 500);
            }
            if (badge) {
                badge.classList.remove('scale-125');
                void badge.offsetWidth;
                badge.classList.add('scale-125');
                setTimeout(() => {
                    badge.classList.remove('scale-125');
                }, 350);
            }
            if (mobileDockBadge) {
                mobileDockBadge.classList.remove('scale-125');
                void mobileDockBadge.offsetWidth;
                mobileDockBadge.classList.add('scale-125');
                setTimeout(() => {
                    mobileDockBadge.classList.remove('scale-125');
                }, 350);
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
            try {
                localStorage.setItem('tb_logged_out', '1');
            } catch (e) {}
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
                closeCartDrawer();
                closeProductModal();
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

        // ═══════════════════════════════════════════════
        // INTERACTIVE MICRO-ANIMATION INITIALIZERS
        // ═══════════════════════════════════════════════
        // 1. 3D Tilt Card Interaction
        function initTiltCards() {
            if (!window.matchMedia('(hover: hover)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            document.querySelectorAll('.toon-tilt-card').forEach(card => {
                if (card.dataset.tiltInit) return;
                card.dataset.tiltInit = 'true';

                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = ((y - centerY) / centerY) * -6.5;
                    const rotateY = ((x - centerX) / centerX) * 6.5;
                    card.style.transform = `perspective(800px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px) scale3d(1.02, 1.02, 1.02)`;
                });

                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0px) scale3d(1, 1, 1)';
                });
            });
        }

        // 2. Hero Mouse Parallax Interaction (Optimized with RAF & lazy cached rect, zero scroll listeners)
        function initHeroParallax() {
            const hero = document.getElementById('hero-section');
            const burger = document.getElementById('hero-burger-img');
            const badge = document.getElementById('hero-badge-img');
            if (!hero || !burger || hero.dataset.parallaxInit || !window.matchMedia('(hover: hover)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            hero.dataset.parallaxInit = 'true';

            let ticking = false;
            let rect = null;
            let rectTs = 0;

            hero.addEventListener('mousemove', (e) => {
                const now = performance.now();
                if (!rect || (now - rectTs > 250)) {
                    rect = hero.getBoundingClientRect();
                    rectTs = now;
                }
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        const normX = (e.clientX - rect.left - (rect.width / 2)) / (rect.width / 2);
                        const normY = (e.clientY - rect.top - (rect.height / 2)) / (rect.height / 2);

                        burger.style.transform = `translate3d(${(normX * 10).toFixed(1)}px, ${(normY * 8).toFixed(1)}px, 0)`;
                        if (badge) {
                            badge.style.transform = `translate3d(${(-normX * 8).toFixed(1)}px, ${(-normY * 6).toFixed(1)}px, 0)`;
                        }
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });

            hero.addEventListener('mouseleave', () => {
                rect = null;
                burger.style.transform = 'translate3d(0, 0, 0)';
                if (badge) badge.style.transform = 'translate3d(0, 0, 0)';
            }, { passive: true });
        }

        // 3. Scroll Reveal Interaction
        function initScrollReveal() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                document.querySelectorAll('.toon-reveal').forEach(el => el.classList.add('revealed'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });

            document.querySelectorAll('.toon-reveal').forEach(el => observer.observe(el));
        }

        document.addEventListener('DOMContentLoaded', () => {
            initTiltCards();
            initHeroParallax();
            initScrollReveal();
        });

        // Instant Single-Click Public Navigation Engine (PJAX + Hover/Background Prefetch)
        (function () {
            const _tbAppPageCache = new Map();
            const _tbAppInFlight = new Map();
            const _tbLoadedScriptSrcs = new Set();
            const CACHE_TTL_MS = 90000;
            let _activeNavController = null;
            let _bgPrefetchController = null;

            function normalizeAppUrl(url) {
                try {
                    const u = new URL(url, window.location.origin);
                    u.hash = '';
                    if (u.pathname === '/') {
                        u.pathname = '/home';
                    }
                    return u.href;
                } catch (e) {
                    return url;
                }
            }

            function isPjaxEligibleAppUrl(rawHref) {
                if (!rawHref || rawHref.startsWith('#') || rawHref.startsWith('javascript:') || rawHref.startsWith('mailto:') || rawHref.startsWith('tel:')) {
                    return false;
                }
                try {
                    const u = new URL(rawHref, window.location.origin);
                    if (u.origin !== window.location.origin) return false;
                    const p = u.pathname;
                    if (
                        p.startsWith('/admin') ||
                        p.startsWith('/login') ||
                        p.startsWith('/register') ||
                        p.startsWith('/logout') ||
                        p.startsWith('/gofood') ||
                        p.startsWith('/checkout') ||
                        p.startsWith('/payment')
                    ) {
                        return false;
                    }
                    return true;
                } catch (e) {
                    return false;
                }
            }

            function isNavPathActive(linkPathname, targetPathname) {
                const lp = linkPathname === '/' ? '/home' : linkPathname;
                const tp = targetPathname === '/' ? '/home' : targetPathname;
                if (lp === '/home') return tp === '/home';
                if (lp === '/menu') return tp === '/menu' || tp.startsWith('/menu/');
                return tp === lp || tp.startsWith(lp + '/');
            }

            function updateAppNavHighlight(targetUrl) {
                let targetPath = '/home';
                try {
                    const p = new URL(targetUrl, window.location.origin).pathname;
                    targetPath = p === '/' ? '/home' : p;
                } catch (e) {}

                // Desktop Navbar Links
                document.querySelectorAll('header nav a[href]').forEach(a => {
                    try {
                        const aPath = new URL(a.href, window.location.origin).pathname;
                        const active = isNavPathActive(aPath, targetPath);
                        if (active) {
                            a.className = 'px-4 py-1.5 rounded-full transition text-sm font-bold bg-white/20 text-white shadow-2xs';
                        } else {
                            a.className = 'px-4 py-1.5 rounded-full transition text-sm font-bold text-white/80 hover:text-white hover:bg-white/10';
                        }
                    } catch (e) {}
                });

                // Mobile Dropdown Menu Links
                document.querySelectorAll('#mobile-nav-menu a[data-page-transition]').forEach(a => {
                    try {
                        const aPath = new URL(a.href, window.location.origin).pathname;
                        const active = isNavPathActive(aPath, targetPath);
                        if (active) {
                            a.className = 'block px-4 py-2 rounded-xl transition bg-[#3b6e64]/10 text-[#3b6e64]';
                        } else {
                            a.className = 'block px-4 py-2 rounded-xl transition text-gray-700 hover:text-gray-900 hover:bg-gray-100';
                        }
                    } catch (e) {}
                });

                // Mobile Bottom Dock Links
                document.querySelectorAll('nav[aria-label="Mobile Navigation"] a[href]').forEach(a => {
                    try {
                        const aPath = new URL(a.href, window.location.origin).pathname;
                        const active = isNavPathActive(aPath, targetPath);
                        if (active) {
                            a.classList.remove('text-gray-500', 'font-medium');
                            a.classList.add('text-[#27443E]', 'font-black');
                        } else {
                            a.classList.remove('text-[#27443E]', 'font-black');
                            a.classList.add('text-gray-500', 'font-medium');
                        }
                    } catch (e) {}
                });
            }

            function extractAppPagePayload(htmlText) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(htmlText, 'text/html');
                const mainEl = doc.querySelector('main');
                if (!mainEl) return null;
                return {
                    title: doc.title || document.title,
                    mainHtml: mainEl.innerHTML,
                    ts: Date.now()
                };
            }

            function prefetchAppUrl(url, isPriority) {
                const key = normalizeAppUrl(url);
                const cached = _tbAppPageCache.get(key);
                if (cached && (Date.now() - cached.ts < CACHE_TTL_MS)) {
                    return Promise.resolve(cached);
                }
                if (_tbAppInFlight.has(key)) {
                    return _tbAppInFlight.get(key);
                }

                if (isPriority && _bgPrefetchController) {
                    try { _bgPrefetchController.abort(); } catch (e) {}
                    _bgPrefetchController = null;
                }

                const controller = new AbortController();
                if (!isPriority) {
                    _bgPrefetchController = controller;
                }

                const promise = fetch(key, {
                    method: 'GET',
                    credentials: 'same-origin',
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-TB-PJAX': '1',
                        'Accept': 'text/html,application/xhtml+xml'
                    }
                })
                .then(res => {
                    if (!res.ok || res.redirected && res.url.includes('/login')) return null;
                    return res.text();
                })
                .then(html => {
                    _tbAppInFlight.delete(key);
                    if (!html) return null;
                    const payload = extractAppPagePayload(html);
                    if (payload) {
                        _tbAppPageCache.set(key, payload);
                    }
                    return payload;
                })
                .catch(() => {
                    _tbAppInFlight.delete(key);
                    return null;
                });

                _tbAppInFlight.set(key, promise);
                return promise;
            }

            function executeAppMainScripts(mainEl) {
                const scripts = Array.from(mainEl.querySelectorAll('script'));
                const externalPromises = [];

                scripts.forEach(oldScript => {
                    if (oldScript.src) {
                        const src = oldScript.src;
                        oldScript.remove();
                        if (_tbLoadedScriptSrcs.has(src) || (src.includes('leaflet') && typeof window.L !== 'undefined')) {
                            _tbLoadedScriptSrcs.add(src);
                            return;
                        }
                        const p = new Promise(resolve => {
                            const s = document.createElement('script');
                            s.src = src;
                            s.onload = () => { _tbLoadedScriptSrcs.add(src); resolve(); };
                            s.onerror = () => resolve();
                            document.head.appendChild(s);
                        });
                        externalPromises.push(p);
                    }
                });

                const runInline = () => {
                    scripts.forEach(oldScript => {
                        if (!oldScript.src) {
                            const newScript = document.createElement('script');
                            Array.from(oldScript.attributes).forEach(attr => {
                                newScript.setAttribute(attr.name, attr.value);
                            });
                            newScript.textContent = oldScript.textContent;
                            oldScript.parentNode.replaceChild(newScript, oldScript);
                        }
                    });
                };

                if (externalPromises.length > 0) {
                    Promise.all(externalPromises).then(runInline);
                } else {
                    runInline();
                }
            }

            function applyAppPayload(url, payload, pushHistory, preserveScroll = false) {
                const mainEl = document.querySelector('main');
                if (!mainEl || !payload) return false;

                const currentScrollY = preserveScroll ? window.scrollY : 0;
                const currentScrollX = preserveScroll ? window.scrollX : 0;

                document.title = payload.title;
                mainEl.innerHTML = payload.mainHtml;

                const mobileMenu = document.getElementById('mobile-nav-menu');
                if (mobileMenu) mobileMenu.classList.add('hidden');
                const searchDropdown = document.getElementById('home-search-dropdown');
                if (searchDropdown) searchDropdown.classList.add('hidden');

                if (pushHistory && normalizeAppUrl(window.location.href) !== normalizeAppUrl(url)) {
                    window.history.pushState({ tbAppPjax: true, url: url, scrollY: currentScrollY }, payload.title, url);
                }

                updateAppNavHighlight(url);
                if (preserveScroll) {
                    window.scrollTo({ top: currentScrollY, left: currentScrollX, behavior: 'instant' });
                } else {
                    window.scrollTo({ top: 0, left: 0, behavior: 'instant' });
                }

                executeAppMainScripts(mainEl);
                initTiltCards();
                initHeroParallax();
                initScrollReveal();
                return true;
            }

            window.tbAppNavigate = function (url, pushHistory = true, preserveScroll = false) {
                const key = normalizeAppUrl(url);
                updateAppNavHighlight(key);

                const cached = _tbAppPageCache.get(key);
                if (cached && (Date.now() - cached.ts < CACHE_TTL_MS)) {
                    applyAppPayload(url, cached, pushHistory, preserveScroll);
                    return;
                }

                if (_activeNavController) {
                    try { _activeNavController.abort(); } catch (e) {}
                }
                _activeNavController = new AbortController();

                prefetchAppUrl(key, true).then(payload => {
                    if (payload) {
                        applyAppPayload(url, payload, pushHistory, preserveScroll);
                    } else {
                        window.location.href = url;
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', () => {
                const mainEl = document.querySelector('main');
                if (mainEl) {
                    _tbAppPageCache.set(normalizeAppUrl(window.location.href), {
                        title: document.title,
                        mainHtml: mainEl.innerHTML,
                        ts: Date.now()
                    });
                }

                // Warm up primary public navigation pages sequentially during browser idle time after initial load
                const warmUpPublicNav = () => {
                    if (navigator.connection && (navigator.connection.saveData || /2g/.test(navigator.connection.effectiveType || ''))) {
                        return;
                    }
                    const runWarmUp = async () => {
                        const links = Array.from(document.querySelectorAll('header nav a[href]'))
                            .map(a => a.href)
                            .filter(href => isPjaxEligibleAppUrl(href));

                        for (const href of links) {
                            const key = normalizeAppUrl(href);
                            if (!_tbAppPageCache.has(key)) {
                                await prefetchAppUrl(key, false);
                            }
                        }
                    };
                    if ('requestIdleCallback' in window) {
                        window.requestIdleCallback(() => { runWarmUp(); }, { timeout: 2000 });
                    } else {
                        setTimeout(runWarmUp, 600);
                    }
                };

                if (document.readyState === 'complete') {
                    warmUpPublicNav();
                } else {
                    window.addEventListener('load', warmUpPublicNav, { once: true });
                }
            });

            // Prefetch on hover/mousedown/touchstart so clicking is instant
            const triggerAppPrefetch = (e) => {
                const link = e.target.closest('a[href]');
                if (!link) return;
                const rawHref = link.getAttribute('href');
                if (link.target === '_blank' || link.hasAttribute('download') || !isPjaxEligibleAppUrl(rawHref)) return;
                prefetchAppUrl(link.href, true);
            };
            document.addEventListener('pointerover', triggerAppPrefetch, { passive: true });
            document.addEventListener('mousedown', triggerAppPrefetch, { passive: true });
            document.addEventListener('touchstart', triggerAppPrefetch, { passive: true });

            // Intercept single clicks on internal public links
            document.addEventListener('click', (e) => {
                if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                const link = e.target.closest('a[href]');
                if (!link) return;
                const rawHref = link.getAttribute('href');
                if (link.target === '_blank' || link.hasAttribute('download') || !isPjaxEligibleAppUrl(rawHref)) return;

                const preserveScroll = link.hasAttribute('data-preserve-scroll');

                e.preventDefault();
                window.tbAppNavigate(link.href, true, preserveScroll);
            });

            // Intercept GET search/filter forms pointing to internal public routes
            document.addEventListener('submit', (e) => {
                const form = e.target;
                if (!form || form.tagName !== 'FORM') return;
                const method = (form.getAttribute('method') || 'GET').toUpperCase();
                if (method === 'GET') {
                    const action = form.getAttribute('action') || window.location.pathname;
                    if (!isPjaxEligibleAppUrl(action)) return;
                    e.preventDefault();
                    const u = new URL(action, window.location.origin);
                    const fd = new FormData(form);
                    u.search = new URLSearchParams(fd).toString();
                    const preserveScroll = form.hasAttribute('data-preserve-scroll');
                    window.tbAppNavigate(u.href, true, preserveScroll);
                } else {
                    _tbAppPageCache.clear();
                }
            });

            window.addEventListener('popstate', (e) => {
                if (isPjaxEligibleAppUrl(window.location.href)) {
                    const state = e.state || {};
                    const preserveScroll = typeof state.scrollY === 'number';
                    window.tbAppNavigate(window.location.href, false, preserveScroll);
                }
            });
        })();

        // Reload page on Back / Forward navigation only if user logged out
        window.addEventListener('pageshow', function () {
            try {
                if (localStorage.getItem('tb_logged_out') === '1') {
                    localStorage.removeItem('tb_logged_out');
                    window.location.reload();
                }
            } catch (e) {}
        });

        // Register Service Worker for offline & Laragon down handling
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
</body>
</html>

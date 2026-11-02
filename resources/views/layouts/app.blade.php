<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/toon-head.png') }}">
    <title>@yield('title', 'Toon Burger - Smash Burger & Takeaway Hub')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Luckiest+Guy&family=Poppins:wght@300;400;500;600;700;800;900&family=Titan+One&family=Nunito:wght@900&display=swap" rel="stylesheet">

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
                        luckiest: ['"Luckiest Guy"', 'cursive'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; overflow-x: clip; }
        .font-brand {
            font-family: 'Luckiest Guy', cursive;
            letter-spacing: 0.04em;
        }
        .retro-grid-bg {
            background-color: #FAF5E8;
            background-image: 
                linear-gradient(to right, rgba(59, 92, 86, 0.07) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(59, 92, 86, 0.07) 1px, transparent 1px);
            background-size: 36px 36px;
        }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marquee 25s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
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
            will-change: transform;
        }

        /* 2. Comic Sparkle Twinkle */
        @keyframes comicTwinkle {
            0%, 100% {
                transform: scale(0.85) rotate(0deg);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.18) rotate(15deg);
                opacity: 1;
            }
        }
        .comic-sparkle {
            animation: comicTwinkle 2.8s ease-in-out infinite;
            will-change: transform, opacity;
        }

        /* 3. Comic Badge Interactive */
        .comic-badge-interactive {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            will-change: transform;
        }
        .comic-badge-interactive:hover {
            transform: scale(1.08) rotate(3deg);
        }

        /* 4. Squash & Stretch Button Micro-interaction */
        .toon-btn-bounce {
            transition: transform 0.16s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.16s ease, filter 0.16s ease;
            will-change: transform;
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
            will-change: transform;
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
            transform: translateY(20px) scale(0.98);
            transition: opacity 0.55s cubic-bezier(0.25, 1, 0.5, 1), transform 0.55s cubic-bezier(0.25, 1, 0.5, 1);
            will-change: opacity, transform;
        }
        .toon-reveal.revealed {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Accessibility: Respect Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            .toon-bob, .comic-sparkle, .animate-cart-punch {
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

    <header class="sticky top-0 z-40 px-3 sm:px-6 lg:px-8 pt-3 sm:pt-4 pb-2 select-none">
        <div class="w-full max-w-[1380px] mx-auto relative">
            <div class="flex items-center justify-between px-5 sm:px-7 py-2.5 rounded-full shadow-md border border-black/40 backdrop-blur-md transition relative"
                 style="background-color: rgba(38, 58, 54, 0.72);">

                <div class="flex items-center gap-6 lg:gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group shrink-0">
                        <img src="{{ asset('images/toon-head.png') }}" alt="Toon Burger Logo"
                             class="h-9 sm:h-10 w-auto object-contain transition group-hover:scale-105">
                        <span class="text-white text-xl sm:text-[23px] uppercase tracking-wider shrink-0 leading-none pt-0.5"
                              style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.04em;">
                            TOON BURGER
                        </span>
                    </a>

                    <nav class="hidden lg:flex items-center gap-1.5 xl:gap-3 text-xs sm:text-[13px]">
                        <a href="{{ route('home') }}" data-page-transition
                           class="px-4 py-1.5 rounded-full transition font-medium
                                  {{ request()->routeIs('home') ? 'bg-white/20 text-white' : 'text-white/90 hover:text-white hover:bg-white/10' }}">
                            Beranda
                        </a>
                        <a href="{{ route('menu') }}" data-page-transition
                           class="px-4 py-1.5 rounded-full transition font-medium
                                  {{ request()->routeIs('menu*') ? 'bg-white/20 text-white' : 'text-white/90 hover:text-white hover:bg-white/10' }}">
                            Menu
                        </a>
                        <a href="{{ route('about') }}" data-page-transition
                           class="px-4 py-1.5 rounded-full transition font-medium
                                  {{ request()->routeIs('about') ? 'bg-white/20 text-white' : 'text-white/90 hover:text-white hover:bg-white/10' }}">
                            Tentang
                        </a>
                        <a href="{{ route('contact') }}" data-page-transition
                           class="px-4 py-1.5 rounded-full transition font-medium
                                  {{ request()->routeIs('contact') ? 'bg-white/20 text-white' : 'text-white/90 hover:text-white hover:bg-white/10' }}">
                            Kontak
                        </a>
                    </nav>
                </div>

                <div class="flex items-center gap-4 sm:gap-5 shrink-0">
                    <div class="relative hidden md:block w-52 sm:w-64 lg:w-72">
                        <form action="{{ route('menu') }}" method="GET" class="w-full bg-[#F5F6FA] hover:bg-white focus-within:bg-white rounded-full px-4 py-2 flex items-center gap-2.5 transition shadow-2xs">
                            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                   name="q"
                                   id="home-navbar-search"
                                   placeholder="Cheese Burger..."
                                   autocomplete="off"
                                   class="bg-transparent text-xs text-gray-800 placeholder-gray-400 outline-none w-full font-normal">
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

                    <button type="button"
                            onclick="toggleCartDrawer()"
                            id="cart-btn"
                            class="hidden relative w-9 h-9 rounded-full bg-white/15 hover:bg-white/25 items-center justify-center text-white transition cursor-pointer shrink-0"
                            aria-label="Keranjang Belanja">
                        <span id="cart-badge" class="text-xs font-bold">{{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}</span>
                    </button>

                    @auth
                        <!-- User Profile Dropdown Container -->
                        <div id="user-dropdown-container" class="relative shrink-0 select-none">
                            <button type="button"
                                    id="user-menu-button"
                                    onclick="toggleUserDropdown(event)"
                                    class="flex items-center gap-2 sm:gap-2.5 px-2 py-1 sm:px-3 sm:py-1.5 rounded-full bg-white/15 hover:bg-white/25 border border-white/20 transition cursor-pointer text-left focus:outline-none"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                @if(Auth::user()->avatar)
                                    <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                                         alt="{{ Auth::user()->name }}"
                                         class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover border border-amber-300 shrink-0">
                                @else
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#F5B027] text-gray-950 font-black text-xs flex items-center justify-center border border-black/20 shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                @endif

                                <span class="text-white text-xs sm:text-[13px] font-semibold max-w-[90px] sm:max-w-[130px] truncate hidden md:inline-block">
                                    {{ Auth::user()->name }}
                                </span>

                                <svg id="user-menu-arrow" class="w-3.5 h-3.5 text-white/80 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown-menu"
                                 class="absolute right-0 top-full mt-2.5 w-60 bg-white rounded-2xl border border-gray-200/90 shadow-2xl p-2 z-50 hidden animate-modal-pop text-gray-800">

                                <!-- User Info Header -->
                                <div class="px-3 py-2.5 border-b border-gray-100 flex items-center gap-3">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                                             alt="{{ Auth::user()->name }}"
                                             class="w-9 h-9 rounded-full object-cover border border-amber-300 shrink-0">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-[#F5B027] text-gray-950 font-black text-xs flex items-center justify-center border border-black/20 shrink-0">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                        <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                            {{ Auth::user()->isAdmin() ? 'bg-rose-100 text-rose-700' : (Auth::user()->isStaff() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                            {{ Auth::user()->role ?? 'Member' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Links -->
                                <div class="py-1 space-y-0.5 text-xs font-medium">
                                    @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                        <a href="{{ route('admin.dashboard') }}"
                                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4 text-[#3F5E5A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                            </svg>
                                            <span>Dashboard Admin</span>
                                        </a>
                                        <a href="{{ route('admin.profile') }}"
                                           class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4 text-[#3F5E5A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>Profil Admin</span>
                                        </a>
                                    @endif

                                    <a href="{{ route('orders.index') }}"
                                       class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4 text-[#3F5E5A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                        <span>Pesanan Saya</span>
                                    </a>
                                </div>

                                <div class="border-t border-gray-100 pt-1">
                                    <button type="button"
                                            onclick="confirmLogout(event)"
                                            class="w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 text-xs font-semibold transition cursor-pointer">
                                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Keluar Akun</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-[13px] shrink-0 select-none">
                            <a href="{{ route('login') }}" class="text-white hover:text-white/80 font-medium transition px-2 py-1">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="bg-[#F5B027] hover:bg-[#E09E1E] text-gray-950 font-bold px-4 py-2 rounded-full transition shadow-xs">
                                Sign In
                            </a>
                        </div>
                    @endauth

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
                        <div class="pt-2 mt-2 border-t border-gray-100">
                            <div class="px-3 py-2 flex items-center gap-3 bg-gray-50 rounded-xl mb-1">
                                @if(Auth::user()->avatar)
                                    <img src="{{ str_starts_with(Auth::user()->avatar, 'http') ? Auth::user()->avatar : asset(Auth::user()->avatar) }}"
                                         alt="{{ Auth::user()->name }}"
                                         class="w-9 h-9 rounded-full object-cover border border-amber-300 shrink-0">
                                @else
                                    <div class="w-9 h-9 rounded-full bg-[#F5B027] text-gray-950 font-black text-xs flex items-center justify-center border border-black/20 shrink-0">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                    {{ Auth::user()->isAdmin() ? 'bg-rose-100 text-rose-700' : (Auth::user()->isStaff() ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ Auth::user()->role ?? 'Member' }}
                                </span>
                            </div>

                            @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                <a href="{{ route('admin.dashboard') }}" onclick="toggleMobileNav()"
                                   class="block px-4 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                    Dashboard Admin
                                </a>
                                <a href="{{ route('admin.profile') }}" onclick="toggleMobileNav()"
                                   class="block px-4 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                    Profil Admin
                                </a>
                            @endif

                            <a href="{{ route('orders.index') }}" onclick="toggleMobileNav()"
                               class="block px-4 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition">
                                Pesanan Saya
                            </a>
                            <button type="button" onclick="confirmLogout(event)"
                                class="w-full text-left block px-4 py-2 rounded-xl text-red-700 hover:text-red-800 hover:bg-red-50 transition font-semibold">
                                Logout
                            </button>
                        </div>
                    @else
                        <div class="pt-2 mt-2 border-t border-gray-100 flex items-center gap-2">
                            <a href="{{ route('login') }}" onclick="toggleMobileNav()"
                               class="w-1/2 text-center py-2 text-xs font-semibold text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                                Login
                            </a>
                            <a href="{{ route('register') }}" onclick="toggleMobileNav()"
                               class="w-1/2 text-center py-2 text-xs font-semibold text-white bg-[#F5B027] hover:bg-[#E09E1E] rounded-xl transition">
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
    <div id="product-modal-backdrop" onclick="closeProductModal()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 hidden transition-opacity duration-200"></div>
    <div id="product-modal" onclick="closeProductModal()" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-6 hidden overflow-y-auto">
        <div class="relative bg-[#FAF5E8] retro-grid-bg rounded-[32px] sm:rounded-[36px] border-2 border-black shadow-[8px_8px_0px_#27443E] max-w-4xl w-full p-5 sm:p-8 lg:p-10 animate-modal-pop my-auto text-gray-900 overflow-hidden"
             onclick="event.stopPropagation()">

            <!-- Close Button -->
            <button type="button"
                    onclick="closeProductModal()"
                    class="absolute top-4 right-4 sm:top-6 sm:right-6 w-9 h-9 rounded-full bg-black/10 hover:bg-black/20 text-gray-800 flex items-center justify-center transition cursor-pointer z-20 focus:outline-none"
                    aria-label="Tutup modal">
                <svg class="w-4 h-4 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 items-center">

                <!-- Left Column: Burger Image Card -->
                <div class="md:col-span-5 flex justify-center">
                    <div class="w-full max-w-[340px] aspect-square rounded-[28px] sm:rounded-[32px] border-2 border-black shadow-[6px_6px_0px_#2E4A44] overflow-hidden bg-[#EFE3CF] flex items-center justify-center p-4 sm:p-6">
                        <img id="modal-product-image"
                             src=""
                             alt="Menu"
                             class="w-full h-full object-contain select-none drop-shadow-md">
                    </div>
                </div>

                <!-- Right Column: Details & Actions -->
                <div class="md:col-span-7 flex flex-col justify-between space-y-3 sm:space-y-4">
                    <!-- Category, Name, Price -->
                    <div>
                        <span id="modal-product-category"
                              class="text-[11px] sm:text-xs font-bold text-[#6D837E] uppercase tracking-wider block">
                            CHICKEN BURGER
                        </span>

                        <h2 id="modal-product-name"
                            class="text-xl sm:text-2xl lg:text-[28px] font-black text-[#1E332E] uppercase tracking-wide leading-tight mt-1"
                            style="font-family: 'Titan One', 'Luckiest Guy', sans-serif;">
                            CHEESE CHICKEN BURGER
                        </h2>

                        <div id="modal-product-price"
                             class="text-base sm:text-lg lg:text-xl font-black text-[#1E332E] mt-1">
                            RP 35.000
                        </div>
                    </div>

                    <!-- Thin Divider Line -->
                    <div class="border-t border-gray-300/80 my-0.5"></div>

                    <!-- Description -->
                    <p id="modal-product-desc"
                       class="text-xs sm:text-[13px] text-gray-600 leading-relaxed font-normal">
                        Deskripsi produk...
                    </p>

                    <!-- Options Form (Hidden if not used) -->
                    <div id="modal-options-container" class="space-y-2 hidden"></div>

                    <!-- Catatan Pesanan -->
                    <div>
                        <label for="modal-notes" class="block text-xs font-bold text-gray-900 mb-1.5">
                            Catatan Pesanan
                        </label>
                        <textarea id="modal-notes"
                                  name="notes"
                                  rows="3"
                                  placeholder="Contoh: saus dipisah, tanpa selada..."
                                  class="w-full bg-white border border-gray-200 rounded-xl sm:rounded-2xl p-3 text-xs sm:text-[13px] text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#3E615D] focus:ring-1 focus:ring-[#3E615D] transition resize-none shadow-2xs"></textarea>
                    </div>

                    <!-- Bottom Row: Quantity & Add to Cart -->
                    <div class="flex items-center gap-3 pt-2">
                        <!-- Quantity Selector -->
                        <div class="inline-flex items-center bg-white border border-gray-200 rounded-xl px-2.5 py-1.5 shadow-2xs">
                            <button type="button"
                                    onclick="adjustModalQty(-1)"
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 font-bold text-base transition cursor-pointer select-none active:scale-90"
                                    aria-label="Kurang kuantitas">
                                -
                            </button>
                            <input type="number"
                                   id="modal-quantity"
                                   value="1"
                                   min="1"
                                   readonly
                                   class="w-8 sm:w-10 text-center font-bold text-xs sm:text-sm text-gray-900 border-none focus:outline-none select-none bg-transparent">
                            <button type="button"
                                    onclick="adjustModalQty(1)"
                                    class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center text-gray-500 hover:text-gray-900 font-bold text-base transition cursor-pointer select-none active:scale-90"
                                    aria-label="Tambah kuantitas">
                                +
                            </button>
                        </div>

                        <!-- Add to Cart Button -->
                        <button type="button"
                                id="modal-add-to-cart-btn"
                                onclick="submitAddToCart()"
                                class="flex-1 bg-[#3E615D] hover:bg-[#324F4C] active:scale-[0.98] text-white text-xs sm:text-sm font-bold py-2.5 sm:py-3 px-5 sm:px-6 rounded-xl transition shadow-xs flex items-center justify-center gap-2.5 cursor-pointer">
                            <span>Tambahkan ke keranjang</span>
                            <svg class="w-4 h-4 sm:w-4.5 sm:h-4.5 stroke-[2.2]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </button>
                    </div>

                    <input type="hidden" id="modal-product-id" name="product_id" value="">
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
                document.getElementById('modal-product-desc').innerText = currentModalProduct.description || 'Pilihan burger terbaik khas Toon Burger dengan bahan berkualitas segar dan lezat.';

                const catElem = document.getElementById('modal-product-category');
                if (catElem) {
                    catElem.innerText = (currentModalProduct.category ? currentModalProduct.category.name : 'BURGER').toUpperCase();
                }

                const priceElem = document.getElementById('modal-product-price');
                if (priceElem) {
                    priceElem.innerText = 'RP ' + Number(currentModalProduct.price).toLocaleString('id-ID');
                }

                const imgElem = document.getElementById('modal-product-image');
                if (imgElem) {
                    imgElem.src = currentModalProduct.image ? '/' + currentModalProduct.image.replace(/^\//, '') : '/images/hero-burger.png';
                    imgElem.alt = currentModalProduct.name;
                }

                document.getElementById('modal-quantity').value = 1;
                const notesElem = document.getElementById('modal-notes');
                if (notesElem) notesElem.value = '';

                document.getElementById('product-modal').classList.remove('hidden');
                document.getElementById('product-modal-backdrop').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } catch (e) {
                console.error(e);
            }
        }

        function closeProductModal() {
            const modal = document.getElementById('product-modal');
            const backdrop = document.getElementById('product-modal-backdrop');
            if (modal) modal.classList.add('hidden');
            if (backdrop) backdrop.classList.add('hidden');
            document.body.style.overflow = '';
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
                    alert(data.message || 'Gagal menambahkan ke keranjang.');
                }
            } catch (e) {
                console.error(e);
            }
        }

        function animateCartBadge() {
            const badge = document.getElementById('cart-badge');
            const cartBtn = document.getElementById('cart-btn');
            if (cartBtn) {
                cartBtn.classList.remove('animate-cart-punch');
                void cartBtn.offsetWidth;
                cartBtn.classList.add('animate-cart-punch');
                setTimeout(() => {
                    cartBtn.classList.remove('animate-cart-punch');
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

        // 2. Hero Mouse Parallax Interaction
        function initHeroParallax() {
            const hero = document.getElementById('hero-section');
            const burger = document.getElementById('hero-burger-img');
            const badge = document.getElementById('hero-badge-img');
            if (!hero || !burger || !window.matchMedia('(hover: hover)').matches || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            hero.addEventListener('mousemove', (e) => {
                const rect = hero.getBoundingClientRect();
                const normX = (e.clientX - rect.left - (rect.width / 2)) / (rect.width / 2);
                const normY = (e.clientY - rect.top - (rect.height / 2)) / (rect.height / 2);

                burger.style.transform = `translate3d(${(normX * 10).toFixed(1)}px, ${(normY * 8).toFixed(1)}px, 0)`;
                if (badge) {
                    badge.style.transform = `translate3d(${(-normX * 8).toFixed(1)}px, ${(-normY * 6).toFixed(1)}px, 0)`;
                }
            });

            hero.addEventListener('mouseleave', () => {
                burger.style.transform = 'translate3d(0, 0, 0)';
                if (badge) badge.style.transform = 'translate3d(0, 0, 0)';
            });
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

        // Reload page on Back / Forward navigation to prevent displaying cached authenticated views after logout
        window.addEventListener('pageshow', function (event) {
            const navEntries = window.performance && window.performance.getEntriesByType ? window.performance.getEntriesByType("navigation") : [];
            const isBackForward = event.persisted || 
                (navEntries.length > 0 && navEntries[0].type === 'back_forward') || 
                (window.performance && window.performance.navigation && window.performance.navigation.type === 2);

            if (isBackForward) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>

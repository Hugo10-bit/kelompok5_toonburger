<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Toon Burger - Smash Burger & Takeaway Hub')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
            animation: pageEnter 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            caret-color: #D92625;
        }
        body.page-exiting {
            opacity: 0 !important;
            transform: translateY(-4px) scale(0.995);
        }
        ::selection {
            background-color: #D92625;
            color: #ffffff;
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
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
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

    <!-- ═══ MODAL KONFIRMASI LOGOUT (SESUAI MOCKUP FOTO) ═══ -->
    <div id="logout-confirm-modal" class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <!-- Backdrop: Fixed, centered, non-shifting -->
        <div class="fixed inset-0 bg-black/45 backdrop-blur-[2px] transition-opacity duration-200" onclick="closeLogoutModal()"></div>

        <!-- Modal Dialog Card: Centered on screen, never shifts -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 sm:p-10 max-w-[460px] w-full text-center z-10 select-none animate-modal-pop border border-[#EFE5D0]">
            <!-- Warning Icon Circle (Muted Sage Green - Sesuai Foto) -->
            <div class="w-[92px] h-[92px] rounded-full border-[4.5px] border-[#9AA887] flex items-center justify-center mx-auto mb-6 bg-white shadow-2xs">
                <svg class="w-10 h-10 text-[#9AA887]" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 4.5c-.83 0-1.5.67-1.5 1.5v7.2c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V6c0-.83-.67-1.5-1.5-1.5zM12 17.2a1.8 1.8 0 100 3.6 1.8 1.8 0 000-3.6z"/>
                </svg>
            </div>

            <!-- Title -->
            <h3 class="text-2xl sm:text-[27px] font-bold text-[#2D3139] tracking-tight mb-3">
                Konfirmasi Logout
            </h3>

            <!-- Subtitle Description (Sesuai Foto) -->
            <p class="text-[#555C68] text-sm sm:text-[14.5px] leading-relaxed max-w-sm mx-auto mb-8 font-normal">
                Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.
            </p>

            <!-- Action Buttons: Batalkan & ya, keluar (Sesuai Foto) -->
            <div class="flex items-center justify-center gap-3.5 sm:gap-4">
                <button type="button" 
                        onclick="closeLogoutModal()" 
                        class="bg-white hover:bg-gray-50 active:scale-95 text-[#2D3139] border border-[#4B5563] rounded-lg px-8 py-2.5 text-sm font-semibold transition min-w-[130px] focus:outline-none">
                    Batalkan
                </button>
                <button type="button" 
                        onclick="submitLogoutForm()" 
                        class="bg-[#DE3B28] hover:bg-[#C9301F] active:scale-95 text-white rounded-lg px-8 py-2.5 text-sm font-semibold transition min-w-[130px] shadow-xs focus:outline-none">
                    ya, keluar
                </button>
            </div>
        </div>
    </div>

    <!-- TOP NAVBAR -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200/80 shadow-xs transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-18">
                
                <!-- Logo -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo.png') }}" alt="Toon Burger Logo" class="h-12 sm:h-14 w-auto object-contain transition group-hover:scale-105">
                    </a>

                    <!-- Nav Links: Separate Dedicated Pages -->
                    <nav class="hidden md:flex items-center gap-1 font-semibold text-sm">
                        <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('home') ? 'text-bites-red font-extrabold bg-red-50/80 shadow-2xs' : 'text-gray-700 hover:text-bites-red hover:bg-red-50/60' }}">
                            Home
                        </a>
                        <a href="{{ route('menu') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('menu') ? 'text-bites-red font-extrabold bg-red-50/80 shadow-2xs' : 'text-gray-700 hover:text-bites-red hover:bg-red-50/60' }}">
                            Menu Produk
                        </a>
                        <a href="{{ route('about') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('about') ? 'text-bites-red font-extrabold bg-red-50/80 shadow-2xs' : 'text-gray-700 hover:text-bites-red hover:bg-red-50/60' }}">
                            About Us
                        </a>
                        <a href="{{ route('contact') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('contact') ? 'text-bites-red font-extrabold bg-red-50/80 shadow-2xs' : 'text-gray-700 hover:text-bites-red hover:bg-red-50/60' }}">
                            Contact
                        </a>
                        @auth
                            <a href="{{ route('orders.index') }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('orders.*') ? 'text-bites-red font-extrabold bg-red-50/80 shadow-2xs' : 'text-gray-700 hover:text-bites-red hover:bg-red-50/60' }}">
                                Pesanan Saya
                            </a>
                            @if(Auth::user()->isStaff())
                                <a href="{{ route('admin.pos') }}" class="px-3.5 py-2 rounded-xl text-amber-700 bg-amber-50 hover:bg-amber-100 transition font-semibold">
                                    POS Kasir
                                </a>
                                <a href="{{ route('admin.dashboard') }}" class="px-3.5 py-2 rounded-xl text-purple-700 bg-purple-50 hover:bg-purple-100 transition font-semibold">
                                    Panel Admin
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">
                    
                    <!-- Search Bar (Desktop) -->
                    <form action="{{ route('menu') }}" method="GET" class="hidden lg:flex items-center relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari burger, chicken..." 
                            class="bg-gray-100/90 text-xs text-gray-800 pl-9 pr-4 py-2.5 rounded-full w-56 focus:w-64 focus:bg-white focus:ring-2 focus:ring-bites-orange focus:outline-none transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </form>

                    <!-- Cart Trigger Button -->
                    <button onclick="toggleCartDrawer()" id="cart-btn" class="relative bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark font-bold p-2.5 sm:px-4 sm:py-2.5 rounded-xl flex items-center gap-2 shadow-sm transition active:scale-95">
                        <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span class="hidden sm:inline text-xs font-semibold">Keranjang</span>
                        <span id="cart-badge" class="bg-bites-red text-white text-[11px] font-extrabold px-2 py-0.5 rounded-full shadow-xs">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                        </span>
                    </button>

                    <!-- User / Auth -->
                    <!-- User / Auth -->
                    @auth
                        <div class="relative" id="user-dropdown-container">
                            <button onclick="toggleUserDropdown(event)" id="user-menu-button" type="button" 
                                class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 p-1.5 sm:pr-3 rounded-full text-xs font-semibold transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-bites-orange">
                                <div class="w-8 h-8 rounded-full bg-bites-red text-white flex items-center justify-center font-bold text-xs uppercase shadow-xs">
                                    {{ substr(Auth::user()->name ?: Auth::user()->username, 0, 2) }}
                                </div>
                                <span class="hidden sm:inline max-w-[120px] truncate text-gray-800">{{ Auth::user()->username }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200" id="user-menu-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 transition-all transform origin-top-right">
                                <div class="px-4 py-2.5 border-b border-gray-100 text-xs">
                                    <div class="font-bold text-gray-900 truncate text-sm">{{ Auth::user()->name }}</div>
                                    <div class="text-gray-500 truncate text-[11px]">{{ Auth::user()->email }}</div>
                                    <span class="inline-block mt-1.5 px-2 py-0.5 bg-yellow-100 text-yellow-800 text-[10px] font-extrabold rounded-md uppercase">Role: {{ Auth::user()->role }}</span>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs text-gray-700 hover:bg-gray-50 hover:text-bites-red transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Pesanan Saya
                                    </a>
                                    @if(Auth::user()->isStaff())
                                        <a href="{{ route('admin.pos') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs text-amber-700 hover:bg-amber-50 font-semibold transition">
                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            POS Kasir
                                        </a>
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-xs text-purple-700 hover:bg-purple-50 font-semibold transition">
                                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                            Dashboard Admin
                                        </a>
                                    @endif
                                </div>
                                <div class="border-t border-gray-100 pt-1">
                                    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout(event)">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-xs text-red-600 hover:bg-red-50 font-bold flex items-center gap-2 transition">
                                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-black text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition">
                            Login / Masuk
                        </a>
                    @endauth

                    <!-- Mobile Hamburger Button -->
                    <button type="button" onclick="toggleMobileNav()" class="md:hidden p-2 text-gray-700 hover:text-bites-red hover:bg-gray-100 rounded-xl transition" aria-label="Toggle Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-nav-menu" class="hidden md:hidden border-t border-gray-100 py-3 space-y-1 bg-white px-2">
                <a href="{{ route('home') }}" onclick="toggleMobileNav()" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('home') ? 'text-red-950 font-extrabold bg-red-100/80 shadow-2xs' : 'text-stone-800 hover:text-bites-red hover:bg-stone-100/70' }}">
                    Home
                </a>
                <a href="{{ route('menu') }}" onclick="toggleMobileNav()" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('menu') ? 'text-red-950 font-extrabold bg-red-100/80 shadow-2xs' : 'text-stone-800 hover:text-bites-red hover:bg-stone-100/70' }}">
                    Menu Produk
                </a>
                <a href="{{ route('about') }}" onclick="toggleMobileNav()" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('about') ? 'text-red-950 font-extrabold bg-red-100/80 shadow-2xs' : 'text-stone-800 hover:text-bites-red hover:bg-stone-100/70' }}">
                    About Us
                </a>
                <a href="{{ route('contact') }}" onclick="toggleMobileNav()" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('contact') ? 'text-red-950 font-extrabold bg-red-100/80 shadow-2xs' : 'text-stone-800 hover:text-bites-red hover:bg-stone-100/70' }}">
                    Contact
                </a>
                @auth
                    <a href="{{ route('orders.index') }}" class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('orders.*') ? 'text-red-950 font-extrabold bg-red-100/80' : 'text-stone-800 hover:text-bites-red hover:bg-stone-100/70' }}">
                        Pesanan Saya
                    </a>
                @endauth
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

    <!-- FOOTER -->
    <footer class="bg-[#263A38] text-white border-t border-white/10 mt-20 pt-14 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Brand Info -->
                <div class="space-y-3.5">
                    <img src="{{ asset('images/toonburger-logo-white.png') }}" alt="Toon Burger" class="h-12 w-auto object-contain">
                    <p class="text-xs text-gray-300 leading-relaxed">
                        Citarasa burger klasik otentik dengan 100% daging sapi Australia, brioche bun mentega panggang segar, dan saus lezat karakter Toon Burger.
                    </p>
                    <div class="flex items-center gap-3 pt-1 text-gray-400">
                        <span class="text-xs font-semibold text-amber-300">★ 4.9/5 Rating Pelanggan</span>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div>
                    <h4 class="text-xs font-black text-amber-300 mb-3.5 uppercase tracking-wider">Navigasi Halaman</h4>
                    <ul class="text-xs text-gray-300 space-y-2 font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-amber-300 transition">&bull; Home</a></li>
                        <li><a href="{{ route('menu') }}" class="hover:text-amber-300 transition">&bull; Menu Produk</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-amber-300 transition">&bull; About Us (Tentang Kami)</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-amber-300 transition">&bull; Contact (Kontak & Lokasi)</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-amber-300 transition">&bull; Panel Admin Restoran</a></li>
                    </ul>
                </div>

                <!-- Jam Buka & Lokasi -->
                <div>
                    <h4 class="text-xs font-black text-amber-300 mb-3.5 uppercase tracking-wider">Jam Buka & Lokasi</h4>
                    <ul class="text-xs text-gray-300 space-y-2">
                        <li><strong>Senin - Jumat:</strong> 10:00 - 22:00 WITA</li>
                        <li><strong>Sabtu - Minggu:</strong> 09:00 - 23:00 WITA</li>
                        <li class="pt-1 text-amber-300 font-semibold">&bull; Khusus Takeaway &amp; Online Delivery (No Dine-In)</li>
                        <li class="text-gray-300 leading-relaxed">&bull; HR7F+P8M, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan</li>
                    </ul>
                </div>

                <!-- Voucher & Promo -->
                <div>
                    <h4 class="text-xs font-black text-amber-300 mb-3.5 uppercase tracking-wider">Kupon Promo Hari Ini</h4>
                    <ul class="text-xs text-gray-300 space-y-2 font-mono">
                        <li class="bg-white/10 p-2 rounded-xl flex items-center justify-between">
                            <span class="text-amber-300 font-bold">TOONBURGER50</span>
                            <span class="text-[10px] text-gray-300 font-sans">Diskon 50%</span>
                        </li>
                        <li class="bg-white/10 p-2 rounded-xl flex items-center justify-between">
                            <span class="text-amber-300 font-bold">WELCOMETOON</span>
                            <span class="text-[10px] text-gray-300 font-sans">Potongan 15K</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-400">
                <p>&copy; {{ date('Y') }} Toon Burger. All Rights Reserved.</p>
                <p class="mt-2 sm:mt-0 font-medium">Toon Burger Indonesia</p>
            </div>
        </div>
    </footer>

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
                        <span id="modal-product-time" class="bg-gray-100 px-2 py-0.5 rounded font-semibold">0 menit</span>
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

        let pendingLogoutForm = null;

        function confirmLogout(event) {
            if (event) {
                event.preventDefault();
                pendingLogoutForm = event.target.closest('form');
            }
            const modal = document.getElementById('logout-confirm-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
            return false;
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logout-confirm-modal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function submitLogoutForm() {
            if (pendingLogoutForm) {
                pendingLogoutForm.submit();
            } else {
                const forms = document.querySelectorAll('form[action*="logout"]');
                if (forms.length > 0) {
                    forms[0].submit();
                }
            }
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeLogoutModal();
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
                if (!link) return;

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

        window.addEventListener('pageshow', (event) => {
            if (event.persisted) {
                document.body.classList.remove('page-exiting');
                const loader = document.getElementById('page-loader-bar');
                if (loader) {
                    loader.style.transform = 'scaleX(1)';
                    setTimeout(() => { loader.style.opacity = '0'; loader.style.transform = 'scaleX(0)'; }, 200);
                }
            }
        });
    </script>
</body>
</html>

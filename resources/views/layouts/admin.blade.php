@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Toon Burger')</title>

    <!-- Google Fonts: Luckiest Guy & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        toon: {
                            granite: '#466967',
                            'granite-dark': '#344E4C',
                            'granite-light': '#59807E',
                            wheat: '#F1D9B3',
                            'wheat-light': '#FDF8F0',
                            rust: '#C1502D',
                            'rust-dark': '#A33E20',
                            cream: '#FAF1E1',
                            'cream-dark': '#EFE4D0',
                            dark: '#263A38',
                            slate: '#4B5563',
                        },
                        bites: {
                            yellow: '#466967',
                            'yellow-dark': '#344E4C',
                            orange: '#F1D9B3',
                            red: '#C1502D',
                            dark: '#263A38',
                            bg: '#FAF1E1',
                        }
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        luckiest: ['"Luckiest Guy"', 'cursive'],
                        courier: ['"Courier New"', 'Courier', 'monospace'],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #FAF1E1;
            color: #263A38;
            animation: pageEnter 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transition: opacity 0.22s cubic-bezier(0.16, 1, 0.3, 1), transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .font-brand {
            font-family: 'Luckiest Guy', cursive;
            letter-spacing: 0.05em;
        }
        .font-mono-code {
            font-family: 'Courier New', Courier, monospace;
        }
        body.page-exiting {
            opacity: 0 !important;
            transform: translateY(-4px) scale(0.995);
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
            transform-origin: left;
            transform: scaleX(0);
            background: linear-gradient(90deg, #466967, #F1D9B3, #C1502D);
            z-index: 99999;
            transition: transform 0.35s ease, opacity 0.3s ease;
            pointer-events: none;
            box-shadow: 0 0 10px rgba(70, 105, 103, 0.6);
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }
        ::-webkit-scrollbar-track {
            background: #FAF1E1;
        }
        ::-webkit-scrollbar-thumb {
            background: #D5CBB9;
            border-radius: 999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #466967;
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
    </style>
</head>
<body class="min-h-screen bg-[#FAF1E1] text-[#263A38] antialiased p-3 sm:p-5 lg:p-6 flex flex-col md:flex-row gap-5 lg:gap-6">
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

    <!-- MOBILE SIDEBAR BACKDROP -->
    <div id="admin-sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- ═══ SIDEBAR: CARD ACCORDING TO MOCKUP ═══ -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 sm:w-68 lg:w-[265px] bg-white text-gray-800 rounded-3xl border border-[#E6DEC8] shadow-xs flex flex-col justify-between p-5 lg:p-6 flex-shrink-0 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:flex md:self-start md:sticky md:top-6 md:min-h-[calc(100vh-3rem)] overflow-y-auto">
        <div class="space-y-6">
            <!-- Logo Section with Mascot + TOON BURGER text -->
            <div class="pb-5 border-b border-gray-100 flex items-center justify-between md:justify-center relative">
                <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center group py-1 text-center w-full">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger" class="h-24 sm:h-28 w-auto object-contain drop-shadow-xs transition group-hover:scale-105">
                </a>
                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden absolute right-1 top-1 text-gray-400 hover:text-gray-700 p-1.5 rounded-xl hover:bg-gray-100 transition" aria-label="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Primary Navigation Links (Ordered exactly as mockup) -->
            <nav class="space-y-2.5 text-sm font-medium">
                
                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ request()->routeIs('admin.dashboard') ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 20h18"/>
                        <path d="M7 20v-5"/>
                        <path d="M12 20v-9"/>
                        <path d="M17 20v-13"/>
                        <path d="M4 14l5-4 4 3 6-6"/>
                        <circle cx="9" cy="10" r="1.3" fill="currentColor"/>
                        <circle cx="13" cy="13" r="1.3" fill="currentColor"/>
                        <circle cx="19" cy="7" r="1.3" fill="currentColor"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Profil Admin -->
                <a href="{{ route('admin.profile') }}" 
                   class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ request()->routeIs('admin.profile') ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M5.5 20c0-3.5 2.9-6.2 6.5-6.2s6.5 2.7 6.5 6.2"/>
                    </svg>
                    <span>Profil Admin</span>
                </a>

                <!-- 3. proses Pesanan -->
                <a href="{{ route('admin.orders') }}" 
                   class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ request()->routeIs('admin.orders*') ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 3v4a1 1 0 001 1h4"/>
                        <path d="M17 21H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"/>
                        <path d="M9 13h6M9 17h4"/>
                    </svg>
                    <span>proses Pesanan</span>
                </a>

                <!-- 4. Data Produk -->
                <a href="{{ route('admin.products') }}" 
                   class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ request()->routeIs('admin.products*') ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 11a8 8 0 0 1 16 0H4z"/>
                        <path d="M3 14h18"/>
                        <path d="M5 18a7 7 0 0 0 14 0H5z"/>
                        <path d="M8 8h.01M12 7h.01M16 8h.01"/>
                    </svg>
                    <span>Data Produk</span>
                </a>

                <!-- 5. Kategori Produk -->
                <a href="{{ route('admin.categories') }}" 
                   class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ request()->routeIs('admin.categories*') ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kategori Produk</span>
                </a>
            </nav>
        </div>

        <!-- Secondary Bottom Section with Divider line -->
        <div class="pt-5 border-t border-gray-100 mt-6 space-y-2 text-sm font-medium">
            <!-- Pengaturan -->
            <a href="{{ route('admin.coupons') }}" 
               class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full {{ (request()->routeIs('admin.coupons*') || request()->routeIs('admin.tables*') || request()->routeIs('admin.settings*')) ? 'bg-[#3D5A58] text-white font-medium shadow-xs' : 'text-gray-700 hover:bg-gray-100/80 hover:text-gray-900' }}">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                <span>Pengaturan</span>
            </a>

            <!-- Beranda -->
            <a href="{{ route('home') }}" 
               class="flex items-center gap-3.5 px-4.5 py-3 transition rounded-full text-gray-700 hover:bg-gray-100/80 hover:text-gray-900">
                <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 10.5L12 3l9 7.5V20a1.5 1.5 0 01-1.5 1.5h-5a1 1 0 01-1-1v-5h-4v5a1 1 0 01-1 1h-5A1.5 1.5 0 013 20V10.5z"/>
                </svg>
                <span>Beranda</span>
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout(event)" class="w-full pt-0.5">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3.5 px-4.5 py-3 text-[#C1502D] hover:bg-red-50/80 rounded-full transition font-medium group">
                    <svg class="w-5 h-5 flex-shrink-0 text-[#C1502D] transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ═══ MAIN WRAPPER ═══ -->
    <div class="flex-1 flex flex-col gap-5 lg:gap-6 min-w-0">
        
        <!-- Top Navbar: Rounded Card with Search Bar & Profile (Mockup Matching) -->
        <header class="bg-white rounded-2xl sm:rounded-3xl border border-[#E6DEC8] shadow-xs px-5 sm:px-6 py-3.5 flex items-center justify-between gap-4">
            
            <!-- Left on Mobile: Hamburger -->
            <button type="button" onclick="toggleAdminSidebar()" class="md:hidden p-2 text-toon-granite hover:bg-toon-cream rounded-xl transition active:scale-95 focus:outline-none shrink-0" aria-label="Buka Menu Admin">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Search Bar: Pill Input with Dark Green Circle Search Button -->
            <div class="flex-1 max-w-xl">
                <form action="{{ route('admin.orders') }}" method="GET" class="w-full bg-[#F3F4F6] hover:bg-gray-100/90 border border-gray-200/60 rounded-full pl-5 pr-1.5 py-1.5 flex items-center justify-between transition focus-within:ring-2 focus-within:ring-toon-granite/20 focus-within:bg-white focus-within:border-toon-granite">
                    <input type="text" name="q" id="global-admin-search" placeholder="Cari sesuatu..." class="bg-transparent text-xs text-gray-800 placeholder-gray-400 outline-none w-full pr-3 font-medium">
                    <button type="submit" class="w-8 h-8 rounded-full bg-toon-granite hover:bg-toon-granite-dark text-white flex items-center justify-center shrink-0 shadow-2xs transition active:scale-95" title="Cari">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right Profile: Orange Avatar Circle 'Tb' + Name + Email (No Notification Bell) -->
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 shrink-0 group select-none">
                <div class="w-10 h-10 rounded-full bg-[#F59E0B] text-white flex items-center justify-center font-bold text-sm shadow-xs shrink-0 group-hover:scale-105 transition">
                    Tb
                </div>
                <div class="text-left leading-tight hidden sm:block">
                    <div class="font-extrabold text-xs text-gray-900 leading-tight">Toon Burger</div>
                    <div class="text-[11px] text-gray-400 mt-0.5">Toonburger@gmail.com</div>
                </div>
            </a>
        </header>

        <!-- Flash alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex justify-between items-center shadow-xs">
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
            <div class="p-4 bg-red-50 border border-red-200 text-toon-rust text-xs font-bold rounded-2xl flex justify-between items-center shadow-xs">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-toon-rust shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </span>
                <button onclick="this.parentElement.remove()" class="text-toon-rust text-base font-bold">&times;</button>
            </div>
        @endif

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 min-w-0">
            @yield('admin_content')
        </main>
    </div>

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

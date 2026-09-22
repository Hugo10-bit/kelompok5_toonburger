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
            width: 0%;
            background: linear-gradient(90deg, #466967, #F1D9B3, #C1502D);
            z-index: 99999;
            transition: width 0.35s ease, opacity 0.3s ease;
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
    </style>
</head>
<body class="min-h-full flex antialiased">
    <div id="page-loader-bar"></div>

    <!-- MOBILE SIDEBAR BACKDROP -->
    <div id="admin-sidebar-backdrop" onclick="toggleAdminSidebar()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-40 hidden md:hidden transition-opacity duration-300"></div>

    <!-- SIDEBAR -->
    <aside id="admin-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white text-gray-800 border-r border-[#E6DEC8] flex flex-col justify-between flex-shrink-0 min-h-screen -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:static md:flex shadow-2xl md:shadow-sm">
        <div>
            <!-- Logo Section -->
            <div class="p-5 border-b border-[#EFE5D0] flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger Logo" class="h-11 w-11 object-contain drop-shadow-xs transition group-hover:scale-105">
                    <div>
                        <span class="font-brand text-xl text-toon-granite block tracking-wide leading-none">TOON BURGER</span>
                        <span class="text-[9px] font-extrabold uppercase tracking-widest text-gray-400 block mt-0.5">Admin Dashboard</span>
                    </div>
                </a>
                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden text-gray-400 hover:text-gray-700 p-1.5 rounded-xl hover:bg-gray-100 transition" aria-label="Tutup Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1.5 text-xs font-semibold">
                
                <!-- 1. Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Proses Pesanan -->
                <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs('admin.orders') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Proses Pesanan</span>
                </a>

                <!-- 3. Data Produk -->
                <a href="{{ route('admin.products') }}" class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs('admin.products') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Data Produk</span>
                </a>

                <!-- 4. Kategori Produk -->
                <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs('admin.categories') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Kategori Produk</span>
                </a>

                <!-- 5. Profil Admin -->
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 transition {{ request()->routeIs('admin.profile') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Profil Admin</span>
                </a>

                <!-- Divider & Extra Operations -->
                <div class="pt-3 pb-1">
                    <span class="px-4 text-[10px] font-extrabold uppercase tracking-wider text-gray-400 block">Operasional</span>
                </div>

                <a href="{{ route('admin.pos') }}" class="flex items-center gap-3 px-4 py-2.5 transition {{ request()->routeIs('admin.pos') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>Kasir / POS</span>
                </a>

                <a href="{{ route('admin.tables') }}" class="flex items-center gap-3 px-4 py-2.5 transition {{ request()->routeIs('admin.tables') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>Meja Restoran</span>
                </a>

                <a href="{{ route('admin.coupons') }}" class="flex items-center gap-3 px-4 py-2.5 transition {{ request()->routeIs('admin.coupons') ? 'bg-toon-granite text-white font-bold shadow-md shadow-toon-granite/20 rounded-full' : 'text-gray-600 hover:bg-toon-cream hover:text-toon-granite rounded-full' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kupon Promo</span>
                </a>

            </nav>
        </div>

        <!-- Bottom User Box & Logout -->
        <div class="p-4 border-t border-[#EFE5D0] text-xs">
            <!-- User Mini Profile -->
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 mb-3 p-2 rounded-2xl hover:bg-toon-cream/60 transition group">
                <div class="w-9 h-9 rounded-full bg-toon-wheat text-toon-granite flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-xs group-hover:scale-105 transition">
                    TB
                </div>
                <div class="truncate">
                    <div class="font-bold text-gray-900 truncate leading-tight">{{ Auth::user()->name ?? 'Toon Burger' }}</div>
                    <div class="text-[10px] text-gray-400 truncate">{{ Auth::user()->email ?? 'admin@toonburger.com' }}</div>
                </div>
            </a>

            <!-- Action Buttons -->
            <div class="space-y-1.5">
                <a href="{{ route('menu') }}" class="block text-center py-2 px-3 rounded-full text-[11px] font-bold text-toon-granite bg-toon-cream hover:bg-toon-wheat transition">
                    &larr; Lihat Menu Resto
                </a>
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirmLogout(event)">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-full text-[11px] font-bold text-toon-rust bg-red-50 hover:bg-red-100 border border-red-200/70 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar / Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MAIN WRAPPER -->
    <div class="flex-1 flex flex-col min-w-0 bg-[#FAF1E1]">
        
        <!-- Top Navbar (Desktop & Mobile) -->
        <header class="bg-white border-b border-[#E6DEC8] px-5 py-3 sticky top-0 z-30 shadow-xs flex items-center justify-between gap-4">
            <!-- Left on Mobile: Hamburger -->
            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleAdminSidebar()" class="md:hidden p-2 text-toon-granite hover:bg-toon-cream rounded-xl transition active:scale-95 focus:outline-none" aria-label="Buka Menu Admin">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="md:hidden flex items-center gap-2">
                    <img src="{{ asset('images/toonburger-logo.png') }}" alt="Toon Burger" class="h-8 w-8 object-contain">
                    <span class="font-brand text-toon-granite text-lg">TOON BURGER</span>
                </div>
            </div>

            <!-- Centered Search Bar (Desktop) -->
            <div class="hidden md:flex flex-1 max-w-md mx-auto">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" id="global-admin-search" placeholder="Cari menu, nomor pesanan, kategori..." class="w-full pl-10 pr-4 py-2 text-xs bg-gray-50/80 hover:bg-gray-50 focus:bg-white border border-gray-200 rounded-full focus:outline-none focus:border-toon-granite focus:ring-1 focus:ring-toon-granite transition placeholder-gray-400">
                </div>
            </div>

            <!-- Right Profile & Fast Actions -->
            <div class="flex items-center gap-3">
                <!-- Notifications -->
                <button type="button" class="p-2 text-gray-500 hover:text-toon-granite hover:bg-toon-cream rounded-full transition relative" title="Notifikasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-toon-rust rounded-full"></span>
                </button>

                <!-- Profile Dropdown Trigger / Info -->
                <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 py-1 px-2 rounded-full hover:bg-toon-cream transition">
                    <div class="w-8 h-8 rounded-full bg-toon-wheat text-toon-granite flex items-center justify-center font-bold text-xs shadow-xs">
                        TB
                    </div>
                    <div class="hidden sm:block text-left text-xs">
                        <div class="font-bold text-gray-900 leading-tight">Toon Burger</div>
                        <div class="text-[10px] text-gray-400">Administrator</div>
                    </div>
                </a>
            </div>
        </header>

        <!-- Flash alerts -->
        @if(session('success'))
            <div class="mx-6 mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex justify-between items-center shadow-xs">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 text-base font-bold">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 mt-4 p-4 bg-red-50 border border-red-200 text-toon-rust text-xs font-bold rounded-2xl flex justify-between items-center shadow-xs">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-toon-rust" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </span>
                <button onclick="this.parentElement.remove()" class="text-toon-rust text-base font-bold">&times;</button>
            </div>
        @endif

        <!-- MAIN CONTENT AREA -->
        <main class="p-5 sm:p-8 flex-1 overflow-y-auto">
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

        function confirmLogout(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: 'Apakah Anda yakin ingin keluar dari Admin Panel Toon Burger?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#C1502D',
                    cancelButtonColor: '#466967',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-2xl font-sans',
                        confirmButton: 'rounded-full px-5 py-2.5 font-bold',
                        cancelButton: 'rounded-full px-5 py-2.5 font-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            } else {
                if (confirm('Apakah Anda yakin ingin keluar dari Admin Panel Toon Burger?')) {
                    form.submit();
                }
            }
            return false;
        }

        // Smooth Page Transition Handler
        document.addEventListener('DOMContentLoaded', () => {
            const loader = document.getElementById('page-loader-bar');
            if (loader) {
                loader.style.width = '100%';
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
                        loader.style.width = '70%';
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
                    loader.style.width = '100%';
                    setTimeout(() => { loader.style.opacity = '0'; loader.style.width = '0%'; }, 200);
                }
            }
        });
    </script>
</body>
</html>

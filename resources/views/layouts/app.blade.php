<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#3B6E64">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Toon Burger">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    @if(request()->routeIs('welcome', 'home', 'menu*'))
    <link rel="preload" as="image" href="{{ asset('images/hero-burger.png') }}" fetchpriority="high">
    @endif
    <title>@yield('title', 'Toon Burger - Smash Burger & Takeaway Hub')</title>

    <!-- Google Fonts: BBH Hegarty + Bebas Neue + Poppins + Roboto + Nunito + Luckiest Guy -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=BBH+Hegarty&family=Bebas+Neue&family=Luckiest+Guy&family=Nunito:wght@900&family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
    $isStoreOpen = $storeSetting->is_open ?? true;
    $closedReason = method_exists($storeSetting, 'displayReason') ? $storeSetting->displayReason() : 'Jam Tutup';
@endphp
<body class="min-h-full bg-bites-bg text-gray-900 flex flex-col antialiased"
      data-authenticated="{{ auth()->check() ? 'true' : 'false' }}"
      data-store-open="{{ $isStoreOpen ? 'true' : 'false' }}"
      data-store-closed-reason="{{ $closedReason }}"
      data-login-url="{{ route('login') }}"
      data-logout-url="{{ route('logout') }}"
      data-cart-index-url="{{ route('cart.index') }}"
      data-cart-add-url="{{ route('cart.add') }}"
      data-cart-update-url="{{ route('cart.update') }}"
      data-cart-remove-url="{{ route('cart.remove') }}"
      data-menu-url="{{ route('menu') }}"
      data-menu-search-url="{{ route('menu.search.live') }}"
      data-empty-cart-img="{{ asset('images/empty-cart.png') }}"
      data-toon-head-img="{{ asset('images/toon-head.png') }}"
      data-logo-img="{{ asset('images/logo.png') }}">

    <!-- Modal Konfirmasi Logout -->
    <div id="logout-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4"
         style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; width: 100vw; height: 100vh; margin: 0; z-index: 999999; align-items: center; justify-content: center;">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-[3px] transition-opacity duration-200"
             style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;"
             onclick="closeLogoutModal()"></div>

        <div class="relative bg-white rounded-[28px] sm:rounded-[32px] shadow-2xl p-8 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 mx-auto my-auto">
            <div class="w-28 h-28 sm:w-[124px] sm:h-[124px] rounded-full border-[6.5px] sm:border-[7.5px] border-[#D46161] flex items-center justify-center mx-auto mb-6 bg-white shrink-0">
                <svg class="w-11 h-11 sm:w-12 sm:h-12 text-[#D46161]" viewBox="0 0 32 32" fill="currentColor">
                    <path d="M16 5.5c-1.38 0-2.5 1.05-2.4 2.43l.8 12.14c.08 1.15 1.03 2.05 2.18 2.05s2.1-.9 2.18-2.05l.8-12.14c.1-1.38-1.02-2.43-2.4-2.43zm0 19.38a2.56 2.56 0 100 5.12 2.56 2.56 0 000-5.12z"/>
                </svg>
            </div>

            <h3 data-i18n-app="logout_title" class="text-2xl sm:text-[27px] font-bold text-[#2D3139] tracking-tight mb-2.5">
                Konfirmasi Logout
            </h3>

            <p data-i18n-app="logout_desc" class="text-[#555C68] text-sm sm:text-[14px] leading-relaxed max-w-xs mx-auto mb-7 font-normal">
                Apakah Anda yakin ingin keluar dari akun? Anda perlu login kembali untuk mengakses halaman admin.
            </p>

            <div class="flex items-center justify-center gap-3.5">
                <button type="button"
                        onclick="closeLogoutModal()"
                        class="bg-white hover:bg-gray-50 active:scale-95 text-[#2D3139] border border-[#6B7280] rounded-xl px-7 py-2.5 text-sm font-medium transition min-w-[124px] focus:outline-none cursor-pointer">
                    <span data-i18n-app="logout_cancel">Batalkan</span>
                </button>
                <button type="button"
                        id="modal-logout-submit-btn"
                        onclick="submitLogoutForm()"
                        class="bg-[#B73535] hover:bg-[#9E2A2A] active:scale-95 text-white rounded-xl px-7 py-2.5 text-sm font-medium transition min-w-[124px] shadow-xs focus:outline-none cursor-pointer flex items-center justify-center">
                    <span data-i18n-app="logout_confirm">Ya, Logout</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Global Hidden Form for Logout -->
    <form id="global-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <!-- Navbar -->
    <header class="sticky top-0 z-50 px-2 sm:px-6 lg:px-8 pt-2.5 sm:pt-4 pb-2 select-none font-roboto">
        <div class="w-full max-w-[1440px] xl:max-w-[1520px] mx-auto relative">
            <div class="flex items-center justify-between px-3.5 sm:px-7 lg:px-8 py-2 sm:py-3 rounded-full border border-black/70 transition-all duration-300 relative shadow-[0_10px_30px_-5px_rgba(0,0,0,0.25)] backdrop-blur-xs"
                 style="background-color: rgba(0, 0, 0, 0.25); -webkit-backdrop-filter: blur(8px); backdrop-filter: blur(8px);">

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
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm font-roboto">
                    <a href="{{ route('home') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-roboto font-medium
                              {{ request()->routeIs('home', 'welcome') || request()->is('/') || request()->is('home') ? 'bg-white/20 text-white shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span data-i18n-app="nav_home">Beranda</span>
                    </a>
                    <a href="{{ route('menu') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-roboto font-medium
                              {{ request()->routeIs('menu*') || request()->is('menu*') ? 'bg-white/20 text-white shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span data-i18n-app="nav_menu">Menu</span>
                    </a>
                    <a href="{{ route('about') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-roboto font-medium
                              {{ request()->routeIs('about') || request()->is('about') ? 'bg-white/20 text-white shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span data-i18n-app="nav_about">Tentang</span>
                    </a>
                    <a href="{{ route('contact') }}" data-page-transition
                       class="px-4 py-1.5 rounded-full transition text-sm font-roboto font-medium
                              {{ request()->routeIs('contact') || request()->is('contact') ? 'bg-white/20 text-white shadow-xs' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <span data-i18n-app="nav_contact">Kontak</span>
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
                               data-i18n-app-attr="placeholder:nav_search_placeholder"
                               autocomplete="off"
                               class="nav-search-input bg-transparent border-0 text-xs sm:text-sm text-gray-800 placeholder-gray-400 outline-none focus:outline-none focus:ring-0 w-full font-normal">
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
                            <span data-i18n-app="nav_search_searching">Mencari menu...</span>
                        </div>
                        <div id="home-search-content"></div>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                    <!-- Cart drawer button -->
                    <button type="button"
                            onclick="toggleCartDrawer()"
                            id="cart-btn"
                            class="relative w-10 h-10 rounded-full bg-white/15 hover:bg-white/25 border border-white/20 flex items-center justify-center text-black shadow-xs transition active:scale-95 focus:outline-none cursor-pointer shrink-0"
                            aria-label="Keranjang Belanja">
                        <svg class="w-5 h-5 text-black" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M27.7188 8.28125C27.5312 8.09375 27.2917 8 27 8H22C21.9583 6.29167 21.375 4.875 20.25 3.75C18.5625 2.0625 17.7094 2.04062 16 2C14.2917 2.04167 12.875 2.625 11.75 3.75C10.0625 5.4375 10.0406 6.29063 10 8H5C4.70833 8 4.46875 8.09375 4.28125 8.28125C4.09375 8.46875 4 8.70833 4 9V29C4 29.2917 4.09375 29.5312 4.28125 29.7188C4.5625 30 4.70938 30 5 30H27C27.2917 30 27.5312 29.9062 27.7188 29.7188C28 29.4375 28 29.2906 28 29V9C28 8.70833 27.9062 8.46875 27.7188 8.28125ZM13.1719 5.17188C13.5412 4.79762 13.9817 4.50111 14.4674 4.29984C14.9531 4.09857 15.4742 3.99662 16 4C17.125 4.02083 18.0677 4.41146 18.8281 5.17188C19.9688 6.3125 19.9781 6.875 20 8H12C12.0208 6.875 12.4115 5.93229 13.1719 5.17188ZM26 28H6V10H10V14H12V10H20V14H22V10H26V28Z" fill="black"/>
                        </svg>
                        <span id="cart-badge"
                              class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 rounded-full bg-[#DE3B28] text-white text-[10.5px] font-extrabold flex items-center justify-center border-2 border-white leading-none shadow-xs">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                        </span>
                    </button>

                    <!-- Desktop language selector (between Cart and Profile/Login) -->
                    <div class="relative select-none hidden lg:block" id="nav-lang-container">
                        <button type="button"
                                id="nav-lang-btn"
                                onclick="toggleNavLangDropdown(event)"
                                aria-haspopup="true"
                                aria-expanded="false"
                                aria-label="Pilih Bahasa"
                                class="h-10 px-2.5 sm:px-3 rounded-full bg-white/15 hover:bg-white/25 border border-white/20 text-white text-xs font-semibold inline-flex items-center gap-1.5 shadow-xs transition active:scale-95 cursor-pointer shrink-0">
                            <span id="nav-lang-flag" class="w-5 h-5 rounded-full overflow-hidden inline-flex items-center justify-center border border-white/30 shrink-0" aria-hidden="true">
                                <svg class="w-full h-full" viewBox="0 0 64 64">
                                    <clipPath id="circle-flag-nav-btn-init"><circle cx="32" cy="32" r="32"/></clipPath>
                                    <g clip-path="url(#circle-flag-nav-btn-init)">
                                        <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                        <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                    </g>
                                </svg>
                            </span>
                            <span id="nav-lang-code" class="tracking-wide">ID</span>
                            <svg id="nav-lang-chevron" class="w-3.5 h-3.5 text-white/80 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="nav-lang-dropdown" class="hidden absolute right-0 top-full mt-2.5 w-44 bg-white rounded-2xl border border-gray-200/90 shadow-2xl p-2 z-50 animate-modal-pop">
                            <button type="button" onclick="selectNavLanguage('ID')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-gray-800 hover:bg-gray-100 transition cursor-pointer">
                                <span class="flex items-center gap-2.5">
                                    <span class="w-5 h-5 rounded-full overflow-hidden inline-flex items-center justify-center border border-gray-200 shrink-0" aria-hidden="true">
                                        <svg class="w-full h-full" viewBox="0 0 64 64">
                                            <clipPath id="circle-flag-nav-dd-id"><circle cx="32" cy="32" r="32"/></clipPath>
                                            <g clip-path="url(#circle-flag-nav-dd-id)">
                                                <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                                <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                            </g>
                                        </svg>
                                    </span>
                                    <span>Indonesia</span>
                                </span>
                                <svg id="nav-lang-check-id" class="w-4 h-4 text-[#27443E]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </button>
                            <button type="button" onclick="selectNavLanguage('EN')" class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium text-gray-800 hover:bg-gray-100 transition mt-1 cursor-pointer">
                                <span class="flex items-center gap-2.5">
                                    <span class="w-5 h-5 rounded-full overflow-hidden inline-flex items-center justify-center border border-gray-200 shrink-0" aria-hidden="true">
                                        <svg class="w-full h-full" viewBox="0 0 64 64">
                                            <clipPath id="circle-flag-nav-dd-us"><circle cx="32" cy="32" r="32"/></clipPath>
                                            <g clip-path="url(#circle-flag-nav-dd-us)">
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
                                <svg id="nav-lang-check-en" class="w-4 h-4 text-[#27443E] hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                    </div>

                    @auth
                        @php $navUserInitials = strtoupper(substr(Auth::user()->name ?? 'Tb', 0, 2)); @endphp
                        <input type="file"
                               id="navbar-avatar-input"
                               accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                               data-upload-url="{{ route('profile.avatar.update') }}"
                               class="hidden"
                               onchange="handleNavbarAvatarChange(this)">
                        <!-- User profile dropdown -->
                        <div class="relative" id="user-dropdown-container">
                            <button type="button"
                                    onclick="toggleUserDropdown(event)"
                                    id="user-menu-button"
                                    class="flex items-center gap-2.5 cursor-pointer group focus:outline-none text-left select-none">
                                <div data-user-avatar-slot
                                     data-user-initials="{{ $navUserInitials }}"
                                     class="w-10 h-10 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition shrink-0 overflow-hidden">
                                    @if(!empty(Auth::user()->avatar))
                                        <img src="{{ Auth::user()->avatar_url }}"
                                             alt="Avatar"
                                             class="w-full h-full object-cover">
                                    @else
                                        {{ $navUserInitials }}
                                    @endif
                                </div>
                                <div class="text-left leading-tight hidden xl:block">
                                    <div data-user-name-slot class="font-bold text-sm text-white leading-tight">
                                        {{ Auth::user()->name }}
                                    </div>
                                    <div data-user-email-slot class="text-xs text-white/70 font-normal leading-tight mt-0.5 truncate max-w-[140px]">
                                        {{ Auth::user()->email }}
                                    </div>
                                </div>
                                <svg id="user-menu-arrow" class="w-4 h-4 text-white/80 stroke-[2] transition-transform duration-200 hidden sm:block shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="user-dropdown-menu" class="hidden absolute right-0 mt-2.5 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 p-3 z-50 animate-modal-pop">
                                <div class="px-2 py-2 border-b border-gray-100 pb-3 mb-2 flex items-center gap-3">
                                    <button type="button"
                                            onclick="triggerNavbarAvatarPicker(event)"
                                            title="Ubah Foto Profil"
                                            aria-label="Ubah Foto Profil"
                                            class="relative shrink-0 group cursor-pointer focus:outline-none">
                                        <div data-user-avatar-slot
                                             data-user-initials="{{ $navUserInitials }}"
                                             class="w-11 h-11 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm overflow-hidden shadow-xs">
                                            @if(!empty(Auth::user()->avatar))
                                                <img src="{{ Auth::user()->avatar_url }}"
                                                     alt="Avatar"
                                                     class="w-full h-full object-cover">
                                            @else
                                                {{ $navUserInitials }}
                                            @endif
                                        </div>
                                        <span class="w-5 h-5 rounded-full bg-[#D1D5DB] group-hover:bg-[#BFC5CE] border-2 border-white flex items-center justify-center text-gray-700 absolute -bottom-0.5 -right-0.5 shadow-2xs transition group-active:scale-95">
                                            <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                            </svg>
                                        </span>
                                    </button>
                                    <div class="min-w-0 flex-1">
                                        <div data-user-name-slot class="font-bold text-xs text-gray-900 truncate">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div data-user-email-slot class="text-[11px] text-gray-400 truncate">
                                            {{ Auth::user()->email }}
                                        </div>
                                        <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#E8F8F0] text-[#10B981] capitalize">
                                            {{ Auth::user()->role }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-1 text-xs font-roboto font-medium text-gray-700">
                                    <a href="{{ route('orders.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <span data-i18n-app="nav_orders">Pesanan Saya</span>
                                    </a>

                                    @if(!Auth::user()->isAdmin() && !Auth::user()->isStaff())
                                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span data-i18n-app="nav_profile">Profil</span>
                                        </a>
                                    @endif

                                    <button type="button"
                                            id="profile-lang-toggle-btn"
                                            onclick="toggleAppLanguage(event)"
                                            aria-label="Ganti Bahasa"
                                            class="lg:hidden w-full flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition text-left cursor-pointer">
                                        <span id="profile-lang-flag" class="w-4 h-4 rounded-full overflow-hidden inline-flex items-center justify-center border border-gray-200 shrink-0 pointer-events-none" aria-hidden="true">
                                            <svg class="w-full h-full" viewBox="0 0 64 64">
                                                <clipPath id="circle-flag-profile-dd-init"><circle cx="32" cy="32" r="32"/></clipPath>
                                                <g clip-path="url(#circle-flag-profile-dd-init)">
                                                    <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                                    <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                                </g>
                                            </svg>
                                        </span>
                                        <span id="profile-lang-label">Indonesia</span>
                                    </button>

                                    @if(Auth::user()->isAdmin() || Auth::user()->isStaff())
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl hover:bg-gray-100 transition text-[#3b6e64] font-medium">
                                            <svg class="w-4 h-4 text-[#3b6e64]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                            <span data-i18n-app="nav_admin">Dashboard Admin</span>
                                        </a>
                                    @endif
                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <button type="button" onclick="confirmLogout(event)" class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-red-600 hover:bg-red-50 text-xs font-medium transition">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            <span data-i18n-app="nav_logout">Logout</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center gap-2.5 sm:gap-3 text-xs sm:text-sm font-roboto font-medium shrink-0 select-none">
                            <a href="{{ route('login') }}" class="text-white hover:text-white/80 transition px-2 py-1 font-medium">
                                <span data-i18n-app="nav_login">Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="bg-[#F5A623] hover:bg-[#E0961F] active:scale-95 text-slate-900 font-medium px-4 py-1.5 rounded-xl transition shadow-xs">
                                <span data-i18n-app="nav_signin">Sign In</span>
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
            <div id="mobile-nav-menu" class="hidden lg:hidden absolute top-full left-0 right-0 z-[60] mt-2.5 rounded-2xl overflow-hidden shadow-2xl p-3 border border-gray-200 bg-white text-gray-800 font-roboto">
                <div class="flex flex-col text-sm font-roboto font-medium">
                    @auth
                        <!-- Compact Profile Info inside Mobile Menu -->
                        <div class="px-3.5 py-3 mb-2.5 rounded-xl bg-gray-50 border border-gray-100 flex items-center gap-3">
                            <button type="button"
                                    onclick="triggerNavbarAvatarPicker(event)"
                                    title="Ubah Foto Profil"
                                    aria-label="Ubah Foto Profil"
                                    class="relative shrink-0 group cursor-pointer focus:outline-none">
                                <div data-user-avatar-slot
                                     data-user-initials="{{ $navUserInitials }}"
                                     class="w-11 h-11 rounded-full bg-[#FFA000] text-white flex items-center justify-center font-bold text-sm overflow-hidden shadow-xs">
                                    @if(!empty(Auth::user()->avatar))
                                        <img src="{{ Auth::user()->avatar_url }}"
                                             alt="Avatar"
                                             class="w-full h-full object-cover">
                                    @else
                                        {{ $navUserInitials }}
                                    @endif
                                </div>
                                <span class="w-5 h-5 rounded-full bg-[#D1D5DB] group-hover:bg-[#BFC5CE] border-2 border-gray-50 flex items-center justify-center text-gray-700 absolute -bottom-0.5 -right-0.5 shadow-2xs transition group-active:scale-95">
                                    <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="min-w-0 flex-1 leading-tight">
                                <div data-user-name-slot class="font-bold text-xs sm:text-sm text-gray-900 truncate">
                                    {{ Auth::user()->name }}
                                </div>
                                <div data-user-email-slot class="text-[11px] text-gray-500 truncate">
                                    {{ Auth::user()->email }}
                                </div>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-[#E8F8F0] text-[#10B981] capitalize">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>
                    @endauth

                    <!-- Mobile Search -->
                    <div class="mb-2.5">
                        <form action="{{ route('menu') }}" method="GET" class="w-full bg-[#F5F6FA] rounded-full px-4 py-2 flex items-center gap-2.5 shadow-2xs">
                            <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text"
                                   name="q"
                                   placeholder="Cheese Burger..."
                                   data-i18n-app-attr="placeholder:nav_search_placeholder"
                                   class="nav-search-input bg-transparent border-0 text-xs text-gray-800 placeholder-gray-400 outline-none focus:outline-none focus:ring-0 w-full font-normal">
                        </form>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('home') }}" data-page-transition onclick="closeMobileNav(true)"
                           class="block px-4 py-2 rounded-xl transition font-roboto font-medium
                                            {{ request()->routeIs('home', 'welcome') || request()->is('/') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                            <span data-i18n-app="nav_home">Beranda</span>
                        </a>
                        <a href="{{ route('menu') }}" data-page-transition onclick="closeMobileNav(true)"
                           class="block px-4 py-2 rounded-xl transition font-roboto font-medium
                                            {{ request()->routeIs('menu*') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                            <span data-i18n-app="nav_menu">Menu</span>
                        </a>
                        <a href="{{ route('about') }}" data-page-transition onclick="closeMobileNav(true)"
                           class="block px-4 py-2 rounded-xl transition font-roboto font-medium
                                            {{ request()->routeIs('about') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                            <span data-i18n-app="nav_about">Tentang</span>
                        </a>
                        <a href="{{ route('contact') }}" data-page-transition onclick="closeMobileNav(true)"
                           class="block px-4 py-2 rounded-xl transition font-roboto font-medium
                                            {{ request()->routeIs('contact') ? 'bg-[#3b6e64]/10 text-[#3b6e64]' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
                            <span data-i18n-app="nav_contact">Kontak</span>
                        </a>
                        @guest
                            <!-- Guest mobile language switch item -->
                            <button type="button"
                                    id="mobile-lang-toggle-btn"
                                    onclick="toggleAppLanguage(event)"
                                    aria-label="Ganti Bahasa"
                                    class="w-full flex items-center gap-2.5 px-4 py-2 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 transition font-roboto font-medium text-left cursor-pointer">
                                <span id="mobile-lang-flag" class="w-4 h-4 rounded-full overflow-hidden inline-flex items-center justify-center border border-gray-200 shrink-0 pointer-events-none" aria-hidden="true">
                                    <svg class="w-full h-full" viewBox="0 0 64 64">
                                        <clipPath id="circle-flag-mobile-dd-init"><circle cx="32" cy="32" r="32"/></clipPath>
                                        <g clip-path="url(#circle-flag-mobile-dd-init)">
                                            <path fill="#E11B22" d="M0 0h64v32H0z"/>
                                            <path fill="#FFFFFF" d="M0 32h64v32H0z"/>
                                        </g>
                                    </svg>
                                </span>
                                <span id="mobile-lang-label">Indonesia</span>
                            </button>
                        @endguest
                    </div>

                    @guest
                        <div class="mt-2.5 pt-2.5 border-t border-gray-100 flex items-center gap-2 font-roboto font-medium">
                            <a href="{{ route('login') }}" onclick="closeMobileNav(true)"
                               class="flex-1 text-center min-h-[40px] inline-flex items-center justify-center px-3 py-2 rounded-xl border border-gray-300 text-gray-800 hover:bg-gray-50 text-xs font-roboto font-medium transition">
                                <span data-i18n-app="nav_login">Login</span>
                            </a>
                            <a href="{{ route('register') }}" onclick="closeMobileNav(true)"
                               class="flex-1 text-center min-h-[40px] inline-flex items-center justify-center px-3 py-2 rounded-xl bg-[#F5A623] hover:bg-[#E0961F] text-slate-900 text-xs font-roboto font-medium transition shadow-xs">
                                <span data-i18n-app="nav_signin">Sign In</span>
                            </a>
                        </div>
                    @endguest
                </div>
            </div>
    </div>
</header>




    <!-- FLASH MESSAGES -->
    @if(session('warning'))
        <div class="alert-auto-dismiss max-w-7xl mx-auto px-4 mt-4 w-full" role="alert">
            <div class="bg-amber-50 border border-amber-300 text-amber-900 text-xs sm:text-sm font-semibold px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
                <button type="button" onclick="dismissAlert(this.closest('.alert-auto-dismiss'))" class="text-amber-700 hover:text-amber-950 font-medium p-1 cursor-pointer">&times;</button>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-auto-dismiss max-w-7xl mx-auto px-4 mt-4 w-full" role="alert">
            <div class="bg-green-50 border border-green-200 text-green-800 text-xs sm:text-sm font-medium px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold">[Sukses]</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="dismissAlert(this.closest('.alert-auto-dismiss'))" class="text-green-600 hover:text-green-900 font-medium p-1 cursor-pointer">&times;</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-auto-dismiss max-w-7xl mx-auto px-4 mt-4 w-full" role="alert">
            <div class="bg-red-50 border border-red-200 text-red-800 text-xs sm:text-sm font-medium px-4 py-3 rounded-xl flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold">[Perhatian]</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="dismissAlert(this.closest('.alert-auto-dismiss'))" class="text-red-600 hover:text-red-900 font-medium p-1 cursor-pointer">&times;</button>
            </div>
        </div>
    @endif

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER (PERSIS FOTO media_1790644528320.png) -->
    @include('partials.footer')

    <!-- Floating Back To Top Button -->
    <button type="button"
            id="scroll-to-top-btn"
            onclick="window.tbScrollTo ? window.tbScrollTo(0) : window.scrollTo({ top: 0, behavior: 'smooth' })"
            aria-label="Kembali ke atas"
            class="fixed bottom-6 right-6 z-40 w-11 h-11 rounded-full bg-[#27443E] hover:bg-[#DE3B28] text-white border-2 border-white/80 shadow-[0_4px_16px_rgba(0,0,0,0.25)] flex items-center justify-center opacity-0 pointer-events-none translate-y-3 transition-all duration-[420ms] ease-[cubic-bezier(0.22,1,0.36,1)] cursor-pointer active:scale-90">
        <svg class="w-5 h-5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    <!-- CART FLOATING CARD -->
    @php
        $initialCartCount = session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0;
    @endphp
    <div id="cart-backdrop" onclick="toggleCartDrawer()" class="fixed inset-0 bg-black/50 z-50 hidden transition-opacity duration-300"></div>
    <div id="cart-drawer" class="fixed top-16 sm:top-20 inset-x-3 sm:inset-x-auto sm:right-4 w-auto sm:w-[92vw] max-w-[385px] bg-white rounded-[20px] shadow-2xl border border-gray-200/80 z-50 flex flex-col max-h-[calc(100vh-5.5rem)] overflow-hidden pointer-events-none opacity-0 invisible" style="transform: scale(0.95) translateY(-8px); transition: transform 0.38s cubic-bezier(0.22,1,0.36,1), opacity 0.32s ease;">

        <!-- Cart Header (Fixed Top) -->
        <div class="px-6 py-5 bg-white border-b border-[#E5E7EB] flex-shrink-0">
            <h3 data-i18n-app="cart_title" class="font-semibold text-[#2E3137] text-[18px] leading-snug">Keranjang Pesanan</h3>
            <p class="text-[13px] text-[#737373] mt-1 font-normal" id="cart-items-count-text">{{ $initialCartCount }} Menu Dipilih</p>
        </div>

        <!-- Scrollable Burger Orders Container (Only this section scrolls!) -->
        <div id="cart-items-container" class="overflow-y-auto px-5 pt-4 pb-2 space-y-3.5 {{ $initialCartCount > 0 ? 'max-h-[348px]' : '' }}">
            <div class="py-7 px-4 flex flex-col items-center text-center">
                <img src="{{ asset('images/empty-cart.png') }}"
                     alt="Keranjang Kosong"
                     class="w-[175px] h-auto object-contain mx-auto mb-6 select-none pointer-events-none">
                <h4 data-i18n-app="cart_empty_title" class="font-semibold text-[#52565E] text-[18px] leading-snug tracking-tight">
                    Keranjangmu masih kosong nih
                </h4>
                <p class="text-[13px] text-[#737373] leading-[1.5] mt-1.5 mx-auto font-normal">
                    <span data-i18n-app="cart_empty_sub1" class="block sm:whitespace-nowrap">Yuk, pilih burger favoritmu dan mulai ngisi</span>
                    <span data-i18n-app="cart_empty_sub2" class="block">perut kosongmu hari ini</span>
                </p>
                <button type="button"
                        onclick="startOrderFromCart()"
                        class="mt-6 bg-[#3E5B56] hover:bg-[#324B47] active:scale-95 text-white font-medium text-[13.5px] px-8 py-3 rounded-[10px] transition cursor-pointer inline-flex items-center justify-center min-h-[44px] shadow-2xs">
                    <span data-i18n-app="cart_empty_btn">Mulai Pesan Sekarang</span>
                </button>
            </div>
        </div>

        <!-- Fixed Bottom Footer (Subtotal Menu + Checkout Button stay fixed and never scroll) -->
        <div id="cart-fixed-footer" class="{{ $initialCartCount > 0 ? '' : 'hidden' }} flex-shrink-0 px-5 pt-2 pb-5 bg-white space-y-4">
            <!-- Price Breakdown (Fixed) -->
            <div id="cart-summary-section" class="bg-[#F4F5F7] rounded-[14px] px-4 py-3.5 space-y-2 text-[12px] text-[#6A6F77]">
                <div class="flex items-center justify-between">
                    <span data-i18n-app="cart_subtotal">Subtotal Menu:</span>
                    <span id="cart-subtotal" class="font-medium text-[#52565E]">Rp 0</span>
                </div>
                <div id="cart-discount-row" class="hidden items-center justify-between text-[#13653F]">
                    <span data-i18n-app="cart_discount">Diskon Promo:</span>
                    <span id="cart-discount" class="font-medium">- Rp 0</span>
                </div>
                <div class="flex items-center justify-between">
                    <span data-i18n-app="cart_tax">Pajak PPN (11%)</span>
                    <span id="cart-tax" class="font-medium text-[#52565E]">Rp 0</span>
                </div>
                <div class="flex items-center justify-between text-[12.5px] font-semibold text-[#2E3137] pt-2.5 mt-1 border-t border-[#E5E7EB]">
                    <span data-i18n-app="cart_total">Total Tagihan:</span>
                    <span id="cart-total" class="font-semibold text-[#2E3137]">Rp 0</span>
                </div>
            </div>

            <!-- Checkout Action Button (Fixed) -->
            <div id="cart-action-section" class="space-y-2.5">
                @if(!$isStoreOpen)
                    <div class="rounded-xl bg-red-50 border border-red-200 px-3.5 py-2.5 text-[11.5px] text-red-800 leading-snug">
                        <strong class="block font-bold">Outlet Sedang Tutup ({{ $closedReason }})</strong>
                        <span>Checkout dinonaktifkan sementara hingga toko dibuka kembali.</span>
                    </div>
                    <button type="button"
                            onclick="promptStoreClosed()"
                            class="w-full bg-gray-300 text-gray-600 font-semibold py-3.5 px-4 rounded-[10px] flex items-center justify-center text-[13.5px] min-h-[44px] cursor-not-allowed">
                        Outlet Sedang Tutup
                    </button>
                @else
                    <a href="{{ route('orders.checkout') }}"
                       id="checkout-btn"
                       @guest onclick="event.preventDefault(); promptRequireLogin('Wajib login terlebih dahulu untuk checkout pesanan.');" @endguest
                       class="w-full bg-[#3E5B56] hover:bg-[#324B47] active:scale-98 text-white font-medium py-3.5 px-4 rounded-[10px] flex items-center justify-center transition text-[13.5px] shadow-2xs min-h-[44px]">
                        <span data-i18n-app="cart_checkout">Lanjutkan Ke pembayaran</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- PRODUCT DETAIL & CUSTOMIZATION MODAL (Matching Figma Mockup) -->
    <div id="product-modal-backdrop" onclick="closeProductModal()" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 hidden transition-opacity duration-300"></div>
    <div id="product-modal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-5 hidden" onclick="closeProductModal()">
        <div id="product-modal-card" class="bg-white rounded-[28px] sm:rounded-[34px] max-w-[760px] w-full max-h-[92vh] overflow-y-auto relative p-5 sm:p-7 md:p-8 shadow-2xl border border-gray-150 animate-modal-pop" onclick="event.stopPropagation()">

            <!-- Close Button (Top Right) -->
            <button type="button"
                    onclick="closeProductModal()"
                    class="absolute top-3 right-3 sm:top-4 sm:right-4 w-9 h-9 rounded-full bg-white/95 hover:bg-white text-gray-800 border border-black/15 shadow-md flex items-center justify-center transition cursor-pointer z-30"
                    aria-label="Tutup">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
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
                            <label for="modal-notes" data-i18n-app="modal_notes_label" class="block text-xs font-bold text-[#2D3B36] mb-1.5">
                                Catatan Pesanan
                            </label>
                            <textarea id="modal-notes"
                                      rows="2"
                                      placeholder="Contoh: saus dipisah, tanpa selada..."
                                      data-i18n-app-attr="placeholder:modal_notes_placeholder"
                                      class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs sm:text-[13px] text-gray-700 placeholder:text-gray-400 focus:outline-none focus:border-[#385850] focus:ring-1 focus:ring-[#385850] resize-none transition leading-relaxed"></textarea>
                        </div>
                    </div>

                    <!-- Bottom Action Row: Stepper [-] 1 [+] and Compact Add to Cart Button -->
                    <div class="flex items-center gap-2.5 sm:gap-3 mt-4 sm:mt-5 pt-1">
                        <!-- Stepper [-] 1 [+] (Tombol Kurang & Tambah Burger) -->
                        <div class="inline-flex items-center border border-gray-200 rounded-xl bg-white px-2 py-1 shadow-2xs gap-2 shrink-0">
                            <button type="button"
                                    onclick="adjustModalQty(-1)"
                                    class="w-5 h-5 flex items-center justify-center text-gray-500 hover:text-gray-900 text-xs font-medium transition cursor-pointer select-none"
                                    aria-label="Kurang burger">&minus;</button>
                            <span id="modal-quantity" class="w-4 text-center font-bold text-xs text-gray-900 select-none">1</span>
                            <button type="button"
                                    onclick="adjustModalQty(1)"
                                    class="w-5 h-5 flex items-center justify-center text-gray-500 hover:text-gray-900 text-xs font-medium transition cursor-pointer select-none"
                                    aria-label="Tambah burger">&plus;</button>
                        </div>

                        <!-- CTA Button (Dikecilkan, Ringkas & Proporsional) -->
                        @if(!$isStoreOpen)
                            <button type="button"
                                    id="modal-submit-btn"
                                    onclick="submitAddToCart()"
                                    class="bg-gray-300 text-gray-600 font-semibold text-xs py-2 px-3.5 sm:px-4 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-2xs cursor-not-allowed whitespace-nowrap">
                                <span>Outlet Sedang Tutup</span>
                            </button>
                        @else
                            <button type="button"
                                    id="modal-submit-btn"
                                    onclick="submitAddToCart()"
                                    class="bg-[#385850] hover:bg-[#2C463F] active:scale-[0.98] text-white font-medium text-xs py-2 px-3.5 sm:px-4 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-xs cursor-pointer transition whitespace-nowrap">
                                <span data-i18n-app="modal_add_btn">Tambahkan ke keranjang</span>
                                <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M27.7188 8.28125C27.5312 8.09375 27.2917 8 27 8H22C21.9583 6.29167 21.375 4.875 20.25 3.75C18.5625 2.0625 17.7094 2.04062 16 2C14.2917 2.04167 12.875 2.625 11.75 3.75C10.0625 5.4375 10.0406 6.29063 10 8H5C4.70833 8 4.46875 8.09375 4.28125 8.28125C4.09375 8.46875 4 8.70833 4 9V29C4 29.2917 4.09375 29.5312 4.28125 29.7188C4.5625 30 4.70938 30 5 30H27C27.2917 30 27.5312 29.9062 27.7188 29.7188C28 29.4375 28 29.2906 28 29V9C28 8.70833 27.9062 8.46875 27.7188 8.28125ZM13.1719 5.17188C13.5412 4.79762 13.9817 4.50111 14.4674 4.29984C14.9531 4.09857 15.4742 3.99662 16 4C17.125 4.02083 18.0677 4.41146 18.8281 5.17188C19.9688 6.3125 19.9781 6.875 20 8H12C12.0208 6.875 12.4115 5.93229 13.1719 5.17188ZM26 28H6V10H10V14H12V10H20V14H22V10H26V28Z" fill="currentColor"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>

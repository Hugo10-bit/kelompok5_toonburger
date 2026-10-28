@php
    $errors = $errors ?? new \Illuminate\Support\ViewErrorBag;
    $currentMode = (isset($mode) && $mode === 'register') || request()->is('register') || old('form_type') === 'register' ? 'register' : 'login';
@endphp
<!DOCTYPE html>
<html lang="id" class="h-full w-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/toon-head.png') }}">
    <title>{{ $currentMode === 'register' ? 'Create Account' : 'Welcome Back!' }} - Toon Burger</title>

    <!-- Google Fonts: Luckiest Guy & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Prevent theme flash (FOUC) -->
    <script>
        if (localStorage.getItem('toon_theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        toon: {
                            granite: '#466967',
                            'granite-dark': '#344E4C',
                            wheat: '#F1D9B3',
                            rust: '#C1502D',
                            cream: '#FAF1E1',
                            dark: '#263A38',
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
        html, body {
            height: 100%;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F1D9B3;
            color: #263A38;
            overflow-x: hidden;
        }
        .font-brand {
            font-family: 'Luckiest Guy', cursive;
            letter-spacing: 0.05em;
        }
        /* Classic retro checkerboard pattern */
        .checkerboard-pattern {
            background-image:
                linear-gradient(45deg, #466967 25%, transparent 25%),
                linear-gradient(-45deg, #466967 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #466967 75%),
                linear-gradient(-45deg, transparent 75%, #466967 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
        }
        .dark .checkerboard-pattern {
            background-image:
                linear-gradient(45deg, #2D4442 25%, transparent 25%),
                linear-gradient(-45deg, #2D4442 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #2D4442 75%),
                linear-gradient(-45deg, transparent 75%, #2D4442 75%);
        }
        .static-burger {
            transform: rotate(var(--rot, 0deg));
        }
        /* Prevent Edge/IE native password reveal button from overlapping custom toggle button */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
</head>
<body class="h-full w-full bg-[#F1D9B3] dark:bg-[#151F1E] flex flex-col md:flex-row overflow-y-auto md:overflow-hidden m-0 p-0 relative transition-colors duration-200">

    <!-- TOP GREEN ARC CONTINUOUS EXTENSION (For showing #466967 behind rounded-tl of white panel) -->
    <div class="hidden md:block absolute top-0 left-0 right-0 h-32 lg:h-40 pointer-events-none z-0 overflow-hidden">
        <svg viewBox="0 0 1000 130" preserveAspectRatio="none" class="w-full h-full">
            <path d="M 0 0 L 1000 0 L 1000 70 Q 250 140 0 70 Z" class="fill-[#466967] dark:fill-[#2D4442] transition-colors duration-200" />
        </svg>
    </div>

    <!-- ═══ LEFT PANEL: BRANDED TOON BURGER BANNER ═══ -->
    <div class="w-full md:w-[47%] lg:w-[47%] h-auto md:h-screen min-h-[460px] md:min-h-full bg-[#F1D9B3] dark:bg-[#1D2A29] relative flex flex-col justify-between overflow-hidden p-0 flex-shrink-0 select-none z-10 transition-colors duration-200">

        <!-- TOP CURVED ARC IN GRANITE #466967 WITH TOON BURGER LOGO -->
        <div class="relative w-full z-10">
            <!-- Curved background SVG -->
            <div class="relative w-full overflow-hidden">
                <svg viewBox="0 0 500 130" preserveAspectRatio="none" class="w-full h-32 sm:h-36 lg:h-40 block drop-shadow-xs">
                    <path d="M 0 0 L 500 0 L 500 65 Q 250 135 0 65 Z" class="fill-[#466967] dark:fill-[#2D4442] transition-colors duration-200" />
                </svg>

                <!-- Mascot & Text inside Arc -->
                <div class="absolute inset-0 flex flex-col items-center justify-start pt-2 sm:pt-2.5 lg:pt-3">
                    <a href="{{ route('home') }}" class="focus:outline-none focus:ring-2 focus:ring-white rounded-lg">
                        <img src="{{ asset('images/toonburger-logo-white.png') }}"
                             alt="Toon Burger"
                             class="h-20 sm:h-24 lg:h-26 w-auto object-contain drop-shadow-md -translate-y-1 sm:-translate-y-2">
                    </a>
                </div>
            </div>
        </div>

        <!-- STATIONARY BURGERS -->
        <!-- 1. Top-Left Stationary Burger -->
        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Burger"
             style="--rot: -15deg;"
             class="static-burger absolute top-32 lg:top-40 left-4 sm:left-7 lg:left-10 w-14 sm:w-18 lg:w-22 drop-shadow-md pointer-events-none opacity-95 z-20">

        <!-- 2. Top-Right Stationary Burger -->
        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Burger"
             style="--rot: 14deg;"
             class="static-burger absolute top-36 lg:top-44 right-4 sm:right-7 lg:right-10 w-18 sm:w-22 lg:w-28 drop-shadow-md pointer-events-none opacity-95 z-20">

        <!-- 3. Bottom-Left Stationary Burger -->
        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Burger"
             style="--rot: -9deg;"
             class="static-burger absolute bottom-24 lg:bottom-28 left-4 sm:left-7 lg:left-10 w-22 sm:w-26 lg:w-32 drop-shadow-md pointer-events-none opacity-95 z-20">

        <!-- 4. Bottom-Right Stationary Burger -->
        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Burger"
             style="--rot: 18deg;"
             class="static-burger absolute bottom-28 lg:bottom-32 right-4 sm:right-7 lg:right-10 w-16 sm:w-20 lg:w-26 drop-shadow-md pointer-events-none opacity-95 z-20">

        <!-- CENTER BRAND HEADLINE -->
        <div class="my-auto py-8 sm:py-10 px-4 sm:px-6 text-center relative z-20">
            <h1 class="font-brand text-5xl sm:text-6xl md:text-6xl lg:text-[76px] xl:text-[88px] leading-[1.0] text-[#466967] dark:text-[#F1D9B3] tracking-wider uppercase drop-shadow-xs transition-colors duration-200">
                EAT GOOD.<br>
                FEEL GOOD.<br>
                LIVE GOOD.
            </h1>
        </div>

        <!-- BOTTOM CHECKERBOARD & SINCE 2024 -->
        <div class="w-full relative z-20 pt-2 pb-5">
            <div class="w-full h-8 checkerboard-pattern opacity-90 dark:opacity-60"></div>
            <div class="text-center pt-3 text-xs font-semibold text-[#466967]/80 dark:text-[#F1D9B3]/80 tracking-widest uppercase transition-colors duration-200">
                -Since 2024-
            </div>
        </div>

    </div>

    <!-- ═══ RIGHT PANEL: WHITE FORM CARD ═══ -->
    <div class="w-full md:w-[53%] lg:w-[53%] min-h-screen md:h-screen bg-white dark:bg-[#182322] md:rounded-tl-[48px] md:rounded-bl-[48px] shadow-2xl dark:shadow-black/50 flex flex-col justify-between items-center px-7 sm:px-14 lg:px-20 xl:px-28 py-8 md:py-10 overflow-y-auto relative z-10 transition-colors duration-200">

        <!-- Top anchor for optical balance -->
        <div class="hidden md:block w-full h-1"></div>

        <div class="w-full max-w-sm sm:max-w-md mx-auto my-auto py-4">

            <!-- FLASH ALERTS -->
            @if(session('warning'))
                <div id="alert-warning" class="mb-5 p-3.5 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-700/80 text-amber-900 dark:text-amber-200 text-xs font-bold rounded-xl flex items-center justify-between shadow-xs" role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span id="alert-warning-text">{{ session('warning') }}</span>
                    </div>
                    <button type="button" onclick="this.closest('#alert-warning').remove()" class="text-amber-700 hover:text-amber-950 dark:text-amber-300 dark:hover:text-amber-100 font-bold p-1 cursor-pointer transition-colors" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @else
                <div id="alert-warning" class="hidden mb-5 p-3.5 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-700/80 text-amber-900 dark:text-amber-200 text-xs font-bold rounded-xl items-center justify-between shadow-xs" role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span id="alert-warning-text">Wajib login terlebih dahulu.</span>
                    </div>
                    <button type="button" onclick="this.closest('#alert-warning').remove()" class="text-amber-700 hover:text-amber-950 dark:text-amber-300 dark:hover:text-amber-100 font-bold p-1 cursor-pointer transition-colors" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-3.5 bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-700/80 text-red-800 dark:text-red-200 text-xs font-bold rounded-xl flex items-center justify-between shadow-xs" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-600 font-bold hover:text-red-900 dark:text-red-300 dark:hover:text-red-100 cursor-pointer p-1" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-5 p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-700/80 text-emerald-800 dark:text-emerald-200 text-xs font-bold rounded-xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 font-bold hover:text-emerald-900 dark:text-emerald-300 dark:hover:text-emerald-100 cursor-pointer">&times;</button>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-700/80 text-emerald-800 dark:text-emerald-200 text-xs font-bold rounded-xl flex justify-between items-center shadow-xs">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 font-bold hover:text-emerald-900 dark:text-emerald-300 dark:hover:text-emerald-100 cursor-pointer">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-[#FFF1F0] dark:bg-red-950/60 border border-red-200/80 dark:border-red-800/80 text-toon-rust dark:text-red-300 text-xs font-semibold rounded-2xl flex items-center gap-2.5 shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                    <span class="font-bold">
                        @if($errors->has('email') || $errors->has('username') || $errors->has('password'))
                            Username, email, atau password yang dimasukkan salah.
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                </div>
            @endif

            <!-- ── 1. LOGIN FORM ("Welcome Back!") ── -->
            <div id="login-form-panel" class="{{ $currentMode === 'login' ? 'block' : 'hidden' }} transition-all duration-300">
                <div class="mb-7">
                    <h2 class="text-2xl sm:text-[28px] md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight whitespace-nowrap" id="login-title">Selamat Datang Kembali!</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-normal mt-1" id="login-subtitle">Tolong isi detail anda terlebih dahulu.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" onsubmit="localStorage.removeItem('tb_logged_out')" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <!-- Username / Email Field -->
                    <div>
                        <label for="login-email" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1.5" id="login-email-label">Username</label>
                        <input type="text"
                               name="email"
                               id="login-email"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Masukkan Username"
                               value="{{ old('form_type') === 'login' ? old('email', old('username')) : (old('email', old('username')) ?: 'admin') }}"
                               class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-transparent dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl px-4 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white font-medium placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="login-password" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1.5" id="login-password-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="login-password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan Password"
                                   value="Password123"
                                   class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-transparent dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl pl-4 pr-11 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white font-medium placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('login-password', this)"
                                    class="absolute inset-y-0 right-0 w-11 flex items-center justify-center text-gray-400 hover:text-[#466967] dark:text-gray-400 dark:hover:text-[#618a88] focus:outline-none focus:text-[#466967] dark:focus:text-[#618a88] transition-colors cursor-pointer"
                                    aria-label="Tampilkan Password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-gray-700 dark:text-gray-300 font-medium">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#466967] dark:bg-gray-800 dark:border-gray-700 focus:ring-[#466967] dark:focus:ring-[#618a88] border-gray-300">
                            <span id="remember-label-text">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" id="forgot-pass-link" class="text-xs text-gray-500 dark:text-gray-400 hover:text-[#466967] dark:hover:text-[#618a88] font-medium transition focus:outline-none focus:underline">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] dark:bg-[#466967] dark:hover:bg-[#3a5755] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] focus:ring-offset-2 dark:focus:ring-offset-[#182322]">
                            <span id="login-btn-text">Login</span>
                        </button>
                    </div>

                    <!-- Toggle to Register -->
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 pt-2">
                        <span id="no-account-text">Belum Punya Akun?</span>
                        <button type="button" onclick="switchToRegister()" id="switch-to-register-btn" class="text-[#466967] dark:text-[#618a88] dark:hover:text-[#7ba9a6] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Daftar Sekarang
                        </button>
                    </p>
                </form>
            </div>

            <!-- ── 2. CREATE ACCOUNT FORM ("Create Account") ── -->
            <div id="register-form-panel" class="{{ $currentMode === 'register' ? 'block' : 'hidden' }} transition-all duration-300">
                <div class="mb-7">
                    <h2 class="text-2xl sm:text-[28px] md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight whitespace-nowrap" id="register-title">Buat Akun</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-normal mt-1" id="register-subtitle">Bergabung dengan keluarga Toon Burger</p>
                </div>

                <form action="{{ route('register') }}" method="POST" onsubmit="localStorage.removeItem('tb_logged_out')" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <!-- Username -->
                    <div>
                        <label for="register-username" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1" id="reg-username-label">Username</label>
                        <div class="relative">
                            <input type="text"
                                   name="username"
                                   id="register-username"
                                   required
                                   autocomplete="username"
                                   placeholder="Masukkan username anda"
                                   value="{{ old('form_type') === 'register' ? old('username') : '' }}"
                                   class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-gray-200 dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl p-3 pr-10 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="register-email" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1" id="reg-email-label">Email</label>
                        <input type="email"
                               name="email"
                               id="register-email"
                               required
                               autocomplete="email"
                               placeholder="Masukkan email anda"
                               value="{{ old('form_type') === 'register' ? old('email') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-gray-200 dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="register-phone" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1" id="reg-phone-label">Nomor Telepon</label>
                        <input type="tel"
                               name="phone_number"
                               id="register-phone"
                               autocomplete="tel"
                               placeholder="Masukkan nomor telepon anda"
                               value="{{ old('form_type') === 'register' ? old('phone_number') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-gray-200 dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="register-password" class="block text-xs font-semibold text-gray-800 dark:text-gray-200 mb-1" id="reg-pass-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="register-password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Masukkan password (min. 6 karakter)"
                                   class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white dark:bg-[#223231] dark:hover:bg-[#283b3a] dark:focus:bg-[#1D2A29] border border-gray-200 dark:border-gray-700/60 focus:border-[#466967] dark:focus:border-[#618a88] rounded-xl p-3 pr-11 min-h-[44px] text-xs sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('register-password', this)"
                                    class="absolute inset-y-0 right-0 w-11 flex items-center justify-center text-gray-400 hover:text-[#466967] dark:text-gray-400 dark:hover:text-[#618a88] focus:outline-none focus:text-[#466967] dark:focus:text-[#618a88] transition-colors cursor-pointer"
                                    aria-label="Tampilkan Password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sign Up / Register Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] dark:bg-[#466967] dark:hover:bg-[#3a5755] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] focus:ring-offset-2 dark:focus:ring-offset-[#182322]">
                            <span id="register-btn-text">Daftar</span>
                        </button>
                    </div>

                    <!-- Toggle to Login -->
                    <p class="text-center text-xs text-gray-500 dark:text-gray-400 pt-2">
                        <span id="have-account-text">Sudah punya akun?</span>
                        <button type="button" onclick="switchToLogin()" id="switch-to-login-btn" class="text-[#466967] dark:text-[#618a88] dark:hover:text-[#7ba9a6] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Login Sekarang
                        </button>
                    </p>
                </form>
            </div>

        </div>

        <!-- ── BOTTOM FOOTER: LANGUAGE TOGGLE & THEME TOGGLE ── -->
        <div class="w-full max-w-sm sm:max-w-md mx-auto pt-6 pb-2 sm:pb-4 flex items-center justify-between relative select-none z-20">
            <!-- Left invisible spacer so language toggle remains centered on desktop -->
            <div class="w-[68px] hidden sm:block opacity-0 pointer-events-none" aria-hidden="true"></div>

            <!-- Language Dropdown -->
            <div class="relative inline-block text-left" id="lang-dropdown-container">
                <button type="button"
                        id="lang-toggle-btn"
                        onclick="toggleLanguageDropdown(event)"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] transition-colors cursor-pointer py-1 px-2.5 rounded-lg hover:bg-gray-50/80 dark:hover:bg-[#223231]"
                        aria-expanded="false"
                        aria-haspopup="true">
                    <span id="lang-current-label">Indonesia</span>
                    <svg id="lang-chevron" class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="lang-dropdown-menu"
                     class="hidden absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-36 bg-white dark:bg-[#223231] rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 py-1.5 z-50 transition-all duration-150">
                    <button type="button"
                            onclick="changeLanguage('id')"
                            class="w-full text-left px-3.5 py-2 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#2B3D3C] hover:text-[#466967] dark:hover:text-[#618a88] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-id">
                        <span>Indonesia</span>
                        <span id="check-id" class="text-[#466967] dark:text-[#618a88] font-bold">✓</span>
                    </button>
                    <button type="button"
                            onclick="changeLanguage('en')"
                            class="w-full text-left px-3.5 py-2 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-[#2B3D3C] hover:text-[#466967] dark:hover:text-[#618a88] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-en">
                        <span>English</span>
                        <span id="check-en" class="text-[#466967] dark:text-[#618a88] font-bold hidden">✓</span>
                    </button>
                </div>
            </div>

            <!-- Dark / Light Mode Switcher (Bottom Right) -->
            <div class="flex items-center justify-end">
                <button type="button"
                        id="theme-toggle-btn"
                        onclick="toggleTheme()"
                        class="inline-flex items-center gap-1 p-[3px] rounded-full border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-[#1E2D2C] cursor-pointer transition-colors focus:outline-none focus:ring-2 focus:ring-[#466967] dark:focus:ring-[#618a88] focus:ring-offset-2 dark:focus:ring-offset-[#182322]"
                        role="switch"
                        aria-checked="false"
                        aria-label="Beralih ke mode gelap">
                    <span id="theme-sun-icon"
                          class="w-6 h-6 rounded-full bg-white text-gray-700 shadow-xs flex items-center justify-center transition-all duration-200"
                          title="Mode Terang">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </span>
                    <span id="theme-moon-icon"
                          class="w-6 h-6 rounded-full bg-transparent text-gray-400 flex items-center justify-center transition-all duration-200"
                          title="Mode Gelap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>

    </div>

    <!-- SCRIPT FOR SWITCHING TABS, TOGGLING PASSWORD, AND LANGUAGE LOCALIZATION -->
    <script>
        const translations = {
            id: {
                currentLabel: 'Indonesia',
                loginTitle: 'Selamat Datang Kembali!',
                loginSubtitle: 'Tolong isi detail anda terlebih dahulu.',
                loginEmailLabel: 'Username',
                loginEmailPlaceholder: 'Masukkan Username',
                loginPasswordLabel: 'Password',
                loginPasswordPlaceholder: 'Masukkan Password',
                rememberMe: 'Ingat Saya',
                forgotPassword: 'Lupa Password?',
                loginButton: 'Login',
                noAccount: 'Belum Punya Akun?',
                signUpNow: 'Daftar Sekarang',
                registerTitle: 'Buat Akun',
                registerSubtitle: 'Bergabung dengan keluarga Toon Burger',
                regUsernameLabel: 'Username',
                regUsernamePlaceholder: 'Masukkan username anda',
                regEmailLabel: 'Email',
                regEmailPlaceholder: 'Masukkan email anda',
                regPhoneLabel: 'Nomor Telepon',
                regPhonePlaceholder: 'Masukkan nomor telepon anda',
                regPasswordLabel: 'Password',
                regPasswordPlaceholder: 'Masukkan password (min. 6 karakter)',
                registerButton: 'Daftar',
                haveAccount: 'Sudah punya akun?',
                loginNow: 'Login Sekarang',
                pageTitleLogin: 'Selamat Datang Kembali! - Toon Burger',
                pageTitleRegister: 'Buat Akun - Toon Burger',
                themeAriaLight: 'Beralih ke mode gelap',
                themeAriaDark: 'Beralih ke mode terang',
                themeLightTooltip: 'Mode Terang',
                themeDarkTooltip: 'Mode Gelap'
            },
            en: {
                currentLabel: 'English',
                loginTitle: 'Welcome Back!',
                loginSubtitle: 'Please enter your detail first',
                loginEmailLabel: 'Username or Email',
                loginEmailPlaceholder: 'Enter your username or email',
                loginPasswordLabel: 'Password',
                loginPasswordPlaceholder: 'Enter your password',
                rememberMe: 'Remember Me',
                forgotPassword: 'Forgot Password?',
                loginButton: 'Login',
                noAccount: "Don't have an account?",
                signUpNow: 'Sign Up Now',
                registerTitle: 'Create Account',
                registerSubtitle: 'Join Toon Burger family',
                regUsernameLabel: 'Username',
                regUsernamePlaceholder: 'Enter your username',
                regEmailLabel: 'Email',
                regEmailPlaceholder: 'Enter your email',
                regPhoneLabel: 'Mobile Number',
                regPhonePlaceholder: 'Enter your mobile number',
                regPasswordLabel: 'Password',
                regPasswordPlaceholder: 'Enter your password (min. 6 characters)',
                registerButton: 'Sign Up',
                haveAccount: 'Already have an account?',
                loginNow: 'Login Now',
                pageTitleLogin: 'Welcome Back! - Toon Burger',
                pageTitleRegister: 'Create Account - Toon Burger',
                themeAriaLight: 'Switch to dark mode',
                themeAriaDark: 'Switch to light mode',
                themeLightTooltip: 'Light Mode',
                themeDarkTooltip: 'Dark Mode'
            }
        };

        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            setTheme(isDark ? 'light' : 'dark');
        }

        function setTheme(theme) {
            const btn = document.getElementById('theme-toggle-btn');
            const sunIcon = document.getElementById('theme-sun-icon');
            const moonIcon = document.getElementById('theme-moon-icon');
            const currentLang = localStorage.getItem('toon_lang') || 'id';
            const t = translations[currentLang] || translations.id;

            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('toon_theme', 'dark');
                if (btn) {
                    btn.setAttribute('aria-checked', 'true');
                    btn.setAttribute('aria-label', t.themeAriaDark);
                }
                if (sunIcon) {
                    sunIcon.className = "w-6 h-6 rounded-full bg-transparent text-gray-400 flex items-center justify-center transition-all duration-200";
                }
                if (moonIcon) {
                    moonIcon.className = "w-6 h-6 rounded-full bg-[#2A3E3C] text-amber-300 shadow-xs flex items-center justify-center transition-all duration-200";
                }
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('toon_theme', 'light');
                if (btn) {
                    btn.setAttribute('aria-checked', 'false');
                    btn.setAttribute('aria-label', t.themeAriaLight);
                }
                if (sunIcon) {
                    sunIcon.className = "w-6 h-6 rounded-full bg-white text-gray-700 shadow-xs flex items-center justify-center transition-all duration-200";
                }
                if (moonIcon) {
                    moonIcon.className = "w-6 h-6 rounded-full bg-transparent text-gray-400 flex items-center justify-center transition-all duration-200";
                }
            }
        }

        function toggleLanguageDropdown(e) {
            e.stopPropagation();
            const menu = document.getElementById('lang-dropdown-menu');
            const chevron = document.getElementById('lang-chevron');
            const btn = document.getElementById('lang-toggle-btn');
            if (!menu) return;
            const isHidden = menu.classList.contains('hidden');
            menu.classList.toggle('hidden', !isHidden);
            if (chevron) chevron.classList.toggle('rotate-180', isHidden);
            if (btn) btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
        }

        function changeLanguage(lang) {
            if (!translations[lang]) return;
            localStorage.setItem('toon_lang', lang);
            applyLanguage(lang);

            const menu = document.getElementById('lang-dropdown-menu');
            const chevron = document.getElementById('lang-chevron');
            const btn = document.getElementById('lang-toggle-btn');
            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }

        function applyLanguage(lang) {
            const t = translations[lang] || translations.id;

            const currentLabel = document.getElementById('lang-current-label');
            if (currentLabel) currentLabel.textContent = t.currentLabel;

            const checkId = document.getElementById('check-id');
            const checkEn = document.getElementById('check-en');
            if (checkId) checkId.classList.toggle('hidden', lang !== 'id');
            if (checkEn) checkEn.classList.toggle('hidden', lang !== 'en');

            // Login Form
            const loginTitle = document.getElementById('login-title');
            if (loginTitle) loginTitle.textContent = t.loginTitle;
            const loginSubtitle = document.getElementById('login-subtitle');
            if (loginSubtitle) loginSubtitle.textContent = t.loginSubtitle;
            const loginEmailLabel = document.getElementById('login-email-label');
            if (loginEmailLabel) loginEmailLabel.textContent = t.loginEmailLabel;
            const loginEmail = document.getElementById('login-email');
            if (loginEmail) loginEmail.placeholder = t.loginEmailPlaceholder;
            const loginPasswordLabel = document.getElementById('login-password-label');
            if (loginPasswordLabel) loginPasswordLabel.textContent = t.loginPasswordLabel;
            const loginPassword = document.getElementById('login-password');
            if (loginPassword) loginPassword.placeholder = t.loginPasswordPlaceholder;
            const rememberText = document.getElementById('remember-label-text');
            if (rememberText) rememberText.textContent = t.rememberMe;
            const forgotPassLink = document.getElementById('forgot-pass-link');
            if (forgotPassLink) forgotPassLink.textContent = t.forgotPassword;
            const loginBtnText = document.getElementById('login-btn-text');
            if (loginBtnText) loginBtnText.textContent = t.loginButton;
            const noAccountText = document.getElementById('no-account-text');
            if (noAccountText) noAccountText.textContent = t.noAccount;
            const switchToRegisterBtn = document.getElementById('switch-to-register-btn');
            if (switchToRegisterBtn) switchToRegisterBtn.textContent = t.signUpNow;

            // Register Form
            const registerTitle = document.getElementById('register-title');
            if (registerTitle) registerTitle.textContent = t.registerTitle;
            const registerSubtitle = document.getElementById('register-subtitle');
            if (registerSubtitle) registerSubtitle.textContent = t.registerSubtitle;
            const regUsernameLabel = document.getElementById('reg-username-label');
            if (regUsernameLabel) regUsernameLabel.textContent = t.regUsernameLabel;
            const regUsername = document.getElementById('register-username');
            if (regUsername) regUsername.placeholder = t.regUsernamePlaceholder;
            const regEmailLabel = document.getElementById('reg-email-label');
            if (regEmailLabel) regEmailLabel.textContent = t.regEmailLabel;
            const regEmail = document.getElementById('register-email');
            if (regEmail) regEmail.placeholder = t.regEmailPlaceholder;
            const regPhoneLabel = document.getElementById('reg-phone-label');
            if (regPhoneLabel) regPhoneLabel.textContent = t.regPhoneLabel;
            const regPhone = document.getElementById('register-phone');
            if (regPhone) regPhone.placeholder = t.regPhonePlaceholder;
            const regPassLabel = document.getElementById('reg-pass-label');
            if (regPassLabel) regPassLabel.textContent = t.regPasswordLabel;
            const regPass = document.getElementById('register-password');
            if (regPass) regPass.placeholder = t.regPasswordPlaceholder;
            const registerBtnText = document.getElementById('register-btn-text');
            if (registerBtnText) registerBtnText.textContent = t.registerButton;
            const haveAccountText = document.getElementById('have-account-text');
            if (haveAccountText) haveAccountText.textContent = t.haveAccount;
            const switchToLoginBtn = document.getElementById('switch-to-login-btn');
            if (switchToLoginBtn) switchToLoginBtn.textContent = t.loginNow;

            const isLoginActive = !document.getElementById('login-form-panel').classList.contains('hidden');
            document.title = isLoginActive ? t.pageTitleLogin : t.pageTitleRegister;

            const isDark = document.documentElement.classList.contains('dark');
            const themeBtn = document.getElementById('theme-toggle-btn');
            if (themeBtn) {
                themeBtn.setAttribute('aria-label', isDark ? t.themeAriaDark : t.themeAriaLight);
            }
            const sunIcon = document.getElementById('theme-sun-icon');
            if (sunIcon) sunIcon.setAttribute('title', t.themeLightTooltip);
            const moonIcon = document.getElementById('theme-moon-icon');
            if (moonIcon) moonIcon.setAttribute('title', t.themeDarkTooltip);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('lang-dropdown-container');
            const menu = document.getElementById('lang-dropdown-menu');
            const chevron = document.getElementById('lang-chevron');
            const btn = document.getElementById('lang-toggle-btn');
            if (container && !container.contains(e.target)) {
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // Close dropdown on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('lang-dropdown-menu');
                const chevron = document.getElementById('lang-chevron');
                const btn = document.getElementById('lang-toggle-btn');
                if (menu && !menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                    if (btn) btn.setAttribute('aria-expanded', 'false');
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('toon_lang') || 'id';
            applyLanguage(savedLang);

            const savedTheme = localStorage.getItem('toon_theme') || 'light';
            setTheme(savedTheme);

            if (localStorage.getItem('tb_logged_out') === '1') {
                const warnAlert = document.getElementById('alert-warning');
                if (warnAlert) {
                    warnAlert.classList.remove('hidden');
                    warnAlert.classList.add('flex');
                }
                localStorage.removeItem('tb_logged_out');
            }
        });

        function switchToRegister() {
            document.getElementById('login-form-panel').classList.add('hidden');
            document.getElementById('register-form-panel').classList.remove('hidden');
            const currentLang = localStorage.getItem('toon_lang') || 'id';
            document.title = (translations[currentLang] || translations.id).pageTitleRegister;
            window.history.replaceState(null, '', '{{ route("register") }}');
        }

        function switchToLogin() {
            document.getElementById('register-form-panel').classList.add('hidden');
            document.getElementById('login-form-panel').classList.remove('hidden');
            const currentLang = localStorage.getItem('toon_lang') || 'id';
            document.title = (translations[currentLang] || translations.id).pageTitleLogin;
            window.history.replaceState(null, '', '{{ route("login") }}');
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            if (isPassword) {
                btn.setAttribute('aria-label', 'Sembunyikan Password');
                btn.innerHTML = `<svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18"/></svg>`;
            } else {
                btn.setAttribute('aria-label', 'Tampilkan Password');
                btn.innerHTML = `<svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
            }
        }

        // Reload page on Back / Forward navigation to prevent displaying cached authenticated views after logout
        window.addEventListener('pageshow', function (event) {
            if (localStorage.getItem('tb_logged_out') === '1') {
                const warnAlert = document.getElementById('alert-warning');
                if (warnAlert) {
                    warnAlert.classList.remove('hidden');
                    warnAlert.classList.add('flex');
                }
                localStorage.removeItem('tb_logged_out');
            }

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

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
    <title>{{ $currentMode === 'register' ? 'Buat Akun' : 'Selamat Datang Kembali!' }} - Toon Burger</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        toon: {
                            granite: '#3F5E5A',
                            'granite-btn': '#436460',
                            'granite-dark': '#344E4C',
                            wheat: '#EAD5B3',
                            rust: '#C1502D',
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
            background-color: #EAD5B3;
            color: #111827;
            overflow-x: hidden;
        }
        .wheat-canvas {
            background-color: #EAD5B3;
            background-image: radial-gradient(rgba(63, 94, 90, 0.085) 1px, transparent 0);
            background-size: 4px 4px;
        }
        .font-brand {
            font-family: 'Luckiest Guy', cursive;
            letter-spacing: 0.03em;
            text-shadow: 3px 4px 0px rgba(45, 40, 35, 0.24);
        }
        /* 3-row retro checkerboard (3 x 18px = 54px height) */
        .checkerboard-3rows {
            height: 54px;
            background-image:
                linear-gradient(45deg, #3F5E5A 25%, transparent 25%),
                linear-gradient(-45deg, #3F5E5A 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #3F5E5A 75%),
                linear-gradient(-45deg, transparent 75%, #3F5E5A 75%);
            background-size: 36px 36px;
            background-position: 0 0, 0 18px, 18px -18px, -18px 0;
        }
        .static-burger {
            transform: rotate(var(--rot, 0deg));
            filter: drop-shadow(-6px 8px 7px rgba(0, 0, 0, 0.26));
        }
        /* Hide native Edge/IE password reveal icon so it does not overlap custom toggle */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
        *:focus-visible {
            outline: 2px solid #3F5E5A;
            outline-offset: 2px;
        }
        .dark *:focus-visible {
            outline: 2px solid #82B3AD;
            outline-offset: 2px;
        }
    </style>
</head>
<body class="min-h-screen lg:h-screen w-full wheat-canvas flex flex-col md:flex-row overflow-y-auto lg:overflow-hidden m-0 p-0 relative">

    <!-- Top granite fill behind the rounded top-left corner of the right form card on desktop -->
    <div class="hidden md:block absolute top-0 left-0 right-0 h-24 bg-[#3F5E5A] pointer-events-none z-0"></div>

    <!-- Left panel: Toon Burger poster -->
    <div class="w-full md:w-[46.5%] lg:w-[46.5%] min-h-[480px] md:h-screen wheat-canvas relative flex flex-col justify-between overflow-hidden p-0 shrink-0 select-none z-10">

        <!-- Top curved granite header with mascot logo -->
        <div class="relative w-full z-10">
            <div class="relative w-full overflow-hidden">
                <svg viewBox="0 0 500 135" preserveAspectRatio="none" class="w-full h-28 sm:h-32 lg:h-[136px] block">
                    <path d="M 0 0 L 500 0 L 500 32 Q 250 148 0 32 Z" fill="#3F5E5A" />
                </svg>

                <div class="absolute inset-0 flex flex-col items-center justify-start pt-1.5 sm:pt-2 lg:pt-2.5">
                    <a href="{{ route('welcome') }}" class="rounded-lg inline-flex items-center justify-center min-w-[44px] min-h-[44px]" aria-label="Halaman Awal Toon Burger">
                        <img src="{{ asset('images/toonburger-logo-white.png') }}"
                             alt="Toon Burger"
                             class="h-20 sm:h-24 lg:h-[96px] w-auto object-contain drop-shadow-sm -translate-y-1">
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 rotated burgers matching reference layout -->
        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Smash Burger"
             style="--rot: -3deg;"
             class="static-burger absolute top-[26%] left-[6.5%] w-12 sm:w-14 lg:w-[58px] pointer-events-none z-20">

        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Double Smash Burger"
             style="--rot: 6deg;"
             class="static-burger absolute top-[17%] right-[7%] w-20 sm:w-24 lg:w-[122px] pointer-events-none z-20">

        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Triple Cheese Burger"
             style="--rot: -19deg;"
             class="static-burger absolute bottom-[23.5%] left-[5.5%] w-20 sm:w-24 lg:w-[122px] pointer-events-none z-20">

        <img src="{{ asset('images/floating-burger.png') }}"
             alt="Cheese Burger"
             style="--rot: -26deg;"
             class="static-burger absolute bottom-[29.5%] right-[11.5%] w-13 sm:w-15 lg:w-[64px] pointer-events-none z-20">

        <!-- Center slogan (left-aligned lines inside centered block) -->
        <div class="my-auto py-6 sm:py-8 px-6 flex justify-center items-center relative z-20">
            <h1 class="font-brand text-4xl sm:text-5xl md:text-[46px] lg:text-[54px] xl:text-[60px] leading-[1.38] text-[#3F5E5A] uppercase text-left inline-block">
                EAT GOOD.<br>
                FEEL GOOD.<br>
                LIVE GOOD.
            </h1>
        </div>

        <!-- Bottom 3-row checkerboard and Since 2025 -->
        <div class="w-full relative z-20 pb-5 sm:pb-7">
            <div class="w-full checkerboard-3rows"></div>
            <div class="text-center pt-5 sm:pt-6 text-xs sm:text-[13px] font-semibold text-[#263A38] tracking-normal">
                - Since 2025-
            </div>
        </div>

    </div>

    <!-- Right panel: White / Dark form card -->
    <div id="right-auth-card" class="w-full md:w-[53.5%] lg:w-[53.5%] min-h-screen md:h-screen bg-white dark:bg-[#182221] text-[#111827] dark:text-[#F9FAFB] md:rounded-tl-[36px] md:rounded-bl-[36px] shadow-2xl flex flex-col justify-between items-center px-6 sm:px-12 lg:px-20 xl:px-24 py-6 sm:py-8 overflow-y-auto relative z-10 transition-colors duration-200">

        <div class="hidden md:block w-full h-2 shrink-0"></div>

        <div class="w-full max-w-[430px] mx-auto my-auto py-4">

            @if(session('warning'))
                <div id="alert-warning" class="mb-5 p-3.5 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-200 text-xs font-semibold rounded-lg flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span id="alert-warning-text">{{ session('warning') }}</span>
                    </div>
                    <button type="button" onclick="this.closest('#alert-warning').remove()" class="text-amber-700 dark:text-amber-300 hover:text-amber-950 font-bold min-w-[44px] min-h-[44px] -my-2 -mr-2 flex items-center justify-center cursor-pointer" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @else
                <div id="alert-warning" class="hidden mb-5 p-3.5 bg-amber-50 dark:bg-amber-950/60 border border-amber-300 dark:border-amber-700 text-amber-900 dark:text-amber-200 text-xs font-semibold rounded-lg items-center justify-between" role="alert">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span id="alert-warning-text">Wajib login terlebih dahulu.</span>
                    </div>
                    <button type="button" onclick="this.closest('#alert-warning').remove()" class="text-amber-700 dark:text-amber-300 hover:text-amber-950 font-bold min-w-[44px] min-h-[44px] -my-2 -mr-2 flex items-center justify-center cursor-pointer" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-3.5 bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 text-xs font-semibold rounded-lg flex items-center justify-between" role="alert">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-red-600 dark:text-red-300 font-bold min-w-[44px] min-h-[44px] -my-2 -mr-2 flex items-center justify-center cursor-pointer" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @endif

            @if(session('status'))
                <div class="mb-5 p-3.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 text-xs font-semibold rounded-lg flex items-center justify-between" role="status">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 dark:text-emerald-300 font-bold min-w-[44px] min-h-[44px] -my-2 -mr-2 flex items-center justify-center cursor-pointer" aria-label="Tutup notifikasi">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-3.5 bg-[#FFF1F0] dark:bg-red-950/60 border border-red-300 dark:border-red-800 text-[#B42318] dark:text-red-200 text-xs font-semibold rounded-lg flex items-center gap-2.5" role="alert">
                    <svg class="w-4 h-4 text-[#B42318] dark:text-red-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>
                        @if($errors->has('email') || $errors->has('username') || $errors->has('password'))
                            Username, email, atau password yang dimasukkan salah.
                        @else
                            {{ $errors->first() }}
                        @endif
                    </span>
                </div>
            @endif

            <!-- Login Form Panel -->
            <div id="login-form-panel" class="{{ $currentMode === 'login' ? 'block' : 'hidden' }}">
                <div class="mb-9">
                    <h2 class="text-2xl sm:text-[32px] lg:text-[34px] font-bold text-[#111827] dark:text-white tracking-tight leading-tight" id="login-title">Selamat Datang Kembali!</h2>
                    <p class="text-xs sm:text-[15px] text-[#4B5563] dark:text-[#CBD5E1] font-normal mt-1.5" id="login-subtitle">Tolong isi detail anda terlebih dahulu.</p>
                </div>

                <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="handleAuthSubmit(this, 'login-btn-text', 'Memproses...')" class="space-y-5 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <div>
                        <label for="login-email" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1.5" id="login-email-label">Username</label>
                        <input type="text"
                               name="email"
                               id="login-email"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Masukkan Username"
                               value="{{ old('form_type') === 'login' ? old('email', old('username')) : '' }}"
                               class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] px-0 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white font-normal placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                    </div>

                    <div>
                        <label for="login-password" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1.5" id="login-password-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="login-password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan Password"
                                   class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] pl-0 pr-11 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white font-normal placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                            <button type="button"
                                    onclick="togglePasswordVisibility('login-password', this)"
                                    class="absolute inset-y-0 right-0 w-11 min-h-[44px] flex items-center justify-end pr-0.5 text-[#111827] dark:text-[#E2E8F0] hover:text-[#3F5E5A] dark:hover:text-[#82B3AD] transition-colors cursor-pointer"
                                    aria-label="Tampilkan Password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-xs pt-0.5">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none text-[#111827] dark:text-[#F9FAFB] font-medium min-h-[44px]">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded-[2px] text-[#3F5E5A] focus:ring-[#3F5E5A] border-[#6B7280] dark:border-[#94A3B8] bg-transparent">
                            <span id="remember-label-text">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" id="forgot-pass-link" class="text-[11.5px] text-[#111827] dark:text-[#F9FAFB] hover:underline font-medium transition min-h-[44px] inline-flex items-center">
                            Lupa Password?
                        </a>
                    </div>

                    <div class="pt-1">
                        <button type="submit" id="login-submit-btn" class="w-full bg-[#436460] hover:bg-[#35514E] text-white font-semibold py-3 px-6 rounded-[8px] transition active:scale-[0.99] min-h-[44px] text-xs sm:text-[13.5px] flex items-center justify-center gap-2 cursor-pointer">
                            <span id="login-btn-text">Login</span>
                        </button>
                    </div>

                    <div class="text-center text-xs pt-1 flex items-center justify-center gap-1 flex-wrap">
                        <span id="no-account-text" class="text-[#59626E] dark:text-[#94A3B8]">Belum Punya Akun?</span>
                        <button type="button" onclick="switchToRegister()" id="switch-to-register-btn" class="text-[#111827] dark:text-white hover:underline font-medium cursor-pointer min-h-[44px] inline-flex items-center px-1">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- Register Form Panel -->
            <div id="register-form-panel" class="{{ $currentMode === 'register' ? 'block' : 'hidden' }}">
                <div class="mb-7">
                    <h2 class="text-2xl sm:text-[32px] font-bold text-[#111827] dark:text-white tracking-tight leading-tight" id="register-title">Buat Akun</h2>
                    <p class="text-xs sm:text-[15px] text-[#4B5563] dark:text-[#CBD5E1] font-normal mt-1.5" id="register-subtitle">Bergabung dengan keluarga Toon Burger.</p>
                </div>

                <form id="register-form" action="{{ route('register') }}" method="POST" onsubmit="handleAuthSubmit(this, 'register-btn-text', 'Memproses...')" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <div>
                        <label for="register-username" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1" id="reg-username-label">Username</label>
                        <input type="text"
                               name="username"
                               id="register-username"
                               required
                               autocomplete="username"
                               placeholder="Masukkan Username"
                               value="{{ old('form_type') === 'register' ? old('username') : '' }}"
                               class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] px-0 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                    </div>

                    <div>
                        <label for="register-email" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1" id="reg-email-label">Email</label>
                        <input type="email"
                               name="email"
                               id="register-email"
                               required
                               autocomplete="email"
                               placeholder="Masukkan Email"
                               value="{{ old('form_type') === 'register' ? old('email') : '' }}"
                               class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] px-0 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                    </div>

                    <div>
                        <label for="register-phone" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1" id="reg-phone-label">Nomor Telepon</label>
                        <input type="tel"
                               name="phone_number"
                               id="register-phone"
                               autocomplete="tel"
                               placeholder="Masukkan Nomor Telepon"
                               value="{{ old('form_type') === 'register' ? old('phone_number') : '' }}"
                               class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] px-0 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                    </div>

                    <div>
                        <label for="register-password" class="block text-xs sm:text-[13.5px] font-medium text-[#111827] dark:text-[#F9FAFB] mb-1" id="reg-pass-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="register-password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Masukkan Password (min. 6 karakter)"
                                   class="w-full bg-transparent border-0 border-b border-[#6B7280] dark:border-[#94A3B8] focus:border-[#3F5E5A] dark:focus:border-[#82B3AD] pl-0 pr-11 py-2.5 min-h-[44px] text-xs sm:text-[13px] text-[#111827] dark:text-white placeholder-[#717A86] dark:placeholder-[#94A3B8] focus:outline-none focus:ring-0 transition-colors">
                            <button type="button"
                                    onclick="togglePasswordVisibility('register-password', this)"
                                    class="absolute inset-y-0 right-0 w-11 min-h-[44px] flex items-center justify-end pr-0.5 text-[#111827] dark:text-[#E2E8F0] hover:text-[#3F5E5A] dark:hover:text-[#82B3AD] transition-colors cursor-pointer"
                                    aria-label="Tampilkan Password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="register-submit-btn" class="w-full bg-[#436460] hover:bg-[#35514E] text-white font-semibold py-3 px-6 rounded-[8px] transition active:scale-[0.99] min-h-[44px] text-xs sm:text-[13.5px] flex items-center justify-center gap-2 cursor-pointer">
                            <span id="register-btn-text">Daftar</span>
                        </button>
                    </div>

                    <div class="text-center text-xs pt-1 flex items-center justify-center gap-1 flex-wrap">
                        <span id="have-account-text" class="text-[#59626E] dark:text-[#94A3B8]">Sudah punya akun?</span>
                        <button type="button" onclick="switchToLogin()" id="switch-to-login-btn" class="text-[#111827] dark:text-white hover:underline font-medium cursor-pointer min-h-[44px] inline-flex items-center px-1">
                            Login Sekarang
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- Bottom bar: Centered Language Selector & Bottom-Right Theme Pill Toggle -->
        <div class="w-full max-w-[460px] mx-auto pt-4 pb-1 flex items-center justify-between relative select-none z-20">
            <!-- Left spacer to keep language selector optically centered -->
            <div class="w-[66px] hidden sm:block" aria-hidden="true"></div>

            <!-- Language Dropdown -->
            <div class="relative inline-block text-left mx-auto sm:mx-0" id="lang-dropdown-container">
                <button type="button"
                        id="lang-toggle-btn"
                        onclick="toggleLanguageDropdown(event)"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-[13px] font-normal text-[#59626E] dark:text-[#CBD5E1] hover:text-[#111827] dark:hover:text-white transition-colors cursor-pointer min-h-[44px] px-3 rounded-lg"
                        aria-expanded="false"
                        aria-haspopup="true">
                    <span id="lang-current-label">Indonesia</span>
                    <svg id="lang-chevron" class="w-2.5 h-2.5 text-[#59626E] dark:text-[#CBD5E1] transition-transform duration-200" viewBox="0 0 10 6" fill="currentColor">
                        <path d="M0 0.5L5 5.5L10 0.5H0Z" />
                    </svg>
                </button>

                <div id="lang-dropdown-menu"
                     class="hidden absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 w-36 bg-white dark:bg-[#22302E] rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 py-1.5 z-50">
                    <button type="button"
                            onclick="changeLanguage('id')"
                            class="w-full text-left px-3.5 py-2.5 min-h-[44px] text-xs font-medium text-[#111827] dark:text-white hover:bg-gray-100 dark:hover:bg-[#2C3E3B] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-id">
                        <span>Indonesia</span>
                        <span id="check-id" class="text-[#3F5E5A] dark:text-[#82B3AD] font-bold">✓</span>
                    </button>
                    <button type="button"
                            onclick="changeLanguage('en')"
                            class="w-full text-left px-3.5 py-2.5 min-h-[44px] text-xs font-medium text-[#111827] dark:text-white hover:bg-gray-100 dark:hover:bg-[#2C3E3B] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-en">
                        <span>English</span>
                        <span id="check-en" class="text-[#3F5E5A] dark:text-[#82B3AD] font-bold hidden">✓</span>
                    </button>
                </div>
            </div>

            <!-- Light / Dark Theme Pill Toggle (Matches bottom-right switch in reference image) -->
            <button type="button"
                    id="theme-toggle-btn"
                    onclick="toggleThemeMode()"
                    aria-pressed="false"
                    aria-label="Ganti Tema Terang atau Gelap"
                    class="min-h-[44px] inline-flex items-center justify-center px-1 cursor-pointer bg-transparent border-0">
                <span class="w-[66px] h-[32px] rounded-full bg-[#E5E7EB] dark:bg-[#2B3B39] border border-[#D1D5DB] dark:border-[#4B6360] p-[2px] flex items-center justify-between relative transition-colors">
                    <!-- Sun indicator -->
                    <span id="theme-sun-pill" class="w-[26px] h-[26px] rounded-full bg-white dark:bg-transparent border border-[#6B7280] dark:border-transparent flex items-center justify-center text-[#374151] dark:text-[#94A3B8] shadow-2xs dark:shadow-none transition-all">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <circle cx="12" cy="12" r="4"/>
                            <path stroke-linecap="round" d="M12 2v2.5M12 19.5V22M4.93 4.93l1.77 1.77M17.3 17.3l1.77 1.77M2 12h2.5M19.5 12H22M4.93 19.07l1.77-1.77M17.3 6.7l1.77-1.77"/>
                        </svg>
                    </span>
                    <!-- Moon indicator -->
                    <span id="theme-moon-pill" class="w-[26px] h-[26px] rounded-full bg-transparent dark:bg-[#182221] border border-transparent dark:border-[#82B3AD] flex items-center justify-center text-[#9CA3AF] dark:text-[#F9FAFB] transition-all">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                        </svg>
                    </span>
                </span>
            </button>
        </div>

    </div>

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
                registerSubtitle: 'Bergabung dengan keluarga Toon Burger.',
                regUsernameLabel: 'Username',
                regUsernamePlaceholder: 'Masukkan Username',
                regEmailLabel: 'Email',
                regEmailPlaceholder: 'Masukkan Email',
                regPhoneLabel: 'Nomor Telepon',
                regPhonePlaceholder: 'Masukkan Nomor Telepon',
                regPasswordLabel: 'Password',
                regPasswordPlaceholder: 'Masukkan Password (min. 6 karakter)',
                registerButton: 'Daftar',
                haveAccount: 'Sudah punya akun?',
                loginNow: 'Login Sekarang',
                pageTitleLogin: 'Selamat Datang Kembali! - Toon Burger',
                pageTitleRegister: 'Buat Akun - Toon Burger'
            },
            en: {
                currentLabel: 'English',
                loginTitle: 'Welcome Back!',
                loginSubtitle: 'Please enter your details first.',
                loginEmailLabel: 'Username',
                loginEmailPlaceholder: 'Enter Username',
                loginPasswordLabel: 'Password',
                loginPasswordPlaceholder: 'Enter Password',
                rememberMe: 'Remember Me',
                forgotPassword: 'Forgot Password?',
                loginButton: 'Login',
                noAccount: "Don't have an account?",
                signUpNow: 'Sign Up Now',
                registerTitle: 'Create Account',
                registerSubtitle: 'Join the Toon Burger family.',
                regUsernameLabel: 'Username',
                regUsernamePlaceholder: 'Enter your username',
                regEmailLabel: 'Email',
                regEmailPlaceholder: 'Enter your email',
                regPhoneLabel: 'Mobile Number',
                regPhonePlaceholder: 'Enter your mobile number',
                regPasswordLabel: 'Password',
                regPasswordPlaceholder: 'Enter your password (min. 6 chars)',
                registerButton: 'Sign Up',
                haveAccount: 'Already have an account?',
                loginNow: 'Login Now',
                pageTitleLogin: 'Welcome Back! - Toon Burger',
                pageTitleRegister: 'Create Account - Toon Burger'
            }
        };

        function handleAuthSubmit(form, btnTextId, loadingLabel) {
            localStorage.removeItem('tb_logged_out');
            const textSpan = document.getElementById(btnTextId);
            const submitBtn = form.querySelector('button[type="submit"]');
            if (textSpan) {
                textSpan.textContent = loadingLabel;
            }
            if (submitBtn) {
                submitBtn.classList.add('opacity-80');
                setTimeout(function() {
                    submitBtn.disabled = true;
                }, 15);
            }
        }

        function applyThemeMode(theme) {
            const isDark = theme === 'dark';
            document.documentElement.classList.toggle('dark', isDark);
            const btn = document.getElementById('theme-toggle-btn');
            if (btn) {
                btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            }
        }

        function toggleThemeMode() {
            const isCurrentlyDark = document.documentElement.classList.contains('dark');
            const nextTheme = isCurrentlyDark ? 'light' : 'dark';
            localStorage.setItem('toon_theme', nextTheme);
            applyThemeMode(nextTheme);
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
        }

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
            applyThemeMode(savedTheme);

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

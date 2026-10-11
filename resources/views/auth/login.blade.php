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

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
        .static-burger {
            transform: rotate(var(--rot, 0deg));
        }
    </style>
</head>
<body class="h-full w-full bg-[#F1D9B3] flex flex-col md:flex-row overflow-y-auto md:overflow-hidden m-0 p-0 relative">

    <!-- TOP GREEN ARC CONTINUOUS EXTENSION (For showing #466967 behind rounded-tl of white panel) -->
    <div class="hidden md:block absolute top-0 left-0 right-0 h-32 lg:h-40 pointer-events-none z-0 overflow-hidden">
        <svg viewBox="0 0 1000 130" preserveAspectRatio="none" class="w-full h-full">
            <path d="M 0 0 L 1000 0 L 1000 70 Q 250 140 0 70 Z" fill="#466967" />
        </svg>
    </div>

    <!-- ═══ LEFT PANEL: BRANDED TOON BURGER BANNER ═══ -->
    <div class="w-full md:w-[47%] lg:w-[47%] h-auto md:h-screen min-h-[460px] md:min-h-full bg-[#F1D9B3] relative flex flex-col justify-between overflow-hidden p-0 flex-shrink-0 select-none z-10">

        <!-- TOP CURVED ARC IN GRANITE #466967 WITH TOON BURGER LOGO -->
        <div class="relative w-full z-10">
            <!-- Curved background SVG -->
            <div class="relative w-full overflow-hidden">
                <svg viewBox="0 0 500 130" preserveAspectRatio="none" class="w-full h-32 sm:h-36 lg:h-40 block drop-shadow-xs">
                    <path d="M 0 0 L 500 0 L 500 65 Q 250 135 0 65 Z" fill="#466967" />
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
            <h1 class="font-brand text-5xl sm:text-6xl md:text-6xl lg:text-[76px] xl:text-[88px] leading-[1.0] text-[#466967] tracking-wider uppercase drop-shadow-xs">
                EAT GOOD.<br>
                FEEL GOOD.<br>
                LIVE GOOD.
            </h1>
        </div>

        <!-- BOTTOM CHECKERBOARD & SINCE 2024 -->
        <div class="w-full relative z-20 pt-2 pb-5">
            <div class="w-full h-8 checkerboard-pattern opacity-90"></div>
            <div class="text-center pt-3 text-xs font-semibold text-[#466967]/80 tracking-widest uppercase">
                -Since 2024-
            </div>
        </div>

    </div>

    <!-- ═══ RIGHT PANEL: WHITE FORM CARD ═══ -->
    <div class="w-full md:w-[53%] lg:w-[53%] min-h-screen md:h-screen bg-white md:rounded-tl-[48px] md:rounded-bl-[48px] shadow-2xl flex flex-col justify-between items-center px-7 sm:px-14 lg:px-20 xl:px-28 py-8 md:py-10 overflow-y-auto relative z-10">

        <!-- Top anchor for optical balance -->
        <div class="hidden md:block w-full h-1"></div>

        <div class="w-full max-w-sm sm:max-w-md mx-auto my-auto py-4">

            <!-- FLASH ALERTS -->
            @if(session('status'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('status') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 font-bold hover:text-emerald-900 cursor-pointer">&times;</button>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex justify-between items-center shadow-xs">
                    <span>{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 font-bold hover:text-emerald-900 cursor-pointer">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-[#FFF1F0] border border-red-200/80 text-toon-rust text-xs font-semibold rounded-2xl flex items-center gap-2.5 shadow-2xs">
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
                    <h2 class="text-2xl sm:text-[28px] md:text-3xl font-extrabold text-gray-900 tracking-tight whitespace-nowrap" id="login-title">Selamat Datang Kembali!</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-normal mt-1" id="login-subtitle">Tolong isi detail anda terlebih dahulu.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <!-- Username / Email Field -->
                    <div>
                        <label for="login-email" class="block text-xs font-semibold text-gray-800 mb-1.5" id="login-email-label">Username</label>
                        <input type="text"
                               name="email"
                               id="login-email"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Masukkan Username"
                               value="{{ old('form_type') === 'login' ? old('email', old('username')) : (old('email', old('username')) ?: 'admin') }}"
                               class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-xl px-4 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="login-password" class="block text-xs font-semibold text-gray-800 mb-1.5" id="login-password-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="login-password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Masukkan Password"
                                   value="Password123"
                                   class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-xl pl-4 pr-11 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('login-password', this)"
                                    class="absolute inset-y-0 right-0 pr-3.5 pl-2 flex items-center justify-center text-gray-400 hover:text-[#466967] focus:outline-none focus:text-[#466967] transition-colors cursor-pointer"
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
                        <label class="flex items-center gap-2 cursor-pointer select-none text-gray-700 font-medium">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#466967] focus:ring-[#466967] border-gray-300">
                            <span id="remember-label-text">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" id="forgot-pass-link" class="text-xs text-gray-500 hover:text-[#466967] font-medium transition focus:outline-none focus:underline">
                            Lupa Password?
                        </a>
                    </div>

                    <!-- Login Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2">
                            <span id="login-btn-text">Login</span>
                        </button>
                    </div>

                    <!-- Toggle to Register -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        <span id="no-account-text">Belum Punya Akun?</span>
                        <button type="button" onclick="switchToRegister()" id="switch-to-register-btn" class="text-[#466967] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Daftar Sekarang
                        </button>
                    </p>
                </form>
            </div>

            <!-- ── 2. CREATE ACCOUNT FORM ("Create Account") ── -->
            <div id="register-form-panel" class="{{ $currentMode === 'register' ? 'block' : 'hidden' }} transition-all duration-300">
                <div class="mb-7">
                    <h2 class="text-2xl sm:text-[28px] md:text-3xl font-extrabold text-gray-900 tracking-tight whitespace-nowrap" id="register-title">Buat Akun</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-normal mt-1" id="register-subtitle">Bergabung dengan keluarga Toon Burger</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <!-- Username -->
                    <div>
                        <label for="register-username" class="block text-xs font-semibold text-gray-800 mb-1" id="reg-username-label">Username</label>
                        <div class="relative">
                            <input type="text"
                                   name="username"
                                   id="register-username"
                                   required
                                   autocomplete="username"
                                   placeholder="Masukkan username anda"
                                   value="{{ old('form_type') === 'register' ? old('username') : '' }}"
                                   class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 pr-10 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                            <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="register-email" class="block text-xs font-semibold text-gray-800 mb-1" id="reg-email-label">Email</label>
                        <input type="email"
                               name="email"
                               id="register-email"
                               required
                               autocomplete="email"
                               placeholder="Masukkan email anda"
                               value="{{ old('form_type') === 'register' ? old('email') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="register-phone" class="block text-xs font-semibold text-gray-800 mb-1" id="reg-phone-label">Nomor Telepon</label>
                        <input type="tel"
                               name="phone_number"
                               id="register-phone"
                               autocomplete="tel"
                               placeholder="Masukkan nomor telepon anda"
                               value="{{ old('form_type') === 'register' ? old('phone_number') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="register-password" class="block text-xs font-semibold text-gray-800 mb-1" id="reg-pass-label">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="register-password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Masukkan password (min. 6 karakter)"
                                   class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 pr-10 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('register-password', this)"
                                    class="absolute inset-y-0 right-0 pr-3.5 pl-2 flex items-center justify-center text-gray-400 hover:text-[#466967] focus:outline-none focus:text-[#466967] transition-colors cursor-pointer"
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
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2">
                            <span id="register-btn-text">Daftar</span>
                        </button>
                    </div>

                    <!-- Toggle to Login -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        <span id="have-account-text">Sudah punya akun?</span>
                        <button type="button" onclick="switchToLogin()" id="switch-to-login-btn" class="text-[#466967] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Login Sekarang
                        </button>
                    </p>
                </form>
            </div>

        </div>

        <!-- ── BOTTOM FOOTER: LANGUAGE TOGGLE ── -->
        <div class="w-full max-w-sm sm:max-w-md mx-auto pt-6 pb-2 sm:pb-4 flex items-center justify-center relative select-none z-20">
            <div class="relative inline-block text-left" id="lang-dropdown-container">
                <button type="button"
                        id="lang-toggle-btn"
                        onclick="toggleLanguageDropdown(event)"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-gray-500 hover:text-gray-800 focus:outline-none transition-colors cursor-pointer py-1 px-2.5 rounded-lg hover:bg-gray-50/80"
                        aria-expanded="false"
                        aria-haspopup="true">
                    <span id="lang-current-label">Indonesia</span>
                    <svg id="lang-chevron" class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div id="lang-dropdown-menu"
                     class="hidden absolute bottom-full mb-2 left-1/2 -translate-x-1/2 w-36 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50 transition-all duration-150">
                    <button type="button"
                            onclick="changeLanguage('id')"
                            class="w-full text-left px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-[#466967] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-id">
                        <span>Indonesia</span>
                        <span id="check-id" class="text-[#466967] font-bold">✓</span>
                    </button>
                    <button type="button"
                            onclick="changeLanguage('en')"
                            class="w-full text-left px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-[#466967] flex items-center justify-between cursor-pointer transition-colors"
                            id="lang-opt-en">
                        <span>English</span>
                        <span id="check-en" class="text-[#466967] font-bold hidden">✓</span>
                    </button>
                </div>
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
                pageTitleRegister: 'Buat Akun - Toon Burger'
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
                pageTitleRegister: 'Create Account - Toon Burger'
            }
        };

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
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
            } else {
                btn.setAttribute('aria-label', 'Tampilkan Password');
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
            }
        }
    </script>
</body>
</html>

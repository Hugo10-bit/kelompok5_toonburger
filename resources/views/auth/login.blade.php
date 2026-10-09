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
            <!-- Mobile Back to Homepage button -->
            <a href="{{ route('home') }}"
               class="md:hidden absolute top-3.5 left-3.5 z-30 inline-flex items-center gap-1.5 text-xs font-semibold text-white bg-black/25 hover:bg-black/40 backdrop-blur-xs px-3 py-1.5 rounded-full border border-white/20 transition-all active:scale-95 min-h-[44px] focus:outline-none focus:ring-2 focus:ring-white"
               aria-label="Back to Homepage"
               title="Kembali ke Beranda">
                <svg class="w-4 h-4 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-[11px] font-medium">Home</span>
            </a>

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
    <div class="w-full md:w-[53%] lg:w-[53%] min-h-screen md:h-screen bg-white md:rounded-tl-[48px] md:rounded-bl-[48px] shadow-2xl flex flex-col justify-center items-center px-7 sm:px-14 lg:px-20 xl:px-28 py-10 md:py-16 overflow-y-auto relative z-10">

        <div class="w-full max-w-sm sm:max-w-md mx-auto">

            <!-- Back to Homepage -->
            <div class="mb-6">
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-[#466967] hover:text-[#344E4C] bg-[#FAF1E1] hover:bg-[#F1D9B3]/80 border border-[#466967]/15 rounded-xl px-4 py-2.5 transition-all duration-200 group focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2 min-h-[44px] shadow-2xs"
                   title="Kembali ke Beranda">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-1 shrink-0 text-[#466967]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Homepage</span>
                </a>
            </div>

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
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Welcome Back!</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-normal mt-1">Please enter your detail first</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <!-- Username / Email Field -->
                    <div>
                        <label for="login-email" class="block text-xs font-semibold text-gray-800 mb-1.5">Username or Email</label>
                        <input type="text"
                               name="email"
                               id="login-email"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Enter your username or email"
                               value="{{ old('form_type') === 'login' ? old('email', old('username')) : (old('email', old('username')) ?: 'admin') }}"
                               class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-xl px-4 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="login-password" class="block text-xs font-semibold text-gray-800 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="login-password"
                                   required
                                   autocomplete="current-password"
                                   placeholder="Enter your password"
                                   value="Password123"
                                   class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-xl pl-4 pr-11 py-3 min-h-[44px] text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('login-password', this)"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#466967] rounded cursor-pointer"
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
                            <span>Remember Me</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="fillAdminCreds()" class="text-[11px] text-gray-400 hover:text-[#466967] font-medium transition cursor-pointer underline">
                                Demo Admin
                            </button>
                            <a href="{{ route('password.request') }}" class="text-xs text-gray-500 hover:text-[#466967] font-medium transition focus:outline-none focus:underline">
                                Forgot Password?
                            </a>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2">
                            <span>Login</span>
                        </button>
                    </div>

                    <!-- Toggle to Register -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        Don't have an account?
                        <button type="button" onclick="switchToRegister()" class="text-[#466967] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Sign Up Now
                        </button>
                    </p>
                </form>
            </div>

            <!-- ── 2. CREATE ACCOUNT FORM ("Create Account") ── -->
            <div id="register-form-panel" class="{{ $currentMode === 'register' ? 'block' : 'hidden' }} transition-all duration-300">
                <div class="mb-7">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Create Account</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-normal mt-1">Join Toon Burger family</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <!-- Username -->
                    <div>
                        <label for="register-username" class="block text-xs font-semibold text-gray-800 mb-1">Username</label>
                        <div class="relative">
                            <input type="text"
                                   name="username"
                                   id="register-username"
                                   required
                                   autocomplete="username"
                                   placeholder="Enter your username"
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
                        <label for="register-email" class="block text-xs font-semibold text-gray-800 mb-1">Email</label>
                        <input type="email"
                               name="email"
                               id="register-email"
                               required
                               autocomplete="email"
                               placeholder="Enter your email"
                               value="{{ old('form_type') === 'register' ? old('email') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="register-phone" class="block text-xs font-semibold text-gray-800 mb-1">Mobile Number</label>
                        <input type="tel"
                               name="phone_number"
                               id="register-phone"
                               autocomplete="tel"
                               placeholder="Enter your mobile number"
                               value="{{ old('form_type') === 'register' ? old('phone_number') : '' }}"
                               class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="register-password" class="block text-xs font-semibold text-gray-800 mb-1">Password</label>
                        <div class="relative">
                            <input type="password"
                                   name="password"
                                   id="register-password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="Enter your password (min. 6 characters)"
                                   class="w-full bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-xl p-3 pr-10 min-h-[44px] text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#466967] transition">
                            <button type="button"
                                    onclick="togglePasswordVisibility('register-password', this)"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-[#466967] rounded cursor-pointer"
                                    aria-label="Tampilkan Password">
                                <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sign Up Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-bold py-3.5 px-6 rounded-xl shadow-sm hover:shadow transition active:scale-98 min-h-[44px] text-sm flex items-center justify-center gap-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2">
                            <span>Sign Up</span>
                        </button>
                    </div>

                    <!-- Toggle to Login -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        Already have an account?
                        <button type="button" onclick="switchToLogin()" class="text-[#466967] hover:underline font-bold ml-1 cursor-pointer focus:outline-none focus:underline">
                            Login Now
                        </button>
                    </p>
                </form>
            </div>

        </div>

    </div>

    <!-- SCRIPT FOR SWITCHING TABS & TOGGLING PASSWORD -->
    <script>
        function switchToRegister() {
            document.getElementById('login-form-panel').classList.add('hidden');
            document.getElementById('register-form-panel').classList.remove('hidden');
            document.title = "Create Account - Toon Burger";
            window.history.replaceState(null, '', '{{ route("register") }}');
        }

        function switchToLogin() {
            document.getElementById('register-form-panel').classList.add('hidden');
            document.getElementById('login-form-panel').classList.remove('hidden');
            document.title = "Welcome Back! - Toon Burger";
            window.history.replaceState(null, '', '{{ route("login") }}');
        }

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';

            if (isPassword) {
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>`;
            } else {
                btn.innerHTML = `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
            }
        }

        function fillAdminCreds() {
            const emailInput = document.getElementById('login-email');
            const passInput = document.getElementById('login-password');
            if (emailInput) emailInput.value = 'admin@toonburger.com';
            if (passInput) passInput.value = 'Password123';
        }
    </script>
</body>
</html>

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

                <!-- Mascot & Text inside Arc (Enlarged & Raised) -->
                <div class="absolute inset-0 flex flex-col items-center justify-start pt-2 sm:pt-2.5 lg:pt-3">
                    <img src="{{ asset('images/toonburger-logo-white.png') }}" 
                         alt="Toon Burger" 
                         class="h-20 sm:h-24 lg:h-26 w-auto object-contain drop-shadow-md -translate-y-1 sm:-translate-y-2">
                </div>
            </div>
        </div>

        <!-- STATIONARY BURGERS (4 BURGERS AS IN MOCKUP - NO ANIMATION) -->
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

        <!-- CENTER BRAND HEADLINE (ENLARGED EXACTLY ACCORDING TO USER REQUEST) -->
        <div class="my-auto py-8 sm:py-10 px-4 sm:px-6 text-center relative z-20">
            <h1 class="font-brand text-5xl sm:text-6xl md:text-6xl lg:text-[76px] xl:text-[88px] leading-[1.0] text-[#466967] tracking-wider uppercase drop-shadow-xs">
                EAT GOOD.<br>
                FEEL GOOD.<br>
                LIVE GOOD.
            </h1>
        </div>

        <!-- BOTTOM CHECKERBOARD & SINCE 2024 -->
        <div class="w-full relative z-20 pt-2 pb-5">
            <!-- 2-row Checkerboard pattern -->
            <div class="w-full h-8 checkerboard-pattern opacity-90"></div>
            <!-- -Since 2024- -->
            <div class="text-center pt-3 text-xs font-semibold text-[#466967]/80 tracking-widest uppercase">
                -Since 2024-
            </div>
        </div>

    </div>

    <!-- ═══ RIGHT PANEL: WHITE FORM CARD (EXACTLY MATCHING MOCKUP) ═══ -->
    <div class="w-full md:w-[53%] lg:w-[53%] min-h-screen md:h-screen bg-white md:rounded-tl-[48px] md:rounded-bl-[48px] shadow-2xl flex flex-col justify-center items-center px-7 sm:px-14 lg:px-20 xl:px-28 py-10 md:py-16 overflow-y-auto relative z-10">

        <div class="w-full max-w-sm sm:max-w-md mx-auto">

            <!-- FLASH ALERTS -->
            @if(session('success'))
                <div class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-[#FFF1F0] border border-red-200/80 text-toon-rust text-xs font-semibold rounded-2xl flex items-center gap-2.5 shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 shrink-0"></span>
                    <span class="font-bold">
                        @if($errors->has('username') || $errors->has('password'))
                            Username atau password yang dimasukkan salah.
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
                    <p class="text-xs sm:text-sm text-gray-400 font-normal mt-1">Please enter your detail first</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="login">

                    <!-- Username (Filled Light-Blue Style As In Photo) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1.5">Username</label>
                        <input type="text" 
                               name="username" 
                               id="login-username" 
                               required 
                               placeholder="Enter Your username" 
                               value="{{ old('form_type') === 'login' ? old('username') : (old('username') ?: 'admin') }}" 
                               class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-lg px-4 py-3 text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#466967] transition">
                    </div>

                    <!-- Password (Filled Light-Blue Style With Eye Toggle As In Photo) -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1.5">Password</label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="login-password" 
                                   required 
                                   placeholder="Enter Your Password" 
                                   value="Password123"
                                   class="w-full bg-[#EBF2FE] hover:bg-[#E3EDFE] focus:bg-white border border-transparent focus:border-[#466967] rounded-lg pl-4 pr-11 py-3 text-xs sm:text-sm text-gray-900 font-medium placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-[#466967] transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('login-password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" 
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
                        <label class="flex items-center gap-2 cursor-pointer select-none text-gray-700 font-normal">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#466967] focus:ring-[#466967] border-gray-300">
                            <span>Remember Me</span>
                        </label>
                        <a href="javascript:void(0)" onclick="alert('Silakan hubungi administrator atau gunakan kredensial demo admin: admin@toonburger.com / Password123')" class="text-xs text-gray-500 hover:text-[#466967] font-normal transition">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Login Button (EXACT MATCH #466967) -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-bold py-3.5 px-6 rounded-lg shadow-sm transition active:scale-98 text-sm flex items-center justify-center gap-2">
                            <span>Login</span>
                        </button>
                    </div>

                    <!-- Toggle to Register -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        Don't have an account? 
                        <button type="button" onclick="switchToRegister()" class="text-[#466967] hover:underline font-bold ml-1">
                            Sign Up Now
                        </button>
                    </p>

                    <!-- Quick Admin Login Pill -->
                    <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-[11px] text-gray-400">
                        <span>Demo Admin:</span>
                        <button type="button" onclick="fillAdminCreds()" class="bg-[#FAF1E1] hover:bg-[#F1D9B3] text-[#466967] px-3 py-1 rounded-full font-bold border border-[#466967]/20 transition">
                            admin@toonburger.com
                        </button>
                    </div>
                </form>
            </div>

            <!-- ── 2. CREATE ACCOUNT FORM ("Create Account") ── -->
            <div id="register-form-panel" class="{{ $currentMode === 'register' ? 'block' : 'hidden' }} transition-all duration-300">
                <div class="mb-7">
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Create Account</h2>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="form_type" value="register">

                    <!-- Username -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1">Username</label>
                        <div class="relative">
                            <input type="text" 
                                   name="username" 
                                   required 
                                   placeholder="Enter Your username" 
                                   value="{{ old('form_type') === 'register' ? old('username') : '' }}" 
                                   class="w-full bg-gray-50/60 hover:bg-gray-50 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-lg p-3 pr-10 text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none transition">
                            <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1">Email</label>
                        <input type="email" 
                               name="email" 
                               required 
                               placeholder="Enter Your Email" 
                               value="{{ old('form_type') === 'register' ? old('email') : '' }}" 
                               class="w-full bg-gray-50/60 hover:bg-gray-50 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-lg p-3 text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none transition">
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1">Mobile Number</label>
                        <input type="text" 
                               name="phone_number" 
                               placeholder="Enter Your Mobile Number" 
                               value="{{ old('form_type') === 'register' ? old('phone_number') : '' }}" 
                               class="w-full bg-gray-50/60 hover:bg-gray-50 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-lg p-3 text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none transition">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-800 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" 
                                   name="password" 
                                   id="register-password" 
                                   required 
                                   placeholder="Enter Your Password" 
                                   class="w-full bg-gray-50/60 hover:bg-gray-50 focus:bg-white border border-gray-200 focus:border-[#466967] rounded-lg p-3 pr-10 text-xs sm:text-sm text-gray-900 placeholder-gray-400 focus:outline-none transition">
                            <button type="button" 
                                    onclick="togglePasswordVisibility('register-password', this)" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" 
                                    aria-label="Tampilkan Password">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Sign Up Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full bg-[#466967] hover:bg-[#344E4C] text-white font-semibold py-3.5 px-6 rounded-lg shadow-sm transition active:scale-98 text-sm flex items-center justify-center gap-2">
                            <span>Sign Up</span>
                        </button>
                    </div>

                    <!-- Toggle to Login -->
                    <p class="text-center text-xs text-gray-500 pt-2">
                        Already have an account? 
                        <button type="button" onclick="switchToLogin()" class="text-[#466967] hover:underline font-semibold ml-1">
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
            document.getElementById('login-username').value = 'admin@toonburger.com';
            document.getElementById('login-password').value = 'Password123';
        }
    </script>
</body>
</html>

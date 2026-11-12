<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Toon Burger</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Google Fonts: Bebas Neue, Luckiest Guy, Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Luckiest+Guy&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/errors.css') }}?v={{ filemtime(public_path('css/errors.css')) }}">
</head>
<body class="relative min-h-screen flex flex-col justify-between retro-grid-bg">

    <!-- Floating Comic Sparkles -->
    <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="sparkle" style="top: 12%; left: 8%; width: 28px;">
    <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="sparkle" style="top: 20%; right: 10%; width: 24px; animation-delay: 1s;">
    <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="sparkle" style="bottom: 15%; left: 12%; width: 30px; animation-delay: 0.5s;">
    <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="sparkle" style="bottom: 22%; right: 12%; width: 22px; animation-delay: 1.5s;">

    <!-- Main 404 Error Content -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="w-full max-w-5xl">

            <!-- Comic Card Container -->
            <div class="bg-white rounded-[28px] sm:rounded-[34px] border-2 border-[#121212] shadow-[6px_6px_0px_#253B36] sm:shadow-[8px_8px_0px_#253B36] overflow-hidden">

                <!-- Top Checkerboard Diner Accent -->
                <div class="h-3 w-full checkerboard-strip border-b-2 border-[#121212]" aria-hidden="true"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">

                    <!-- Left Visual Stage: Toon Burger Lost Page -->
                    <div class="lg:col-span-5 h-full bg-[#385850] text-white px-6 py-8 sm:px-8 sm:py-10 flex flex-col items-center justify-center relative overflow-hidden border-b-2 lg:border-b-0 lg:border-r-2 border-[#121212]">

                        <!-- Subtle Wavy Background Lines -->
                        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 400 400" aria-hidden="true">
                            <path d="M-40,70 C80,30 180,120 320,60 C380,35 420,80 450,70" fill="none" stroke="#FFFFFF" stroke-width="1.5"/>
                            <path d="M-40,160 C80,120 180,210 320,150 C380,125 420,170 450,160" fill="none" stroke="#FFFFFF" stroke-width="1.5"/>
                            <path d="M-40,250 C80,210 180,300 320,240 C380,215 420,260 450,250" fill="none" stroke="#FFFFFF" stroke-width="1.5"/>
                            <path d="M-40,340 C80,300 180,390 320,330 C380,305 420,350 450,340" fill="none" stroke="#FFFFFF" stroke-width="1.5"/>
                        </svg>

                        <!-- Decorative Sparkles -->
                        <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="absolute top-6 left-6 w-5 h-5 select-none pointer-events-none">
                        <img src="{{ asset('images/star-sparkle.png') }}" alt="" aria-hidden="true" class="absolute bottom-8 right-6 w-6 h-6 select-none pointer-events-none">

                        <!-- Error 404 Comic Pill -->
                        <div class="relative z-10 inline-flex items-center gap-2 bg-[#D92625] text-white font-extrabold text-xs uppercase tracking-widest px-4 py-1.5 rounded-full border-2 border-[#121212] shadow-[3px_3px_0px_#121212] mb-5">
                            <span class="w-2 h-2 rounded-full bg-[#FFC72C]" aria-hidden="true"></span>
                            <span>Error 404 &bull; Halaman Hilang</span>
                        </div>

                        <!-- Floating Mascot -->
                        <div class="relative z-10 flex flex-col items-center pt-2">
                            <img src="{{ asset('images/toon-head.png') }}"
                                 alt="Maskot Toon Burger saat halaman tidak ditemukan"
                                 width="180"
                                 height="180"
                                 class="w-32 sm:w-40 h-auto object-contain anim-burger-float drop-shadow-[0_12px_18px_rgba(0,0,0,0.35)]">
                        </div>

                        <!-- Giant 404 Number -->
                        <div class="relative z-10 mt-3 text-center">
                            <p class="font-toon-display text-6xl sm:text-7xl text-[#FFC72C] leading-none drop-shadow-[3px_3px_0px_#121212]"
                               aria-hidden="true">
                                404
                            </p>
                            <p class="text-xs font-semibold text-white/85 uppercase tracking-widest mt-1">
                                Page Not Found
                            </p>
                        </div>
                    </div>

                    <!-- Right Content Side: Copy & Action Buttons -->
                    <div class="lg:col-span-7 p-6 sm:p-9 lg:p-11 flex flex-col justify-center text-center lg:text-left">
                        <div>
                            <span class="inline-block bg-[#FAF5E8] text-[#253B36] border border-[#253B36]/25 rounded-full px-3.5 py-1 text-xs font-bold uppercase tracking-wider mb-4">
                                Halaman Tidak Ditemukan
                            </span>
                        </div>

                        <h1 class="font-toon-display text-3xl sm:text-4xl lg:text-[42px] text-[#121212] uppercase leading-[1.08]">
                            Waduh! Burger Yang Kamu Cari Nyasar!
                        </h1>

                        <p class="mt-4 text-sm sm:text-[15px] text-gray-700 leading-relaxed max-w-xl mx-auto lg:mx-0">
                            Halaman atau alamat yang kamu tuju di <strong class="text-[#253B36]">Toon Burger</strong> tidak tersedia atau sudah dipindahkan. Yuk balik ke beranda atau langsung cek menu favorit kami!
                        </p>

                        <!-- Action Buttons -->
                        <div class="mt-7 flex flex-col sm:flex-row items-stretch sm:items-center justify-center lg:justify-start gap-3">
                            <a href="{{ route('home') }}"
                               class="min-h-[46px] inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#FFC72C] hover:bg-[#E8A400] text-[#121212] font-bold text-sm border-2 border-[#121212] shadow-[3px_3px_0px_#121212] active:translate-x-[1px] active:translate-y-[1px] active:shadow-[2px_2px_0px_#121212] transition whitespace-nowrap">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span>Kembali ke Beranda</span>
                            </a>

                            <a href="{{ route('menu') }}"
                               class="min-h-[46px] inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-[#385850] hover:bg-[#253B36] text-white font-bold text-sm border-2 border-[#121212] shadow-[3px_3px_0px_#121212] active:translate-x-[1px] active:translate-y-[1px] active:shadow-[2px_2px_0px_#121212] transition whitespace-nowrap">
                                <span>Jelajahi Menu</span>
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- Compact Toon Burger Footer -->
    <footer class="relative z-10 bg-[#253B36] text-white/85 py-4 px-4 text-center text-xs border-t-2 border-[#121212]">
        <p>&copy; {{ date('Y') }} <strong class="text-[#FFC72C]">TOON BURGER</strong> &bull; Setiap Gigitan Punya Cerita!</p>
    </footer>

</body>
</html>

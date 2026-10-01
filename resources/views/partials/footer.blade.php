<footer class="relative text-white mt-16 sm:mt-24 pt-14 sm:pt-16 pb-8 select-none overflow-hidden" style="background-color: #3b5c56;">
    <!-- Topographic Contour Lines Background -->
    <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20 select-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 400" fill="none">
        <path d="M-100 120 C 150 160, 350 70, 600 110 C 850 150, 1050 80, 1300 130" stroke="rgba(255,255,255,0.25)" stroke-width="1.2"/>
        <path d="M-100 190 C 180 230, 400 140, 650 180 C 900 220, 1100 150, 1300 200" stroke="rgba(255,255,255,0.25)" stroke-width="1.2"/>
        <path d="M-100 260 C 200 310, 420 210, 700 250 C 950 290, 1120 220, 1300 270" stroke="rgba(255,255,255,0.25)" stroke-width="1.2"/>
        <path d="M-100 330 C 220 370, 450 290, 750 320 C 1000 350, 1150 300, 1300 340" stroke="rgba(255,255,255,0.25)" stroke-width="1.2"/>
        <path d="M150 450 C 320 320, 550 290, 780 350 C 930 400, 1050 450, 1180 500" stroke="rgba(255,255,255,0.2)" stroke-width="1.2"/>
        <path d="M280 430 C 420 360, 600 340, 740 380 C 850 420, 950 450, 1050 470" stroke="rgba(255,255,255,0.18)" stroke-width="1.2"/>
        <path d="M400 420 C 500 380, 630 370, 710 400 C 780 430, 850 450, 920 460" stroke="rgba(255,255,255,0.15)" stroke-width="1.2"/>
    </svg>

    <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-8 lg:px-10">
        <!-- Main Footer Columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-10 md:gap-8 lg:gap-12 items-start mb-12 sm:mb-14">

            <!-- Column 1: Brand Mascot Head & TOON BURGER -->
            <div class="sm:col-span-2 md:col-span-3 flex flex-col items-center md:items-start justify-start">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center text-center">
                    <img src="{{ asset('images/toon-head.png') }}"
                         alt="Toon Burger Mascot"
                         class="h-20 sm:h-24 w-auto object-contain mb-3 transition transform group-hover:scale-105 duration-200">
                    <span class="font-black text-white text-xl sm:text-2xl uppercase tracking-wider block leading-tight"
                          style="font-family: 'Nunito', 'Arial Black', sans-serif; letter-spacing: 0.05em;">
                        TOON BURGER
                    </span>
                </a>
            </div>

            <!-- Column 2: NAVIGASI -->
            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    NAVIGASI
                </h4>
                <ul class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('menu') }}" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Menu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: SOSIAL -->
            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    SOSIAL
                </h4>
                <ul class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white">
                    <li>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Tiktok
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('whatsapp') }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Whatsapp
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: JAM BUKA -->
            <div class="md:col-span-5">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    JAM BUKA
                </h4>
                <div class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white">
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="text-white font-normal">Senin:</span>
                        <span class="text-white font-normal text-right">Libur/Tutup</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="text-white font-normal">Selasa-Jumat:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:00 WITA</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="text-white font-normal">Sabtu:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:30 WITA</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="text-white font-normal">Minggu:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:00 WITA</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Horizontal Divider Line -->
        <div class="w-full border-t border-white/20 pt-6 sm:pt-7 text-center">
            <p class="text-xs sm:text-sm text-white/80 font-normal tracking-wide">
                © 2026 Toon Burger. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

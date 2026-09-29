<!-- FOOTER (PERSIS FOTO media_1790644528320.png) -->
<footer class="text-white mt-16 sm:mt-24 pt-14 sm:pt-16 pb-8 select-none" style="background-color: #40605e;">
    <div class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-10">
        <!-- Main Footer Columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-10 md:gap-8 lg:gap-12 items-start mb-12 sm:mb-14">

            <!-- Column 1: Brand Mascot Head & TOON BURGER (Centered vertically stacked) -->
            <div class="sm:col-span-2 md:col-span-3 flex flex-col items-center justify-start text-center">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center">
                    <img src="{{ asset('images/toon-head.png') }}"
                         alt="Toon Burger Mascot"
                         class="h-20 sm:h-24 w-auto object-contain mb-3 transition transform group-hover:scale-105 duration-200">
                    <span class="font-black text-white text-xl sm:text-2xl uppercase tracking-wider block leading-tight"
                          style="font-family: 'Nunito', 'Arial Black', sans-serif; letter-spacing: 0.05em;">
                        TOON BURGER
                    </span>
                </a>
            </div>

            <!-- Column 2: JAM BUKA (Day on left, Time right-aligned) -->
            <div class="md:col-span-5">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    JAM BUKA
                </h4>
                <div class="space-y-3 sm:space-y-3.5 text-sm sm:text-[15px] font-normal text-white">
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="font-bold text-white">Senin:</span>
                        <span class="text-white font-normal text-right">Libur/Tutup</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="font-bold text-white">Selasa-Jumat:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:00 WITA</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="font-bold text-white">Sabtu:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:30 WITA</span>
                    </div>
                    <div class="flex justify-between items-center gap-4 sm:gap-8">
                        <span class="font-bold text-white">Minggu:</span>
                        <span class="text-white font-normal text-right">17:00 - 22:00 WITA</span>
                    </div>
                </div>
            </div>

            <!-- Column 3: NAVIGASI -->
            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    NAVIGASI
                </h4>
                <ul class="space-y-3 sm:space-y-3.5 text-sm sm:text-[15px] font-normal text-white">
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
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-[#F5C537] transition duration-150 inline-block">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: SOSIAL -->
            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5C537] uppercase tracking-wider mb-4 sm:mb-5">
                    SOSIAL
                </h4>
                <ul class="space-y-3 sm:space-y-3.5 text-sm sm:text-[15px] font-normal text-white">
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

        </div>

        <!-- Horizontal Divider Line (#597472 border) -->
        <div class="w-full border-t border-[#597472] pt-6 sm:pt-7 text-center">
            <!-- Centered Copyright Notice -->
            <p class="text-xs sm:text-sm text-white/80 font-normal tracking-wide">
                © 2026 Toon Burger. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

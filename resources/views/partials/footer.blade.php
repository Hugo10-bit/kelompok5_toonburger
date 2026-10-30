<footer class="relative text-white mt-0 pt-14 sm:pt-16 pb-8 select-none overflow-hidden" style="background-color: #405E58;">
    <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-15 select-none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 400" fill="none">
        <path d="M-100 80 C 180 140, 420 40, 680 90 C 920 140, 1080 60, 1300 110" stroke="#ffffff" stroke-width="1.2"/>
        <path d="M-100 150 C 180 210, 420 110, 680 160 C 920 210, 1080 130, 1300 180" stroke="#ffffff" stroke-width="1.2"/>
        <path d="M-100 220 C 200 280, 440 180, 700 230 C 950 280, 1100 200, 1300 250" stroke="#ffffff" stroke-width="1.2"/>
        <path d="M-100 290 C 220 350, 460 260, 740 300 C 990 340, 1140 270, 1300 320" stroke="#ffffff" stroke-width="1.2"/>
        <ellipse cx="610" cy="360" rx="180" ry="70" stroke="#ffffff" stroke-width="1.1"/>
        <ellipse cx="610" cy="360" rx="120" ry="45" stroke="#ffffff" stroke-width="1.1"/>
        <ellipse cx="610" cy="360" rx="65" ry="22" stroke="#ffffff" stroke-width="1.1"/>
    </svg>

    <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-10 md:gap-8 lg:gap-10 items-start mb-12 sm:mb-14">

            <div class="sm:col-span-2 md:col-span-4 flex flex-col items-center md:items-start justify-start">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center text-center">
                    <img src="{{ asset('images/toon-head.png') }}"
                         alt="Toon Burger Mascot"
                         class="h-24 sm:h-28 w-auto object-contain mb-2 transition transform group-hover:scale-105 duration-200">
                    <span class="text-white text-3xl sm:text-[34px] uppercase tracking-wider block leading-none"
                          style="font-family: 'Bebas Neue', sans-serif; letter-spacing: 0.04em;">
                        TOON BURGER
                    </span>
                </a>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5B82E] uppercase tracking-wide mb-4">
                    NAVIGASI
                </h4>
                <ul class="space-y-2.5 text-sm sm:text-[15px] font-normal text-white">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Beranda
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('menu') }}" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Menu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Tentang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5B82E] uppercase tracking-wide mb-4">
                    SOSIAL
                </h4>
                <ul class="space-y-2.5 text-sm sm:text-[15px] font-normal text-white">
                    <li>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Tiktok
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('whatsapp') }}" target="_blank" rel="noopener noreferrer" class="hover:text-[#F5B82E] transition duration-150 inline-block">
                            Whatsapp
                        </a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-4">
                <h4 class="text-base sm:text-[17px] font-bold text-[#F5B82E] uppercase tracking-wide mb-4">
                    JAM BUKA
                </h4>
                <div class="space-y-2.5 text-sm sm:text-[15px] font-normal text-white">
                    <div>Senin: &nbsp;(Tutup)</div>
                    <div>Selasa-Jumat: &nbsp;(17:00 - 22:00 WITA)</div>
                    <div>Sabtu-Minggu: &nbsp;(17:00 - 22:30 WITA)</div>
                </div>
            </div>

        </div>

        <div class="w-full border-t border-white/60 pt-5 text-center">
            <p class="text-xs sm:text-[13px] text-white/90 font-normal tracking-wide">
                © 2026 Toon Burger. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>

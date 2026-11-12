<footer class="relative w-full pt-12 sm:pt-16 md:pt-20 bg-transparent select-none" style="content-visibility: auto; contain-intrinsic-size: 1px 360px;">
    <!-- Main Dark Forest Green Card with Rounded Top matching design reference -->
    <div class="relative bg-[#253B36] rounded-t-[36px] sm:rounded-t-[48px] lg:rounded-t-[56px] text-white pt-14 sm:pt-16 lg:pt-20 pb-10 sm:pb-12 shadow-[0_-10px_35px_rgba(0,0,0,0.06)]">

        <!-- Topographic Contour Lines Background -->
        <div class="absolute inset-0 rounded-t-[36px] sm:rounded-t-[48px] lg:rounded-t-[56px] overflow-hidden pointer-events-none">
            <svg class="absolute inset-0 w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 400" fill="none">
                <!-- Concentric circular & wavy contours radiating around center & mascot -->
                <ellipse cx="600" cy="80" rx="260" ry="120" stroke="rgba(255,255,255,0.22)" stroke-width="1.2"/>
                <ellipse cx="600" cy="80" rx="380" ry="170" stroke="rgba(255,255,255,0.18)" stroke-width="1.2"/>
                <ellipse cx="600" cy="80" rx="520" ry="230" stroke="rgba(255,255,255,0.15)" stroke-width="1.2"/>
                <path d="M-100 140 C 200 180, 420 90, 600 120 C 780 150, 1000 80, 1300 140" stroke="rgba(255,255,255,0.22)" stroke-width="1.2"/>
                <path d="M-100 230 C 180 270, 420 180, 600 220 C 780 260, 1020 170, 1300 230" stroke="rgba(255,255,255,0.20)" stroke-width="1.2"/>
                <path d="M-100 320 C 220 370, 450 280, 600 310 C 750 340, 980 270, 1300 330" stroke="rgba(255,255,255,0.16)" stroke-width="1.2"/>
                <path d="M120 420 C 320 320, 500 300, 700 330 C 900 360, 1080 430, 1280 440" stroke="rgba(255,255,255,0.14)" stroke-width="1.2"/>
            </svg>
        </div>

        <!-- Mascot Head: overlaps the top rounded border, centered -->
        <div class="absolute -top-12 sm:-top-16 lg:-top-20 left-1/2 -translate-x-1/2 z-20 pointer-events-auto">
            <a href="{{ route('home') }}" class="group block transition transform hover:scale-105 duration-200">
                <img src="{{ asset('images/toon-head.png') }}"
                     alt="Toon Burger Mascot"
                     loading="lazy"
                     decoding="async"
                     width="160"
                     height="160"
                     class="w-24 sm:w-32 md:w-36 lg:w-40 h-auto object-contain drop-shadow-[0_8px_16px_rgba(0,0,0,0.25)]">
            </a>
        </div>

        <!-- Content Area -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-10 lg:px-12">

            <!-- Title "TOON BURGER" centered under mascot -->
            <div class="text-center mb-10 sm:mb-12">
                <a href="{{ route('home') }}" class="inline-block group">
                    <h2 class="font-normal text-white text-3xl sm:text-4xl lg:text-[44px] uppercase tracking-[0.06em] leading-tight group-hover:text-[#EBD8A4] transition duration-150"
                        style="font-family: 'Bebas Neue', sans-serif;">
                        TOON BURGER
                    </h2>
                </a>
            </div>

            <!-- Columns: Navigasi & Sosial (Left), Jam Buka (Right) -->
            <div class="grid grid-cols-2 sm:grid-cols-12 gap-8 sm:gap-10 lg:gap-16 items-start">

                <!-- Left Group: Navigasi -->
                <div class="col-span-1 sm:col-span-3 lg:col-span-3">
                    <h3 data-i18n-app="footer_nav" class="text-base sm:text-[17px] font-bold text-[#EBD8A4] uppercase tracking-wider mb-4 sm:mb-5">
                        NAVIGASI
                    </h3>
                    <ul class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white/95">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-[#EBD8A4] transition duration-150 inline-block">
                                <span data-i18n-app="nav_home">Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu') }}" class="hover:text-[#EBD8A4] transition duration-150 inline-block">
                                <span data-i18n-app="nav_menu">Menu</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:text-[#EBD8A4] transition duration-150 inline-block">
                                <span data-i18n-app="nav_about">Tentang</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:text-[#EBD8A4] transition duration-150 inline-block">
                                <span data-i18n-app="nav_contact">Kontak</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Middle Group: Sosial -->
                <div class="col-span-1 sm:col-span-4 lg:col-span-4">
                    <h3 class="text-base sm:text-[17px] font-bold text-[#EBD8A4] uppercase tracking-wider mb-4 sm:mb-5">
                        SOSIAL
                    </h3>
                    <ul class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white/95">
                        <li>
                            <a href="https://www.instagram.com/toonburger.id?rpxt=ZDNlZDc0MzIxNw=="
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex items-center justify-between w-32 sm:w-36 hover:text-[#EBD8A4] transition duration-150">
                                <span>Instagram</span>
                                <svg class="w-3.5 h-3.5 text-white/70 group-hover:text-[#EBD8A4] transition duration-150 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('whatsapp') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex items-center justify-between w-32 sm:w-36 hover:text-[#EBD8A4] transition duration-150">
                                <span>Whatsapp</span>
                                <svg class="w-3.5 h-3.5 text-white/70 group-hover:text-[#EBD8A4] transition duration-150 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@toonburger.id?is_from_webapp=1&sender_device=pc"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex items-center justify-between w-32 sm:w-36 hover:text-[#EBD8A4] transition duration-150">
                                <span>Tiktok</span>
                                <svg class="w-3.5 h-3.5 text-white/70 group-hover:text-[#EBD8A4] transition duration-150 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gofood') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="group flex items-center justify-between w-32 sm:w-36 hover:text-[#EBD8A4] transition duration-150">
                                <span>Gojek</span>
                                <svg class="w-3.5 h-3.5 text-white/70 group-hover:text-[#EBD8A4] transition duration-150 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Right Group: Jam Buka -->
                <div class="col-span-2 sm:col-span-5 lg:col-span-5">
                    <h3 data-i18n-app="footer_hours" class="text-base sm:text-[17px] font-bold text-[#EBD8A4] uppercase tracking-wider mb-4 sm:mb-5">
                        JAM BUKA
                    </h3>
                    <div class="space-y-2.5 sm:space-y-3 text-sm sm:text-[15px] font-normal text-white/95">
                        <p class="leading-relaxed">
                            <span>Senin:</span>
                            <span class="ml-2 font-light text-white/90">(Tutup)</span>
                        </p>
                        <p class="leading-relaxed">
                            <span>Selasa-Jumat:</span>
                            <span class="ml-2 font-light text-white/90">(17:00 - 22:00 WITA)</span>
                        </p>
                        <p class="leading-relaxed">
                            <span>Sabtu-Minggu:</span>
                            <span class="ml-2 font-light text-white/90">(17:00 - 22:30 WITA)</span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Divider Line & Copyright -->
            <div class="w-full border-t border-white/15 mt-12 sm:mt-14 pt-6 sm:pt-7 text-center">
                <p class="text-xs sm:text-sm text-white/80 font-normal tracking-wide">
                    &copy; 2026 Toon Burger. All Rights Reserved.
                </p>
            </div>

        </div>
    </div>
</footer>

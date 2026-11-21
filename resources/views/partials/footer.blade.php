<footer class="relative w-full pt-12 sm:pt-16 md:pt-20 select-none @yield('footer_bg', 'retro-grid-bg')">
    <!-- Main Dark Forest Green Card with Rounded Top matching design reference -->
    <div class="relative bg-[#253B36] rounded-t-[36px] sm:rounded-t-[48px] lg:rounded-t-[56px] text-white pt-14 sm:pt-16 lg:pt-20 pb-10 sm:pb-12 shadow-[0_-10px_35px_rgba(0,0,0,0.06)] pointer-events-auto">

        <!-- SVG Pattern Background -->
        <div class="absolute inset-0 rounded-t-[36px] sm:rounded-t-[48px] lg:rounded-t-[56px] overflow-hidden pointer-events-none">
            <img src="{{ asset('images/footer-pattern.svg') }}"
                 alt=""
                 aria-hidden="true"
                 class="absolute inset-0 w-full h-full object-cover object-top pointer-events-none select-none"
                 loading="lazy">
        </div>

        <!-- Mascot Head: overlaps the top rounded border, centered -->
        <div class="absolute -top-12 sm:-top-16 lg:-top-20 left-1/2 -translate-x-1/2 z-20 pointer-events-auto">
            <a href="{{ route('home') }}" class="group block transition transform hover:scale-105 duration-300">
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
                    <h2 class="font-normal text-white text-3xl sm:text-4xl lg:text-[44px] uppercase tracking-[0.06em] leading-tight group-hover:underline underline-offset-4 transition duration-300"
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
                            <a href="{{ route('home') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_home">Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_menu">Menu</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_about">Tentang</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
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
                               class="group flex items-center justify-between w-full max-w-[144px] transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Instagram</span>
                                <svg class="w-3.5 h-3.5 text-white/70 transition duration-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                               class="group flex items-center justify-between w-full max-w-[144px] transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Whatsapp</span>
                                <svg class="w-3.5 h-3.5 text-white/70 transition duration-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                               class="group flex items-center justify-between w-full max-w-[144px] transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Tiktok</span>
                                <svg class="w-3.5 h-3.5 text-white/70 transition duration-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                               class="group flex items-center justify-between w-full max-w-[144px] transition duration-300">
                                <span class="group-hover:underline underline-offset-4">GoFood</span>
                                <svg class="w-3.5 h-3.5 text-white/70 transition duration-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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

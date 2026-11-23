<footer class="tb-footer relative w-full select-none @yield('footer_bg', 'retro-grid-bg')">
    <style>
        .tb-footer {
            padding-top: 76px;
        }
        .tb-footer-card {
            position: relative;
            background-color: #273A39;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            color: #FFFFFF;
            box-shadow: 0 -10px 35px rgba(0, 0, 0, 0.06);
        }
        .tb-footer-pattern-wrap {
            position: absolute;
            inset: 0;
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
            overflow: hidden;
            pointer-events: none;
        }
        .tb-footer-mascot {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%, -65.28%);
            z-index: 20;
            width: 114px;
        }
        .tb-footer-mascot img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
        }
        .tb-footer-inner {
            position: relative;
            z-index: 10;
            width: 100%;
            padding: 50px 24px 22px;
        }
        .tb-footer-brand {
            text-align: center;
            margin-bottom: 28px;
        }
        .tb-footer-brand-title {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            color: #FFFFFF;
            font-size: 38px;
            line-height: 0.88;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            margin: 0;
        }
        .tb-footer-cols {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 28px 24px;
            align-items: start;
        }
        .tb-footer-col-hours {
            grid-column: span 2 / span 2;
        }
        .tb-footer-heading {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #F5C537;
            font-size: 18px;
            line-height: 1.1;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin: 0 0 18px 0;
        }
        .tb-footer-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 400;
            line-height: 1.25;
            color: rgba(255, 255, 255, 0.95);
        }
        .tb-footer-social-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 118px;
            color: inherit;
            text-decoration: none;
        }
        .tb-footer-social-icon {
            width: 13px;
            height: 13px;
            color: rgba(255, 255, 255, 0.9);
            flex-shrink: 0;
        }
        .tb-footer-hours-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 400;
            line-height: 1.3;
            color: rgba(255, 255, 255, 0.95);
        }
        .tb-footer-hours-row {
            margin: 0;
            white-space: nowrap;
        }
        .tb-footer-divider-wrap {
            width: 100%;
            margin-top: 48px;
        }
        .tb-footer-divider {
            width: 100%;
            border-top: 1px solid #D9DADA;
        }
        .tb-footer-copy {
            text-align: center;
            margin: 18px 0 0 0;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 400;
            line-height: 1.25;
            color: rgba(255, 255, 255, 0.92);
        }

        @media (min-width: 640px) {
            .tb-footer {
                padding-top: 90px;
            }
            .tb-footer-card {
                border-top-left-radius: 52px;
                border-top-right-radius: 52px;
            }
            .tb-footer-mascot {
                width: 132px;
            }
            .tb-footer-inner {
                padding: 58px 36px 24px;
            }
            .tb-footer-cols {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
            .tb-footer-col-hours {
                grid-column: span 1 / span 1;
            }
        }

        /* Exact 1:1 Desktop Layout & Proportions matching reference PNG */
        @media (min-width: 1024px) {
            .tb-footer {
                padding-top: clamp(80px, 7.8vw, 130px);
            }
            .tb-footer-card {
                border-top-left-radius: clamp(63px, 6.15vw, 80px);
                border-top-right-radius: clamp(63px, 6.15vw, 80px);
            }
            .tb-footer-mascot {
                width: clamp(135px, 13vw, 220px);
            }
            .tb-footer-inner {
                padding: 0 0 clamp(20px, 1.95vw, 34px) 0;
            }
            .tb-footer-brand {
                position: absolute;
                top: clamp(52px, 5.1vw, 86px);
                left: 50%;
                transform: translateX(-50%);
                margin: 0;
                z-index: 15;
                white-space: nowrap;
            }
            .tb-footer-brand-title {
                font-size: clamp(40px, 3.9vw, 68px);
                line-height: 0.82;
                letter-spacing: 0.02em;
            }
            .tb-footer-cols {
                display: flex;
                align-items: flex-start;
                width: 100%;
                padding: clamp(92px, 8.98vw, 156px) 3.81% 0 5.27%;
            }
            .tb-footer-col-nav {
                width: 14.65vw;
                flex-shrink: 0;
            }
            .tb-footer-col-social {
                flex-shrink: 0;
            }
            .tb-footer-col-hours {
                margin-left: auto;
                flex-shrink: 0;
            }
            .tb-footer-heading {
                font-size: clamp(16px, 1.4vw, 24px);
                line-height: 1;
                letter-spacing: 0.015em;
                margin-bottom: clamp(18px, 1.7vw, 28px);
            }
            .tb-footer-col-hours .tb-footer-heading {
                margin-bottom: clamp(20px, 1.9vw, 32px);
            }
            .tb-footer-list {
                font-size: clamp(13.5px, 1.15vw, 19px);
                line-height: 1.2;
                gap: clamp(10px, 0.95vw, 16px);
            }
            .tb-footer-social-link {
                width: clamp(96px, 9.2vw, 155px);
            }
            .tb-footer-social-icon {
                width: clamp(11px, 1vw, 16px);
                height: clamp(11px, 1vw, 16px);
            }
            .tb-footer-hours-list {
                font-size: clamp(14.5px, 1.28vw, 21.5px);
                line-height: 1.22;
                gap: clamp(16px, 1.55vw, 26px);
            }
            .tb-footer-divider-wrap {
                margin-top: clamp(76px, 7.42vw, 129px);
                padding: 0 3.03%;
            }
            .tb-footer-copy {
                margin-top: clamp(20px, 1.95vw, 34px);
                font-size: clamp(12.5px, 1.22vw, 21px);
            }
        }
    </style>

    <!-- Main Dark Forest Green Card with Rounded Top matching design reference -->
    <div class="tb-footer-card pointer-events-auto">

        <!-- SVG/WebP Pattern Background -->
        <div class="tb-footer-pattern-wrap">
            <img src="{{ asset('images/footer-pattern.webp') }}"
                 alt=""
                 aria-hidden="true"
                 class="absolute inset-0 w-full h-full object-cover object-top pointer-events-none select-none"
                 loading="lazy">
        </div>

        <!-- Mascot Head: overlaps the top rounded border, centered -->
        <div class="tb-footer-mascot pointer-events-auto">
            <a href="{{ route('home') }}" class="group block transition transform hover:scale-105 duration-300">
                <img src="{{ asset('images/toon-head.png') }}"
                     alt="Toon Burger Mascot"
                     loading="lazy"
                     decoding="async"
                     width="283"
                     height="253">
            </a>
        </div>

        <!-- Content Area -->
        <div class="tb-footer-inner">

            <!-- Title "TOON BURGER" centered under mascot -->
            <div class="tb-footer-brand">
                <a href="{{ route('home') }}" class="inline-block no-underline">
                    <h2 class="tb-footer-brand-title">
                        TOON BURGER
                    </h2>
                </a>
            </div>

            <!-- Columns: Navigasi & Sosial (Left), Jam Buka (Right) -->
            <div class="tb-footer-cols">

                <!-- Left Group: Navigasi -->
                <div class="tb-footer-col-nav">
                    <h3 data-i18n-app="footer_nav" class="tb-footer-heading">
                        NAVIGASI
                    </h3>
                    <ul class="tb-footer-list">
                        <li>
                            <a href="{{ route('home') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_home">Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_about">Tentang</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu') }}" class="hover:underline underline-offset-4 transition duration-300 inline-block">
                                <span data-i18n-app="nav_menu">Menu</span>
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
                <div class="tb-footer-col-social">
                    <h3 class="tb-footer-heading">
                        SOSIAL
                    </h3>
                    <ul class="tb-footer-list">
                        <li>
                            <a href="{{ route('whatsapp') }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="tb-footer-social-link group transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Whatsapp</span>
                                <svg class="tb-footer-social-icon transition duration-300" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/toonburger.id?rpxt=ZDNlZDc0MzIxNw=="
                               target="_blank"
                               rel="noopener noreferrer"
                               class="tb-footer-social-link group transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Instagram</span>
                                <svg class="tb-footer-social-icon transition duration-300" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                               class="tb-footer-social-link group transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Tiktok</span>
                                <svg class="tb-footer-social-icon transition duration-300" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                               class="tb-footer-social-link group transition duration-300">
                                <span class="group-hover:underline underline-offset-4">Gojek</span>
                                <svg class="tb-footer-social-icon transition duration-300" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Right Group: Jam Buka -->
                <div class="tb-footer-col-hours">
                    <h3 data-i18n-app="footer_hours" class="tb-footer-heading">
                        JAM BUKA
                    </h3>
                    <div class="tb-footer-hours-list">
                        <p class="tb-footer-hours-row">
                            <span>Senin:</span>
                            <span class="ml-1.5">(Tutup)</span>
                        </p>
                        <p class="tb-footer-hours-row">
                            <span>Selasa-Jumat:</span>
                            <span class="ml-1.5">(17:00 - 22:00 WITA)</span>
                        </p>
                        <p class="tb-footer-hours-row">
                            <span>Sabtu-Minggu:</span>
                            <span class="ml-1.5">(17:00 - 22:30 WITA)</span>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Divider Line & Copyright -->
            <div class="tb-footer-divider-wrap">
                <div class="tb-footer-divider"></div>
                <p class="tb-footer-copy">
                    &copy; 2026 Toon Burger. All Rights Reserved.
                </p>
            </div>

        </div>
    </div>
</footer>

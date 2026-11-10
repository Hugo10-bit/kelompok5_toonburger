@extends('layouts.app')

@section('title', 'Kontak - Toon Burger')

@section('content')
<!-- Leaflet CSS & JS for Interactive Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div>

    <!-- ═══════════════════════════════════════════════
         1. TOP MAP SECTION ON 3D PERSPECTIVE GRID
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden -mt-[88px] sm:-mt-[96px] pt-[122px] sm:pt-[126px] pb-12 sm:pb-16 px-4 sm:px-6 lg:px-8 border-b border-[#E2D9C5]"
             style="background-color: #FAF3E3;">

        <!-- 3D Perspective Grid Background SVG -->
        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden z-0">
            <svg class="w-full h-full" viewBox="0 0 1440 700" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g stroke="#DFD5C0" stroke-width="1">
                    <!-- Horizontal perspective lines (getting progressively wider toward bottom) -->
                    <line x1="0" y1="20" x2="1440" y2="20" />
                    <line x1="0" y1="45" x2="1440" y2="45" />
                    <line x1="0" y1="75" x2="1440" y2="75" />
                    <line x1="0" y1="110" x2="1440" y2="110" />
                    <line x1="0" y1="150" x2="1440" y2="150" />
                    <line x1="0" y1="196" x2="1440" y2="196" />
                    <line x1="0" y1="248" x2="1440" y2="248" />
                    <line x1="0" y1="308" x2="1440" y2="308" />
                    <line x1="0" y1="376" x2="1440" y2="376" />
                    <line x1="0" y1="452" x2="1440" y2="452" />
                    <line x1="0" y1="536" x2="1440" y2="536" />
                    <line x1="0" y1="628" x2="1440" y2="628" />

                    <!-- Radiating perspective lines from top center vanishing point -->
                    <line x1="720" y1="-220" x2="-700" y2="700" />
                    <line x1="720" y1="-220" x2="-480" y2="700" />
                    <line x1="720" y1="-220" x2="-280" y2="700" />
                    <line x1="720" y1="-220" x2="-90" y2="700" />
                    <line x1="720" y1="-220" x2="80" y2="700" />
                    <line x1="720" y1="-220" x2="230" y2="700" />
                    <line x1="720" y1="-220" x2="365" y2="700" />
                    <line x1="720" y1="-220" x2="490" y2="700" />
                    <line x1="720" y1="-220" x2="608" y2="700" />
                    <line x1="720" y1="-220" x2="720" y2="700" />
                    <line x1="720" y1="-220" x2="832" y2="700" />
                    <line x1="720" y1="-220" x2="950" y2="700" />
                    <line x1="720" y1="-220" x2="1075" y2="700" />
                    <line x1="720" y1="-220" x2="1210" y2="700" />
                    <line x1="720" y1="-220" x2="1360" y2="700" />
                    <line x1="720" y1="-220" x2="1530" y2="700" />
                    <line x1="720" y1="-220" x2="1720" y2="700" />
                    <line x1="720" y1="-220" x2="1920" y2="700" />
                    <line x1="720" y1="-220" x2="2140" y2="700" />
                </g>
            </svg>
        </div>

        <!-- Map Card -->
        <div class="relative z-10 max-w-6xl mx-auto toon-reveal">
            <div class="bg-white rounded-[26px] border-[1.5px] border-black shadow-[5px_6px_0px_#8F9693] p-5 sm:p-8">

                <!-- Header Row -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl sm:text-2xl lg:text-[26px] text-[#27443E] uppercase tracking-wide leading-tight"
                            style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                            TEMUKAN LOKASI OUTLET KAMI!
                        </h1>
                        <p class="text-[11px] sm:text-xs text-gray-400 leading-relaxed mt-1">
                            Kami hadir lebih dekat dengan Anda. Mampir dan nikmati pengalaman<br class="hidden sm:inline">
                            terbaik bersama kami!
                        </p>
                    </div>

                    <!-- Right Controls -->
                    <div class="flex flex-wrap items-center gap-2.5 self-start md:self-center">
                        <!-- Segmented Toggle: Peta Jalan / Satelit Google -->
                        <div class="bg-[#EBEBEB] p-1 rounded-lg inline-flex items-center border border-gray-200/80">
                            <button type="button"
                                    id="btn-view-leaflet"
                                    onclick="switchMapView('roadmap')"
                                    class="bg-white text-gray-800 shadow-2xs rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer">
                                Peta Jalan
                            </button>
                            <button type="button"
                                    id="btn-view-google"
                                    onclick="switchMapView('satellite')"
                                    class="bg-transparent text-gray-500 hover:text-gray-700 rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer">
                                Satelit Google
                            </button>
                        </div>

                        <!-- Google Maps External Button -->
                        <a href="https://www.google.com/maps/search/?api=1&query=HR7F%2BP8M,+Loktabat+Utara,+Kec.+Banjarbaru+Utara,+Kota+Banjar+Baru,+Kalimantan+Selatan"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="bg-[#415C58] hover:bg-[#344B48] text-white text-[11px] sm:text-xs font-medium px-4 py-2 rounded-lg inline-flex items-center gap-1.5 transition cursor-pointer">
                            <span>Google Maps</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Map Viewport -->
                <div class="mt-5 relative w-full h-[320px] sm:h-[380px] lg:h-[420px] rounded-2xl overflow-hidden border border-gray-200 bg-gray-100">
                    <div id="live-leaflet-map" class="w-full h-full z-10"></div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. FAQ & "LET'S GET IN TOUCH WITH US!" CLIPBOARD FORM
         ═══════════════════════════════════════════════ -->
    <section class="contact-fine-grid-bg py-14 sm:py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

            <!-- Left Column: FAQ Accordion -->
            <div class="lg:col-span-6">
                <div class="toon-reveal">
                    <h2 class="text-2xl sm:text-3xl lg:text-[34px] text-[#27443E] uppercase leading-[1.14] tracking-wide"
                        style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                        PERTANYAAN YANG<br>
                        SERING DITANYAKAN
                    </h2>
                    <p class="text-xs sm:text-[13px] text-[#4A6B65]/85 mt-2.5 mb-7 leading-relaxed max-w-md">
                        Masih ragu dan punya pertanyaan sebelum memesan? Temukan semua jawabannya di sini.
                    </p>
                </div>

                <div class="space-y-3.5" id="faq-accordion-list">
                    <!-- FAQ 1 -->
                    <div class="faq-item bg-white rounded-xl border border-gray-300/90 overflow-hidden transition toon-reveal" style="transition-delay: 50ms;">
                        <button type="button" onclick="toggleFaqItem(this)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 cursor-pointer">
                            <span class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug">
                                Bisakah saya mengubah atau membatalkan pesanan yang sudah dibayar?
                            </span>
                            <svg class="faq-chevron w-4 h-4 text-gray-500 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden">
                            <div class="border-t border-gray-200 mx-5"></div>
                            <p class="px-5 pt-3.5 pb-4 text-[11.5px] sm:text-xs text-gray-500 leading-relaxed">
                                Karena tim dapur langsung memanggang burger begitu pesanan masuk, pembatalan tidak dapat dilakukan setelah pesanan masuk tahap Cooking. Untuk perubahan mendesak, segera hubungi admin via tombol WhatsApp di website.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-item bg-white rounded-xl border border-gray-300/90 overflow-hidden transition toon-reveal" style="transition-delay: 100ms;">
                        <button type="button" onclick="toggleFaqItem(this)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 cursor-pointer">
                            <span class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug">
                                Bisakah saya custom pesanan, misal tanpa acar/bawang atau ekstra keju?
                            </span>
                            <svg class="faq-chevron w-4 h-4 text-gray-500 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden">
                            <div class="border-t border-gray-200 mx-5"></div>
                            <p class="px-5 pt-3.5 pb-4 text-[11.5px] sm:text-xs text-gray-500 leading-relaxed">
                                Tentu bisa! Saat memilih menu di halaman katalog, Anda dapat menyesuaikan tambahan topping seperti ekstra keju atau menuliskan catatan khusus untuk koki sebelum memasukkan menu ke keranjang.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-item bg-white rounded-xl border border-gray-300/90 overflow-hidden transition toon-reveal" style="transition-delay: 150ms;">
                        <button type="button" onclick="toggleFaqItem(this)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 cursor-pointer">
                            <span class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug">
                                Bisakah saya mengubah atau membatalkan pesanan yang sudah dibayar?
                            </span>
                            <svg class="faq-chevron w-4 h-4 text-gray-500 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden">
                            <div class="border-t border-gray-200 mx-5"></div>
                            <p class="px-5 pt-3.5 pb-4 text-[11.5px] sm:text-xs text-gray-500 leading-relaxed">
                                Karena tim dapur langsung memanggang burger begitu pesanan masuk, pembatalan tidak dapat dilakukan setelah pesanan masuk tahap Cooking. Untuk perubahan mendesak, segera hubungi admin via tombol WhatsApp di website.
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-item bg-white rounded-xl border border-gray-300/90 overflow-hidden transition toon-reveal" style="transition-delay: 200ms;">
                        <button type="button" onclick="toggleFaqItem(this)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 cursor-pointer">
                            <span class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug">
                                Apakah Toon Burger melayani pesan antar langsung lewat website ini?
                            </span>
                            <svg class="faq-chevron w-4 h-4 text-gray-500 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden">
                            <div class="border-t border-gray-200 mx-5"></div>
                            <p class="px-5 pt-3.5 pb-4 text-[11.5px] sm:text-xs text-gray-500 leading-relaxed">
                                Ya! Kami melayani pesan antar langsung melalui website ini untuk area Banjarbaru dan sekitarnya, maupun pemesanan untuk diambil sendiri di outlet (Takeaway).
                            </p>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="faq-item bg-white rounded-xl border border-gray-300/90 overflow-hidden transition toon-reveal" style="transition-delay: 250ms;">
                        <button type="button" onclick="toggleFaqItem(this)" class="w-full px-5 py-4 text-left flex items-center justify-between gap-4 cursor-pointer">
                            <span class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug">
                                Bagaimana jika saya terlambat mengambil pesanan di outlet?
                            </span>
                            <svg class="faq-chevron w-4 h-4 text-gray-500 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="faq-body hidden">
                            <div class="border-t border-gray-200 mx-5"></div>
                            <p class="px-5 pt-3.5 pb-4 text-[11.5px] sm:text-xs text-gray-500 leading-relaxed">
                                Pesanan Anda akan kami jaga tetap hangat menggunakan kemasan khusus. Apabila Anda mengalami kendala di perjalanan, silakan konfirmasi melalui WhatsApp agar tim outlet kami dapat membantu menyimpan pesanan Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Clipboard Contact Card -->
            <div class="lg:col-span-6 pt-5 sm:pt-6 toon-reveal" style="transition-delay: 150ms;">
                <div class="relative mx-auto w-full">

                    <!-- Top Tan Clipboard Clip Illustration -->
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center select-none pointer-events-none">
                        <!-- Top loop with hole -->
                        <div class="w-9 h-6 rounded-t-lg bg-[#E2C799] border-2 border-[#9D8053] flex items-center justify-center -mb-1 shadow-2xs">
                            <div class="w-3 h-3 rounded-full bg-[#FAF4E4] border border-[#9D8053]"></div>
                        </div>
                        <!-- Bottom clip bar -->
                        <div class="w-24 h-4 rounded-xs bg-[#D6B785] border-2 border-[#9D8053] shadow-xs z-10"></div>
                    </div>

                    <!-- White Card Body -->
                    <div class="bg-white rounded-t-[28px] sm:rounded-t-[34px] pt-10 sm:pt-12 px-6 sm:px-10 pb-7 border-x border-t border-gray-300 shadow-[0_4px_20px_rgba(0,0,0,0.04)] relative z-10">
                        <h2 class="text-3xl sm:text-4xl text-[#27443E] uppercase leading-[1.12] tracking-wide"
                            style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                            LET'S GET IN TOUCH<br>
                            WITH US!
                        </h2>

                        <!-- Dashed Divider -->
                        <div class="border-b border-dashed border-gray-300 my-6"></div>

                        <form onsubmit="handleContactSubmit(event)" class="space-y-4">
                            <div>
                                <label for="contact-name" class="block text-xs sm:text-[13px] font-bold text-gray-800 mb-1.5">Nama Lengkap</label>
                                <input type="text"
                                       id="contact-name"
                                       required
                                       placeholder="Nama Lengkap Anda"
                                       class="w-full bg-white border border-[#71827D] rounded-lg px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 placeholder-[#7A8782] focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] outline-none transition">
                            </div>

                            <div>
                                <label for="contact-email" class="block text-xs sm:text-[13px] font-bold text-gray-800 mb-1.5">Email</label>
                                <input type="email"
                                       id="contact-email"
                                       required
                                       placeholder="Emailanda@Gmail.com"
                                       class="w-full bg-white border border-[#71827D] rounded-lg px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 placeholder-[#7A8782] focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] outline-none transition">
                            </div>

                            <div>
                                <label for="contact-phone" class="block text-xs sm:text-[13px] font-bold text-gray-800 mb-1.5">Nomor Telefon</label>
                                <input type="tel"
                                       id="contact-phone"
                                       required
                                       placeholder="08xxx-xxx-xxx"
                                       class="w-full bg-white border border-[#71827D] rounded-lg px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 placeholder-[#7A8782] focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] outline-none transition">
                            </div>

                            <div>
                                <label for="contact-message" class="block text-xs sm:text-[13px] font-bold text-gray-800 mb-1.5">Pesan</label>
                                <textarea id="contact-message"
                                          rows="3"
                                          required
                                          placeholder="Tulis Pesan Anda Disini...."
                                          class="w-full bg-white border border-[#71827D] rounded-lg px-4 py-2.5 sm:py-3 text-xs sm:text-sm text-gray-800 placeholder-[#7A8782] focus:border-[#27443E] focus:ring-1 focus:ring-[#27443E] outline-none transition resize-none"></textarea>
                            </div>

                            <div class="pt-2">
                                <button type="submit"
                                        class="w-full bg-[#385A56] hover:bg-[#2C4945] active:scale-[0.99] text-white font-bold text-xs sm:text-sm py-3.5 rounded-lg transition flex items-center justify-center gap-2.5 cursor-pointer shadow-xs">
                                    <span>Kirim Pesan</span>
                                    <svg class="w-4 h-4 text-white -rotate-12 translate-y-[-1px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="22" y1="2" x2="11" y2="13"></line>
                                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Bottom Scalloped / Wavy Paper Edge -->
                    <div class="w-full overflow-hidden leading-none -mt-[1px] relative z-10 select-none pointer-events-none drop-shadow-[0_4px_4px_rgba(0,0,0,0.06)]">
                        <svg class="w-full h-5 sm:h-6 block" viewBox="0 0 600 28" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M 0,0 L 600,0 L 600,8
                                     C 587.5,8 587.5,24 575,24 C 562.5,24 562.5,8 550,8
                                     C 537.5,8 537.5,24 525,24 C 512.5,24 512.5,8 500,8
                                     C 487.5,8 487.5,24 475,24 C 462.5,24 462.5,8 450,8
                                     C 437.5,8 437.5,24 425,24 C 412.5,24 412.5,8 400,8
                                     C 387.5,8 387.5,24 375,24 C 362.5,24 362.5,8 350,8
                                     C 337.5,8 337.5,24 325,24 C 312.5,24 312.5,8 300,8
                                     C 287.5,8 287.5,24 275,24 C 262.5,24 262.5,8 250,8
                                     C 237.5,8 237.5,24 225,24 C 212.5,24 212.5,8 200,8
                                     C 187.5,8 187.5,24 175,24 C 162.5,24 162.5,8 150,8
                                     C 137.5,8 137.5,24 125,24 C 112.5,24 112.5,8 100,8
                                     C 87.5,8 87.5,24 75,24 C 62.5,24 62.5,8 50,8
                                     C 37.5,8 37.5,24 25,24 C 12.5,24 12.5,8 0,8 Z"
                                  fill="#FFFFFF"
                                  stroke="#CBD5E1"
                                  stroke-width="1.2"/>
                        </svg>
                    </div>

                </div>
            </div>

        </div>
    </section>

</div>

<script>
(function () {
    const STORE_LAT = -3.435747;
    const STORE_LNG = 114.823253;

    let map = null;
    let storeMarker = null;
    let currentTileLayer = null;

    function initLiveMap() {
        const container = document.getElementById('live-leaflet-map');
        if (!container || typeof L === 'undefined') return;
        if (container._leaflet_id) return;

        map = L.map('live-leaflet-map', {
            center: [STORE_LAT, STORE_LNG],
            zoom: 17,
            zoomControl: false,
            scrollWheelZoom: false
        });

        L.control.zoom({ position: 'bottomright' }).addTo(map);

        currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        // Google-Maps-style orange pin + TOON BURGER label matching mockup
        const storeIcon = L.divIcon({
            className: 'custom-toon-pin',
            html: `
                <div style="display: flex; align-items: center; gap: 6px; transform: translate(-16px, -36px); pointer-events: auto;">
                    <div style="position: relative; width: 32px; height: 40px; flex-shrink: 0; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.28));">
                        <svg viewBox="0 0 32 42" width="32" height="40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 1C7.716 1 1 7.716 1 16c0 10.2 15 24.5 15 24.5S31 26.2 31 16C31 7.716 24.284 1 16 1z" fill="#F26B1D" stroke="#FFFFFF" stroke-width="2"/>
                            <!-- Fork & Spoon icon -->
                            <path d="M12 10v5c0 .8.6 1.5 1.4 1.5v5.5h1.2v-5.5c.8 0 1.4-.7 1.4-1.5v-5h-1v4h-.6v-4h-.8v4h-.6v-4H12zm6.8 0c-1.2 0-2.2 1.2-2.2 2.7v3.3h1.4v6h1.3V10h-.5z" fill="#FFFFFF"/>
                        </svg>
                    </div>
                    <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 14px; color: #E8601C; letter-spacing: 0.02em; white-space: nowrap; text-shadow: -1.5px -1.5px 0 #fff, 1.5px -1.5px 0 #fff, -1.5px 1.5px 0 #fff, 1.5px 1.5px 0 #fff, 0 2px 4px rgba(255,255,255,0.9);">
                        TOON BURGER
                    </span>
                </div>
            `,
            iconSize: [160, 42],
            iconAnchor: [0, 0],
            popupAnchor: [16, -34]
        });

        storeMarker = L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon }).addTo(map);
    }

    if (document.readyState === 'loading') {
        document.addEventListener("DOMContentLoaded", initLiveMap);
    } else {
        initLiveMap();
    }

    window.switchMapView = function switchMapView(viewType) {
        if (!map) return;
        const btnLeaflet = document.getElementById('btn-view-leaflet');
        const btnGoogle = document.getElementById('btn-view-google');

        if (currentTileLayer) {
            map.removeLayer(currentTileLayer);
        }

        const activeClass = 'bg-white text-gray-800 shadow-2xs rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer';
        const inactiveClass = 'bg-transparent text-gray-500 hover:text-gray-700 rounded-md px-3.5 py-1.5 text-[11px] sm:text-xs font-medium transition cursor-pointer';

        if (viewType === 'satellite' || viewType === 'google') {
            currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            if (btnGoogle) btnGoogle.className = activeClass;
            if (btnLeaflet) btnLeaflet.className = inactiveClass;
        } else {
            currentTileLayer = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            if (btnLeaflet) btnLeaflet.className = activeClass;
            if (btnGoogle) btnGoogle.className = inactiveClass;
        }

        map.invalidateSize();
    };

    window.toggleFaqItem = function toggleFaqItem(button) {
        const item = button.closest('.faq-item');
        if (!item) return;
        const body = item.querySelector('.faq-body');
        const chevron = item.querySelector('.faq-chevron');
        if (!body) return;

        const isHidden = body.classList.contains('hidden');
        if (isHidden) {
            body.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        } else {
            body.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    };

    window.handleContactSubmit = function handleContactSubmit(event) {
        event.preventDefault();
        const name = document.getElementById('contact-name').value;

        Swal.fire({
            icon: 'success',
            title: 'Pesan Terkirim!',
            text: `Terima kasih ${name}, pesan Anda telah diterima oleh tim Toon Burger. Kami akan segera menghubungi Anda.`,
            confirmButtonColor: '#415C58',
            confirmButtonText: 'Selesai',
            customClass: { popup: 'rounded-3xl' }
        });

        event.target.reset();
    };
})();
</script>
@endsection

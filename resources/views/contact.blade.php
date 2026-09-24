@extends('layouts.app')

@section('title', 'Kontak & Live Location Outlet - Toon Burger Banjarbaru')

@section('content')
<!-- Leaflet CSS & JS for Live Interactive Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    /* Radar pulse animations for Live Pin */
    .radar-pulse-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: rgba(222, 59, 40, 0.35);
        animation: radarPulse 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
        pointer-events: none;
    }
    .radar-pulse-ring-outer {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background-color: rgba(245, 158, 11, 0.2);
        animation: radarPulse 2s cubic-bezier(0.215, 0.61, 0.355, 1) infinite 0.6s;
        pointer-events: none;
    }
    @keyframes radarPulse {
        0% {
            transform: translate(-50%, -50%) scale(0.3);
            opacity: 1;
        }
        80% {
            transform: translate(-50%, -50%) scale(1.4);
            opacity: 0;
        }
        100% {
            transform: translate(-50%, -50%) scale(1.5);
            opacity: 0;
        }
    }
    .leaflet-popup-content-wrapper {
        border-radius: 20px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
        padding: 4px !important;
        border: 1px solid #EFE5D0 !important;
    }
    .leaflet-popup-tip {
        background: white !important;
    }
    .leaflet-container {
        font-family: 'Poppins', sans-serif !important;
    }
</style>

<div class="space-y-12 lg:space-y-16 pb-16">

    <!-- ═══════════════════════════════════════════════
         1. HERO HEADER (OUTLET BANJARBARU)
         ═══════════════════════════════════════════════ -->
    <section class="relative overflow-hidden pt-4 sm:pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#263A38] via-[#355350] to-[#1E2D2B] rounded-[32px] sm:rounded-[40px] overflow-hidden shadow-2xl p-8 sm:p-14 text-white">
                
                <!-- Ambient Glow -->
                <div class="absolute -right-16 -bottom-16 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-10 -top-10 w-64 h-64 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

                <div class="relative z-10 max-w-3xl space-y-4 text-left">
                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.1] text-white">
                        Kunjungi Outlet &amp; <br class="hidden sm:inline">
                        <span class="text-amber-300">Live Location</span> Banjarbaru
                    </h1>

                    <p class="text-sm sm:text-base text-stone-200 leading-relaxed font-normal">
                        Beralamat di <strong>Loktabat Utara, Banjarbaru Utara</strong>. Pantau radar outlet secara real-time dan kalkulasikan jarak tempuh GPS langsung dari perangkat Anda.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <a href="#live-map-section" class="bg-bites-yellow hover:bg-bites-yellow-dark text-bites-dark text-xs sm:text-sm font-black px-6 py-3 rounded-2xl transition shadow-md active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Buka Live Radar Map</span>
                            <span class="text-stone-700">&darr;</span>
                        </a>
                        <a href="https://wa.me/6281234567890?text=Halo%20Toon%20Burger%20Banjarbaru,%20saya%20ingin%20tanya%20menu%20dan%20lokasi" target="_blank" class="bg-white/20 hover:bg-white/30 backdrop-blur-md text-white font-bold text-xs sm:text-sm px-5 py-3 rounded-2xl transition border border-white/30 active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <span>Chat WhatsApp Outlet</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         2. 3 INFO HIGHLIGHT CARDS (BANJARBARU)
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Address Card -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center shadow-2xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <span class="bg-amber-100 text-amber-900 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">
                            Plus Code
                        </span>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">Alamat Outlet Utama</h3>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        HR7F+P8M, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan, Indonesia.
                    </p>
                    <div class="pt-1 flex flex-wrap gap-1.5 text-[11px] font-semibold text-gray-500">
                        <span class="bg-stone-100 px-2 py-0.5 rounded-md">WiFi Gratis</span>
                        <span class="bg-stone-100 px-2 py-0.5 rounded-md">Area Tunggu Nyaman</span>
                        <span class="bg-stone-100 px-2 py-0.5 rounded-md">Parkir Luas</span>
                        <span class="bg-stone-100 px-2 py-0.5 rounded-md">Quick Pick-up</span>
                    </div>
                </div>
                <button type="button" onclick="copyAddressToClipboard()" class="text-xs text-amber-700 font-extrabold hover:text-amber-800 bg-amber-50 hover:bg-amber-100/80 py-2.5 px-3 rounded-xl transition text-center flex items-center justify-center gap-1.5 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <span>Salin Alamat Lengkap</span>
                </button>
            </div>

            <!-- Hours Card -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-orange-500 text-white flex items-center justify-center shadow-2xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span id="store-live-badge" class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Buka Sekarang</span>
                        </span>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">Jam Operasional (WITA)</h3>
                    <div class="text-xs text-gray-600 space-y-1.5 leading-relaxed">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-700">Senin:</span>
                            <span class="font-black text-rose-600 bg-rose-50 border border-rose-200/80 px-2 py-0.5 rounded text-[11px] font-mono">LIBUR / TUTUP</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-700">Selasa - Jumat:</span>
                            <span class="font-bold text-gray-900 font-mono">17:00 - 22:00 WITA</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-700">Sabtu:</span>
                            <span class="font-bold text-gray-900 font-mono">17:00 - 22:30 WITA</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-1">
                            <span class="font-medium text-gray-700">Minggu:</span>
                            <span class="font-bold text-gray-900 font-mono">17:00 - 22:00 WITA</span>
                        </div>
                    </div>
                    <p class="text-[11px] text-amber-800 font-semibold bg-amber-50/80 p-2 rounded-xl">
                        Khusus Takeaway (Bawa Pulang) &amp; Pesan Antar Online. Tidak melayani Dine-in (makan di tempat).
                    </p>
                </div>
                <div class="text-xs font-bold text-toon-granite bg-teal-50/80 py-2.5 px-3 rounded-xl text-center border border-teal-100">
                    🍔 Buka Selasa – Minggu • Mulai Pukul 17:00 WITA (Senin Libur)
                </div>
            </div>

            <!-- WhatsApp & Direct Chat -->
            <div class="bg-white rounded-3xl p-6 border border-[#E6DEC8] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center shadow-2xs">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase">
                            Fast Response
                        </span>
                    </div>
                    <h3 class="font-extrabold text-base text-gray-900">WhatsApp &amp; Layanan Pelanggan</h3>
                    <p class="text-xs text-gray-600 leading-relaxed font-medium">
                        Hubungi customer service kami untuk cek stok menu, pesanan takeaway jumlah banyak, atau katering acara:
                    </p>
                    <div class="space-y-1 text-xs">
                        <div class="font-extrabold text-gray-900 text-sm font-mono">+62 812-3456-7890</div>
                        <div class="text-gray-500 text-[11px]">Email: banjarbaru@toonburger.com</div>
                    </div>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Toon%20Burger%20Banjarbaru,%20saya%20ingin%20pesan%20dan%20tanya%20lokasi" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black px-4 py-2.5 rounded-xl transition text-center shadow-xs active:scale-95 flex items-center justify-center gap-1.5">
                    <span>Chat WhatsApp Sekarang</span>
                    <span>&rarr;</span>
                </a>
            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         3. LIVE LOCATION INTERACTIVE MAP & RADAR TRACKING
         ═══════════════════════════════════════════════ -->
    <section id="live-map-section" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-sm p-6 sm:p-10 space-y-6 overflow-hidden">
            
            <!-- Map Section Header -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pb-2 border-b border-gray-100">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                        Live Location Outlet Toon Burger Banjarbaru
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Titik koordinat real-time: <strong class="text-gray-800 font-mono">-3.435747, 114.823253</strong> (Plus Code: <span class="text-bites-red font-mono font-bold">HR7F+P8M</span>)
                    </p>
                </div>

                <!-- Map View Switcher Buttons -->
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-view-leaflet" onclick="switchMapView('leaflet')" class="bg-gray-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        <span>Peta Live Radar</span>
                    </button>
                    <button type="button" id="btn-view-google" onclick="switchMapView('google')" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8M12 3a15 15 0 010 18M12 3a15 15 0 000 18"/></svg>
                        <span>Google Maps Satelit</span>
                    </button>
                    <a href="https://www.google.com/maps/search/?api=1&query=HR7F%2BP8M,+Loktabat+Utara,+Kec.+Banjarbaru+Utara,+Kota+Banjar+Baru,+Kalimantan+Selatan" target="_blank" class="bg-amber-100 hover:bg-amber-200 text-amber-900 text-xs font-extrabold px-4 py-2 rounded-xl transition flex items-center gap-1">
                        <span>Buka di Google Maps</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            <!-- Map Viewports Container -->
            <div class="relative w-full h-[460px] sm:h-[520px] rounded-3xl overflow-hidden border border-[#EFE5D0] shadow-inner bg-gray-100">
                
                <!-- Leaflet Live Radar Map -->
                <div id="live-leaflet-map" class="w-full h-full z-10"></div>

                <!-- Google Maps Embed Iframe (Hidden by default) -->
                <div id="google-maps-frame" class="w-full h-full hidden z-10">
                    <iframe 
                        width="100%" 
                        height="100%" 
                        frameborder="0" 
                        style="border:0;" 
                        src="https://maps.google.com/maps?q=-3.435747,114.823253&hl=id&z=17&output=embed" 
                        allowfullscreen>
                    </iframe>
                </div>

                <!-- Floating Live Radar Status Badge -->
                <div class="absolute top-4 left-4 z-[999] bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-2xl shadow-lg border border-gray-200/80 flex items-center gap-2.5 select-none">
                    <div class="relative flex h-3 w-3">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </div>
                    <div>
                        <div class="text-[10px] font-black uppercase text-gray-400 leading-tight">GPS Beacon</div>
                        <div class="text-xs font-black text-gray-900 leading-tight">Outlet Banjarbaru Online</div>
                    </div>
                </div>

                <!-- Floating Recenter Button -->
                <button type="button" onclick="centerStoreMap()" class="absolute bottom-4 right-4 z-[999] bg-white hover:bg-gray-50 text-gray-800 text-xs font-bold px-3.5 py-2 rounded-2xl shadow-lg border border-gray-200/80 flex items-center gap-2 transition active:scale-95">
                    <svg class="w-3.5 h-3.5 text-bites-red" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3"/><path stroke-linecap="round" d="M12 2v3m0 14v3M2 12h3m14 0h3"/></svg>
                    <span>Pusatkan ke Outlet</span>
                </button>
            </div>

            <!-- GPS Geolocation Distance Calculator Box -->
            <div class="bg-gradient-to-br from-[#FAF1E1] to-[#F5EAD4] rounded-3xl p-6 sm:p-8 border border-[#EFE5D0] space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-gray-900 leading-tight flex items-center gap-2">
                            <svg class="w-5 h-5 text-bites-red" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Cek Jarak &amp; Rute dari Lokasi Anda Saat Ini</span>
                        </h3>
                        <p class="text-xs text-gray-600 mt-1">
                            Aktifkan GPS browser Anda untuk mengetahui jarak tempuh langsung dan estimasi waktu sampai ke Toon Burger.
                        </p>
                    </div>

                    <button type="button" id="btn-detect-location" onclick="detectUserLocation()" class="bg-bites-red hover:bg-red-700 active:scale-95 text-white text-xs sm:text-sm font-extrabold px-6 py-3.5 rounded-2xl transition shadow-md flex items-center gap-2 shrink-0 self-start sm:self-auto">
                        <svg class="w-4 h-4 animate-spin hidden" id="geo-spinner" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        <span id="geo-btn-text">Deteksi Lokasi Saya &amp; Hitung Jarak</span>
                    </button>
                </div>

                <!-- Dynamic Real-time HUD Result (Hidden until user calculates) -->
                <div id="live-distance-result" class="hidden pt-4 border-t border-[#E6DEC8] animate-modal-pop">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white rounded-2xl p-4 border border-[#EFE5D0] shadow-xs">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Jarak Langsung GPS</div>
                            <div class="text-xl font-black text-bites-red font-mono mt-0.5" id="hud-distance">-</div>
                            <div class="text-[11px] text-gray-500 mt-0.5">Jarak garis lurus ke outlet</div>
                        </div>

                        <div class="bg-white rounded-2xl p-4 border border-[#EFE5D0] shadow-xs">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Estimasi Sepeda Motor</div>
                            <div class="text-xl font-black text-gray-900 font-mono mt-0.5" id="hud-time-motor">-</div>
                            <div class="text-[11px] text-emerald-600 font-semibold mt-0.5">Kecepatan rata-rata 35 km/h</div>
                        </div>

                        <div class="bg-white rounded-2xl p-4 border border-[#EFE5D0] shadow-xs">
                            <div class="text-[10px] font-bold text-gray-400 uppercase">Estimasi Mobil</div>
                            <div class="text-xl font-black text-gray-900 font-mono mt-0.5" id="hud-time-car">-</div>
                            <div class="text-[11px] text-gray-500 mt-0.5">Lalu lintas normal Banjarbaru</div>
                        </div>

                        <div class="bg-white rounded-2xl p-4 border border-[#EFE5D0] shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase">Status Pengiriman</div>
                                <div class="text-xs font-black text-emerald-700 mt-0.5" id="hud-delivery-status">Tercakup Pengiriman!</div>
                            </div>
                            <a id="hud-nav-link" href="#" target="_blank" class="mt-2 inline-flex items-center justify-center gap-1.5 bg-gray-900 hover:bg-black text-white text-[11px] font-bold py-2 px-3 rounded-xl transition shadow-xs active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                <span>Buka Rute GPS</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ═══════════════════════════════════════════════
         4. INTERACTIVE FORM & FAQ
         ═══════════════════════════════════════════════ -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-[32px] sm:rounded-[40px] border border-[#E6DEC8] shadow-xs p-6 sm:p-12 lg:p-14 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-start">
                
                <!-- Left: FAQ Accordion -->
                <div class="lg:col-span-5 space-y-6">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                            Frequently Asked Questions
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">Pertanyaan umum seputar pemesanan dan outlet di Loktabat Utara, Banjarbaru.</p>
                    </div>

                    <!-- FAQ List -->
                    <div class="space-y-3">
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200/80 text-xs space-y-1">
                            <div class="font-extrabold text-amber-950">Apakah Toon Burger menyediakan fasilitas makan di tempat (Dine-in)?</div>
                            <p class="text-amber-900 leading-relaxed font-medium">
                                <strong>Tidak.</strong> Outlet Toon Burger Banjarbaru beroperasi dengan format <strong>Quick Takeaway Hub &amp; Cloud Kitchen</strong>. Kami khusus melayani pesanan <strong>Takeaway (Bungkus Bawa Pulang)</strong> dan <strong>Delivery Online</strong>. Kami tidak menyediakan meja/kursi makan di tempat.
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200/70 text-xs space-y-1">
                            <div class="font-extrabold text-gray-900">Di mana patokan lokasi Toon Burger Banjarbaru?</div>
                            <p class="text-gray-500 leading-relaxed">
                                Kami berada di area Loktabat Utara, Kecamatan Banjarbaru Utara (Plus Code: <strong>HR7F+P8M</strong>), dengan akses jalan yang mudah dijangkau dari pusat kota Banjarbaru dan Martapura.
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200/70 text-xs space-y-1">
                            <div class="font-extrabold text-gray-900">Apakah tersedia layanan pesan antar (Delivery)?</div>
                            <p class="text-gray-500 leading-relaxed">
                                Ya! Kami melayani delivery di seluruh wilayah Banjarbaru, Martapura, dan sekitarnya. Anda bisa pesan langsung melalui website ini atau WhatsApp.
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200/70 text-xs space-y-1">
                            <div class="font-extrabold text-gray-900">Apakah semua menu 100% Halal?</div>
                            <p class="text-gray-500 leading-relaxed">
                                Ya, 100% Halal bersertifikat. Semua daging sapi, ayam, roti brioche, hingga keju dan saus kami terjamin halal dan higienis.
                            </p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200/70 text-xs space-y-1">
                            <div class="font-extrabold text-gray-900">Bisa pesan untuk katering atau acara rombongan?</div>
                            <p class="text-gray-500 leading-relaxed">
                                Tentu bisa! Silakan isi formulir di samping atau hubungi WhatsApp kami H-2 untuk penawaran menu takeaway katering kantor, ulang tahun, atau acara komunitas.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right: Inquiry / Takeaway Order Form -->
                <div class="lg:col-span-7 bg-[#FAF1E1]/40 p-6 sm:p-8 rounded-3xl border border-[#EFE5D0]">
                    <h3 class="text-xl font-black text-gray-900 mb-1">Formulir Pesan Takeaway / Katering</h3>
                    <p class="text-xs text-gray-500 mb-6">Lengkapi data Anda, tim Toon Burger Banjarbaru akan segera merespons via WhatsApp.</p>

                    <form onsubmit="handleContactSubmit(event)" class="space-y-4 text-xs font-semibold">
                        <div>
                            <label class="block text-gray-700 mb-1">Nama Lengkap *</label>
                            <input type="text" id="contact-name" required placeholder="Contoh: Muhammad Rizky" 
                                   class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-xs text-gray-900 focus:border-bites-orange focus:ring-2 focus:ring-bites-orange/20 outline-none transition">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 mb-1">Alamat Email *</label>
                                <input type="email" id="contact-email" required placeholder="rizky@email.com" 
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-xs text-gray-900 focus:border-bites-orange focus:ring-2 focus:ring-bites-orange/20 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-1">Nomor WhatsApp *</label>
                                <input type="tel" id="contact-phone" required placeholder="081234567890" 
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-xs text-gray-900 focus:border-bites-orange focus:ring-2 focus:ring-bites-orange/20 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Kategori Keperluan</label>
                            <select id="contact-category" class="w-full bg-white border border-gray-300 rounded-xl px-4 py-2.5 text-xs text-gray-900 focus:border-bites-orange outline-none transition">
                                <option value="Pesanan Takeaway Cepat">Pesanan Takeaway Cepat (Ambil di Outlet)</option>
                                <option value="Pesanan Katering / Acara">Pesanan Katering Kantor / Acara</option>
                                <option value="Pertanyaan Menu & Pengiriman">Pertanyaan Menu &amp; Ongkir Pengiriman</option>
                                <option value="Kerjasama & Masukan">Kerjasama / Masukan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-gray-700 mb-1">Isi Pesan / Detail Pesanan *</label>
                            <textarea id="contact-message" rows="4" required placeholder="Tuliskan menu yang ingin dipesan, jam perkiraan pengambilan takeaway di outlet, atau detail acara..." 
                                      class="w-full bg-white border border-gray-300 rounded-xl p-3 text-xs text-gray-900 focus:border-bites-orange focus:ring-2 focus:ring-bites-orange/20 outline-none transition"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-gray-900 hover:bg-black text-white font-black text-xs sm:text-sm py-3.5 rounded-xl transition shadow-md active:scale-95 flex items-center justify-center gap-2">
                            <span>Kirim Formulir Sekarang</span>
                            <span>&rarr;</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

</div>

<!-- ═══════════════════════════════════════════════
     JAVASCRIPT: LIVE MAP & GEOLOCATION TRACKER
     ═══════════════════════════════════════════════ -->
<script>
    // TOON BURGER BANJARBARU OUTLET COORDINATES
    const STORE_LAT = -3.435747;
    const STORE_LNG = 114.823253;
    const STORE_ADDRESS = "HR7F+P8M, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan, Indonesia";

    let map = null;
    let storeMarker = null;
    let userMarker = null;
    let routeLine = null;

    // Initialize Leaflet Live Map
    document.addEventListener("DOMContentLoaded", function () {
        initLiveMap();
        checkStoreOperatingHours();
    });

    function initLiveMap() {
        const container = document.getElementById('live-leaflet-map');
        if (!container || typeof L === 'undefined') return;

        // Create Map instance centered on Toon Burger Banjarbaru
        map = L.map('live-leaflet-map', {
            center: [STORE_LAT, STORE_LNG],
            zoom: 16,
            zoomControl: true,
            scrollWheelZoom: false // Avoid accidental zoom when scrolling page
        });

        // Add CartoDB Voyager tiles (modern, clear, aesthetic)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            maxZoom: 19
        }).addTo(map);

        // Custom HTML Animated Radar Icon for Outlet
        const storeIcon = L.divIcon({
            className: 'custom-store-pin',
            html: `
                <div class="relative" style="width: 50px; height: 50px;">
                    <div class="radar-pulse-ring-outer"></div>
                    <div class="radar-pulse-ring"></div>
                    <div class="relative z-10 w-12 h-12 rounded-2xl bg-gradient-to-tr from-bites-red to-orange-500 text-white flex items-center justify-center shadow-2xl border-2 border-white transform hover:scale-110 transition duration-200">
                        <svg style="width: 26px; height: 26px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5C3 6.358 6.358 3 10.5 3h3C17.642 3 21 6.358 21 10.5v.5H3v-.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 14h20M4 17h16M5 20h14"/></svg>
                    </div>
                </div>
            `,
            iconSize: [50, 50],
            iconAnchor: [25, 25],
            popupAnchor: [0, -28]
        });

        // Add Store Marker
        storeMarker = L.marker([STORE_LAT, STORE_LNG], { icon: storeIcon }).addTo(map);

        // Bind Store Info Popup
        const popupContent = `
            <div style="font-family: 'Poppins', sans-serif; min-width: 210px; padding: 4px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <div style="background: #DE3B28; color: white; width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5C3 6.358 6.358 3 10.5 3h3C17.642 3 21 6.358 21 10.5v.5H3v-.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2 14h20M4 17h16M5 20h14"/></svg>
                    </div>
                    <div>
                        <div style="font-weight: 900; font-size: 13px; color: #1F2937; line-height: 1.2;">Toon Burger, Banjarbaru Utara Jln Berlian</div>
                        <div style="font-size: 10px; color: #059669; font-weight: 700; display: flex; items-center; gap: 4px;">
                            <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #10B981; margin-top: 4px;"></span>
                            <span>Buka 17:00 WITA (Khusus Takeaway &amp; Delivery)</span>
                        </div>
                    </div>
                </div>
                <div style="font-size: 11px; color: #4B5563; line-height: 1.4; margin-bottom: 8px;">
                    Jl. Berlian, Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjarbaru (HR7F+P8M)
                </div>
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${STORE_LAT},${STORE_LNG}" target="_blank" 
                       style="background: #111827; color: white; text-decoration: none; font-size: 10px; font-weight: 800; padding: 5px 9px; border-radius: 8px; display: inline-block;">
                        Petunjuk Arah &rarr;
                    </a>
                    <a href="{{ route('gofood') }}" target="_blank" rel="noopener noreferrer" 
                       style="background: #EE2737; color: white; text-decoration: none; font-size: 10px; font-weight: 800; padding: 5px 9px; border-radius: 8px; display: inline-flex; align-items: center; gap: 3px;">
                        <span>GoFood 4.9 ★</span>
                    </a>
                    <button onclick="copyAddressToClipboard()" 
                            style="background: #F3F4F6; color: #374151; border: 1px solid #D1D5DB; font-size: 10px; font-weight: 700; padding: 5px 7px; border-radius: 8px; cursor: pointer;">
                        Salin Alamat
                    </button>
                </div>
            </div>
        `;

        storeMarker.bindPopup(popupContent).openPopup();
    }

    function centerStoreMap() {
        if (!map) return;
        map.setView([STORE_LAT, STORE_LNG], 16, { animate: true });
        if (storeMarker) storeMarker.openPopup();
    }

    // Switch between Leaflet and Google Maps Embed
    function switchMapView(viewType) {
        const leafletEl = document.getElementById('live-leaflet-map');
        const googleEl = document.getElementById('google-maps-frame');
        const btnLeaflet = document.getElementById('btn-view-leaflet');
        const btnGoogle = document.getElementById('btn-view-google');

        if (viewType === 'google') {
            leafletEl.classList.add('hidden');
            googleEl.classList.remove('hidden');
            btnGoogle.className = 'bg-gray-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs';
            btnLeaflet.className = 'bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-xl transition';
        } else {
            googleEl.classList.add('hidden');
            leafletEl.classList.remove('hidden');
            btnLeaflet.className = 'bg-gray-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs';
            btnGoogle.className = 'bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-xl transition';
            if (map) map.invalidateSize();
        }
    }

    // Real-Time GPS User Location Detector & Distance Calculation
    function detectUserLocation() {
        if (!navigator.geolocation) {
            Swal.fire({
                icon: 'error',
                title: 'GPS Tidak Didukung',
                text: 'Browser Anda tidak mendukung deteksi lokasi otomatis.',
                confirmButtonColor: '#466967'
            });
            return;
        }

        const spinner = document.getElementById('geo-spinner');
        const btnText = document.getElementById('geo-btn-text');
        spinner.classList.remove('hidden');
        btnText.innerText = "Mendeteksi Koordinat GPS Anda...";

        navigator.geolocation.getCurrentPosition(
            function (position) {
                spinner.classList.add('hidden');
                btnText.innerText = "Update Lokasi Saya";

                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Ensure Leaflet map is visible
                switchMapView('leaflet');

                // Add or update User Marker with pulsing blue locator
                const userIcon = L.divIcon({
                    className: 'custom-user-pin',
                    html: `
                        <div class="relative" style="width: 40px; height: 40px;">
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(59, 130, 246, 0.3); animation: ping 1.8s cubic-bezier(0, 0, 0.2, 1) infinite;"></div>
                            <div class="relative z-10 w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center shadow-lg border-2 border-white font-black text-xs">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><circle cx="12" cy="12" r="8"/></svg>
                            </div>
                        </div>
                    `,
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                });

                if (userMarker) {
                    userMarker.setLatLng([userLat, userLng]);
                } else {
                    userMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);
                    userMarker.bindPopup("<b>Lokasi Anda Saat Ini</b><br>Menghitung rute ke Toon Burger...");
                }

                // Draw flight path line connecting User to Outlet
                if (routeLine) {
                    map.removeLayer(routeLine);
                }

                routeLine = L.polyline([[userLat, userLng], [STORE_LAT, STORE_LNG]], {
                    color: '#DE3B28',
                    weight: 3.5,
                    dashArray: '8, 8',
                    opacity: 0.85
                }).addTo(map);

                // Fit map to show both user and store
                map.fitBounds([[userLat, userLng], [STORE_LAT, STORE_LNG]], {
                    padding: [60, 60],
                    animate: true
                });

                // Calculate Distance using Haversine Formula
                const distanceKm = calculateHaversineKm(userLat, userLng, STORE_LAT, STORE_LNG);

                // Estimate Travel Times
                // Motor avg 35 km/h + 3 min prep
                const motorMinutes = Math.max(3, Math.round((distanceKm / 35) * 60) + 2);
                // Car avg 25 km/h + traffic
                const carMinutes = Math.max(5, Math.round((distanceKm / 25) * 60) + 4);

                // Update HUD
                const hudPanel = document.getElementById('live-distance-result');
                hudPanel.classList.remove('hidden');

                document.getElementById('hud-distance').innerText = distanceKm < 1 
                    ? Math.round(distanceKm * 1000) + ' Meter' 
                    : distanceKm.toFixed(2) + ' km';

                document.getElementById('hud-time-motor').innerText = `~${motorMinutes} Menit`;
                document.getElementById('hud-time-car').innerText = `~${carMinutes} Menit`;

                const deliveryStatus = document.getElementById('hud-delivery-status');
                if (distanceKm <= 5) {
                    deliveryStatus.innerHTML = '<span class="text-emerald-700">✓ Sangat Dekat (Ongkir Promo Cepat)</span>';
                } else if (distanceKm <= 18) {
                    deliveryStatus.innerHTML = '<span class="text-emerald-700">✓ Terjangkau Antar (Kota Banjarbaru)</span>';
                } else {
                    deliveryStatus.innerHTML = '<span class="text-amber-700">Luar Area Antar (Disarankan Ambil Sendiri / Takeaway)</span>';
                }

                document.getElementById('hud-nav-link').href = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${STORE_LAT},${STORE_LNG}`;

                // SweetAlert Success Notification
                Swal.fire({
                    icon: 'success',
                    title: 'Live Location Terhubung!',
                    html: `Jarak Anda saat ini adalah <b>${distanceKm.toFixed(2)} km</b> dari outlet Toon Burger Banjarbaru.<br><span style="font-size: 12px; color: #6B7280;">Estimasi perjalanan ~${motorMinutes} menit dengan sepeda motor.</span>`,
                    confirmButtonColor: '#466967',
                    confirmButtonText: 'Bagus, Lihat Peta',
                    customClass: { popup: 'rounded-3xl' }
                });
            },
            function (error) {
                spinner.classList.add('hidden');
                btnText.innerText = "Deteksi Lokasi Saya & Hitung Jarak";
                let msg = 'Gagal mendeteksi lokasi.';
                if (error.code === error.PERMISSION_DENIED) {
                    msg = 'Izin lokasi ditolak oleh Anda. Silakan izinkan akses lokasi di browser untuk menggunakan fitur ini.';
                } else if (error.code === error.POSITION_UNAVAILABLE) {
                    msg = 'Sinyal GPS tidak tersedia pada perangkat Anda saat ini.';
                } else if (error.code === error.TIMEOUT) {
                    msg = 'Permintaan waktu deteksi GPS habis. Silakan coba kembali.';
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Deteksi Lokasi Gagal',
                    text: msg,
                    confirmButtonColor: '#466967'
                });
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    // Haversine Formula (Calculates Distance in KM)
    function calculateHaversineKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Earth Radius in KM
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    // Copy Address Helper
    function copyAddressToClipboard() {
        navigator.clipboard.writeText(STORE_ADDRESS).then(() => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Alamat outlet Banjarbaru berhasil disalin!',
                showConfirmButton: false,
                timer: 2500
            });
        });
    }

    // Check Operating Hours (WITA / UTC+8)
    function checkStoreOperatingHours() {
        const now = new Date();
        // Convert to WITA (UTC+8)
        const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
        const witaTime = new Date(utc + (3600000 * 8));
        const day = witaTime.getDay(); // 0: Sun, 1: Mon, 2: Tue, 3: Wed, 4: Thu, 5: Fri, 6: Sat
        const hour = witaTime.getHours();
        const minute = witaTime.getMinutes();
        const totalMinutes = hour * 60 + minute;

        const badge = document.getElementById('store-live-badge');
        if (!badge) return;

        let isOpen = false;
        let statusBadgeHtml = '';

        if (day === 1) { // Monday (Senin): CLOSED / LIBUR
            isOpen = false;
            statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span><span>Tutup (Senin Libur • Buka Selasa 17:00)</span>`;
            badge.className = "bg-rose-100 text-rose-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
        } else if (day === 6) { // Saturday (Sabtu): 17:00 - 22:30
            const openMin = 17 * 60; // 1020
            const closeMin = 22 * 60 + 30; // 1350
            if (totalMinutes >= openMin && totalMinutes < closeMin) {
                isOpen = true;
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span><span>Buka Sekarang (s/d 22:30 WITA)</span>`;
                badge.className = "bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            } else if (totalMinutes < openMin) {
                isOpen = false;
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span><span>Tutup (Buka 17:00 WITA Hari Ini)</span>`;
                badge.className = "bg-amber-100 text-amber-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            } else {
                isOpen = false;
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span><span>Tutup (Buka Minggu 17:00 WITA)</span>`;
                badge.className = "bg-rose-100 text-rose-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            }
        } else { // Tuesday, Wednesday, Thursday, Friday, Sunday: 17:00 - 22:00
            const openMin = 17 * 60; // 1020
            const closeMin = 22 * 60; // 1320
            if (totalMinutes >= openMin && totalMinutes < closeMin) {
                isOpen = true;
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span><span>Buka Sekarang (s/d 22:00 WITA)</span>`;
                badge.className = "bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            } else if (totalMinutes < openMin) {
                isOpen = false;
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span><span>Tutup (Buka 17:00 WITA Hari Ini)</span>`;
                badge.className = "bg-amber-100 text-amber-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            } else {
                isOpen = false;
                const nextDayText = (day === 0) ? 'Buka Selasa 17:00 WITA' : 'Buka Besok 17:00 WITA';
                statusBadgeHtml = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span><span>Tutup (${nextDayText})</span>`;
                badge.className = "bg-rose-100 text-rose-800 text-[10px] font-black px-2.5 py-1 rounded-full uppercase flex items-center gap-1 shadow-xs";
            }
        }

        badge.innerHTML = statusBadgeHtml;
    }

    // Contact Form Submission
    function handleContactSubmit(event) {
        event.preventDefault();
        const name = document.getElementById('contact-name').value;
        const category = document.getElementById('contact-category').value;
        
        Swal.fire({
            icon: 'success',
            title: 'Pesan Terkirim!',
            text: `Terima kasih ${name}, pesan mengenai "${category}" telah diterima oleh tim Toon Burger Banjarbaru. Kami akan segera menghubungi WhatsApp Anda.`,
            confirmButtonColor: '#466967',
            confirmButtonText: 'Selesai',
            customClass: { popup: 'rounded-3xl' }
        });

        event.target.reset();
    }
</script>
@endsection

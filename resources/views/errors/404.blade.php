@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan | Toon Burger')

@section('content')
<div class="relative min-h-[calc(100vh-140px)] flex items-center justify-center py-12 sm:py-16 px-4 sm:px-6 lg:px-8 overflow-hidden select-none"
     style="background-color: #FAF5E9;">

    <!-- Retro Grid Background Texture -->
    <div class="absolute inset-0 retro-grid-bg opacity-70 pointer-events-none"></div>

    <!-- Comic Floating Sparkles -->
    <img src="{{ asset('images/star-sparkle.png') }}"
         alt=""
         class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-7 h-auto opacity-75"
         style="top: 15%; left: 8%; animation-delay: 0.2s;">
    <img src="{{ asset('images/star-sparkle.png') }}"
         alt=""
         class="comic-sparkle absolute pointer-events-none select-none z-10 w-4 sm:w-6 h-auto opacity-75"
         style="top: 22%; right: 10%; animation-delay: 0.9s;">
    <img src="{{ asset('images/star-sparkle.png') }}"
         alt=""
         class="comic-sparkle absolute pointer-events-none select-none z-10 w-6 sm:w-8 h-auto opacity-75"
         style="bottom: 18%; left: 12%; animation-delay: 0.5s;">
    <img src="{{ asset('images/star-sparkle.png') }}"
         alt=""
         class="comic-sparkle absolute pointer-events-none select-none z-10 w-5 sm:w-6 h-auto opacity-75"
         style="bottom: 25%; right: 14%; animation-delay: 1.2s;">

    <!-- Main 404 Cartoon Card -->
    <div class="relative z-20 max-w-2xl w-full text-center">

        <!-- Card Container with Cartoon Shadow -->
        <div class="bg-white rounded-[32px] border-2 border-black shadow-[8px_8px_0px_#27443E] p-6 sm:p-10 lg:p-12 relative overflow-hidden toon-reveal revealed">

            <!-- Top Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#E03A3A] text-white text-xs sm:text-[13px] font-black uppercase tracking-wider border-2 border-black shadow-[2px_2px_0px_#000] mb-4">
                <span>🍔</span>
                <span>ERROR 404 • BURGER NYASAR!</span>
            </div>

            <!-- Big Comic 404 Display with Animated Burger in the Middle -->
            <div class="relative flex items-center justify-center gap-2 sm:gap-4 my-2 sm:my-4">
                <!-- First '4' -->
                <span class="text-7xl sm:text-8xl md:text-9xl font-black text-[#27443E] tracking-tighter"
                      style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive; text-shadow: 4px 4px 0px #000, 7px 7px 0px #8F9693;">
                    4
                </span>

                <!-- Center '0': Cute Bobbing Burger with Comic Mascot Hat / Expression -->
                <div class="relative w-28 sm:w-36 md:w-44 aspect-square flex items-center justify-center shrink-0 toon-bob">
                    <!-- Spinning / Pulsing Glow Ring behind burger -->
                    <div class="absolute inset-0 rounded-full bg-[#FFC72C]/35 blur-xl -z-10 animate-pulse"></div>

                    <!-- Burger Image -->
                    <img src="{{ asset('images/hero-burger-real.png') }}"
                         alt="Burger Nyasar"
                         class="w-full h-auto object-contain drop-shadow-[0_10px_15px_rgba(0,0,0,0.25)] select-none">

                    <!-- Little floating mascot above burger -->
                    <div class="absolute -top-3 -right-2 bg-[#FAF5E9] border-2 border-black rounded-full p-1.5 shadow-[2px_2px_0px_#000] transform rotate-12">
                        <img src="{{ asset('images/toon-head.png') }}" alt="Toon Mascot" class="w-7 h-7 sm:w-9 sm:h-9 object-contain">
                    </div>
                </div>

                <!-- Last '4' -->
                <span class="text-7xl sm:text-8xl md:text-9xl font-black text-[#27443E] tracking-tighter"
                      style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive; text-shadow: 4px 4px 0px #000, 7px 7px 0px #8F9693;">
                    4
                </span>
            </div>

            <!-- Punchy Comic Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl text-[#243F3B] uppercase tracking-wide mt-2"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                Waduh! Burgernya Hilang Jejak
            </h1>

            <!-- Humorous & Friendly Subtitle -->
            <p class="text-xs sm:text-sm md:text-base text-gray-600 max-w-lg mx-auto mt-3 leading-relaxed">
                Halaman yang kamu tuju sepertinya sudah ludes dilahap pelanggan lain atau salah kirim ke dapur rahasia. Jangan biarkan perut keroncongan, yuk balik ke menu lezat kami!
            </p>

            <!-- Decorative Divider -->
            <div class="w-24 h-1.5 bg-[#F5B027] border border-black rounded-full mx-auto my-6"></div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4 pt-1">
                <!-- Home Button -->
                <a href="{{ route('home') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#27443E] hover:bg-[#1E3631] text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-[2px_2px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition duration-150 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>

                <!-- Explore Menu Button -->
                <a href="{{ route('menu') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#FFC72C] hover:bg-[#E8A400] text-gray-950 font-black text-xs sm:text-sm px-6 py-3.5 rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-[2px_2px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition duration-150 active:scale-95">
                    <span>🍔</span>
                    <span>Lihat Menu Lezat</span>
                    <span>&rarr;</span>
                </a>
            </div>

            <!-- Quick Hint Footer -->
            <div class="mt-8 pt-6 border-t border-gray-200/80 text-[11px] sm:text-xs text-gray-500 flex items-center justify-center gap-1.5">
                <span>Butuh bantuan cepat?</span>
                <a href="{{ route('contact') }}" class="font-bold text-[#27443E] hover:text-[#E03A3A] underline underline-offset-2 transition">
                    Hubungi Outlet Kami
                </a>
            </div>

        </div>

    </div>

</div>
@endsection


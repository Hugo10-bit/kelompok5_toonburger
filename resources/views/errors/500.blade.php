@extends('layouts.app')

@section('title', '500 - Server / Database Terputus | Toon Burger')

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

    <!-- Main 500 Cartoon Card -->
    <div class="relative z-20 max-w-2xl w-full text-center">

        <!-- Card Container with Cartoon Shadow -->
        <div class="bg-white rounded-[32px] border-2 border-black shadow-[8px_8px_0px_#27443E] p-6 sm:p-10 lg:p-12 relative overflow-hidden toon-reveal revealed">

            <!-- Top Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#E03A3A] text-white text-xs sm:text-[13px] font-black uppercase tracking-wider border-2 border-black shadow-[2px_2px_0px_#000] mb-4">
                <span>⚡</span>
                <span>ERROR 500 • SAUS KEJU TUMPAH!</span>
            </div>

            <!-- Big Comic 500 Display with Animated Burger in the Middle -->
            <div class="relative flex items-center justify-center gap-2 sm:gap-4 my-2 sm:my-4">
                <!-- First '5' -->
                <span class="text-7xl sm:text-8xl md:text-9xl font-black text-[#27443E] tracking-tighter"
                      style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive; text-shadow: 4px 4px 0px #000, 7px 7px 0px #8F9693;">
                    5
                </span>

                <!-- Center '0': Bobbing Burger with Surprised Mascot -->
                <div class="relative w-28 sm:w-36 md:w-44 aspect-square flex items-center justify-center shrink-0 toon-bob">
                    <div class="absolute inset-0 rounded-full bg-[#FFC72C]/35 blur-xl -z-10 animate-pulse"></div>

                    <img src="{{ asset('images/hero-burger-real.png') }}"
                         alt="Burger Sedang Error"
                         class="w-full h-auto object-contain drop-shadow-[0_10px_15px_rgba(0,0,0,0.25)] select-none">

                    <div class="absolute -top-3 -right-2 bg-[#FAF5E9] border-2 border-black rounded-full p-1.5 shadow-[2px_2px_0px_#000] transform rotate-12">
                        <img src="{{ asset('images/toon-head.png') }}" alt="Toon Mascot" class="w-7 h-7 sm:w-9 sm:h-9 object-contain">
                    </div>
                </div>

                <!-- Last '0' -->
                <span class="text-7xl sm:text-8xl md:text-9xl font-black text-[#27443E] tracking-tighter"
                      style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive; text-shadow: 4px 4px 0px #000, 7px 7px 0px #8F9693;">
                    0
                </span>
            </div>

            <!-- Punchy Comic Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl text-[#243F3B] uppercase tracking-wide mt-2"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                Waduh! Dapur Kena Guncangan
            </h1>

            <!-- Humorous & Friendly Subtitle -->
            <p class="text-xs sm:text-sm md:text-base text-gray-600 max-w-lg mx-auto mt-3 leading-relaxed">
                Sepertinya ada saus keju yang tumpah di ruang mesin dapur kami. Tim chef Toon Burger sedang beres-beres, yuk coba beberapa saat lagi!
            </p>

            <!-- Comic Speech Bubble -->
            <div class="my-6 p-4 rounded-2xl bg-[#FFF9E6] border-2 border-black shadow-[4px_4px_0px_#27443E] text-left max-w-lg mx-auto flex items-center gap-3">
                <span class="text-2xl leading-none shrink-0">💭</span>
                <p class="text-xs sm:text-[13px] font-bold text-[#27443E] leading-snug m-0">
                    "Panggangan lagi diistirahatkan sejenak. Chef kami lagi nyiapin kembali bahan-bahan segar terbaik!"
                </p>
            </div>

            <!-- Comic Divider -->
            <div class="w-24 h-1.5 bg-[#F5B027] border border-black rounded-full mx-auto my-6"></div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 sm:gap-4 pt-1">
                <button type="button"
                        onclick="window.location.reload()"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#27443E] hover:bg-[#1E3631] text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-[2px_2px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition duration-150 active:scale-95 cursor-pointer">
                    <span>🔄</span>
                    <span>Muat Ulang Halaman</span>
                </button>

                <a href="{{ route('home') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#FFC72C] hover:bg-[#E8A400] text-gray-950 font-black text-xs sm:text-sm px-6 py-3.5 rounded-2xl border-2 border-black shadow-[4px_4px_0px_#000] hover:shadow-[2px_2px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition duration-150 active:scale-95">
                    <span>🏠</span>
                    <span>Ke Halaman Utama</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

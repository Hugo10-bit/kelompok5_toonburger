@php
    $headline = $headline ?? 'SETIAP GIGITAN<br>PUNYA CERITA!';
    $headlineDesktopClass = $headlineDesktopClass ?? 'lg:text-[56px] xl:text-[64px]';
    $subtitle = $subtitle ?? 'Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.';
    $ctaHref = $ctaHref ?? route('menu');
    $revealClass = $revealClass ?? 'toon-reveal-left';
@endphp

<section id="hero-section" class="relative overflow-hidden -mt-[105px] sm:-mt-[112px]">
    <div class="w-full">
        <!-- Hero Background: Dark Slate Green (#385850) -->
        <div class="relative overflow-hidden w-full pt-[122px] sm:pt-36 lg:pt-40 min-h-0 sm:min-h-[520px] flex flex-col justify-between"
             style="background-color: #385850;">

            <!-- Concentric / wavy retro background curves -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1000 500">
                <path d="M-100,50 C200,20 400,120 700,70 C900,30 1100,100 1200,80" fill="none" stroke="#fff" stroke-width="1.5"/>
                <path d="M-100,120 C200,90 400,190 700,140 C900,100 1100,170 1200,150" fill="none" stroke="#fff" stroke-width="1.5"/>
                <path d="M-100,190 C200,160 400,260 700,210 C900,170 1100,240 1200,220" fill="none" stroke="#fff" stroke-width="1.5"/>
                <path d="M-100,260 C200,230 400,330 700,280 C900,240 1100,310 1200,290" fill="none" stroke="#fff" stroke-width="1.5"/>
            </svg>

            <!-- Comic Sparkles (Desktop coordinates preserved; safe framing on mobile) -->
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="24"
                 height="24"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-6 h-auto"
                 style="top: 24%; left: 3%;">
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="20"
                 height="20"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-5 h-auto"
                 style="top: 42%; left: 52%;">
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="20"
                 height="20"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-5 h-auto"
                 style="bottom: 16%; right: 23%;">
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="24"
                 height="24"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-6 h-auto"
                 style="bottom: 12%; left: 40%;">

            <!-- Mobile-only balanced sparkles flanking burger cluster without touching text or checkered border -->
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="16"
                 height="16"
                 decoding="async"
                 class="comic-sparkle sm:hidden absolute pointer-events-none select-none z-10 w-4 h-auto"
                 style="bottom: 24%; left: 10%;">
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="14"
                 height="14"
                 decoding="async"
                 class="comic-sparkle sm:hidden absolute pointer-events-none select-none z-10 w-3.5 h-auto"
                 style="bottom: 19%; right: 11%;">

            <!-- Content Grid -->
            <div class="relative z-10 max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-12 items-center px-5 sm:px-10 lg:px-12 pt-1 sm:pt-6 pb-4 sm:pb-8">

                <!-- Left: Headline + Subtitle + Buttons -->
                <div class="lg:col-span-6 space-y-2.5 sm:space-y-4 pb-2 sm:pb-6 lg:pb-10 {{ $revealClass }}">
                    <h1 class="font-brand text-white uppercase leading-[0.96] sm:leading-[0.95] drop-shadow-sm text-[30px] sm:text-5xl {{ $headlineDesktopClass }}"
                        style="font-family: 'Luckiest Guy', cursive, sans-serif;">
                        {!! $headline !!}
                    </h1>

                    <p class="text-[13px] sm:text-sm md:text-base text-white/90 leading-relaxed max-w-[300px] sm:max-w-md">
                        {{ $subtitle }}
                    </p>

                    <!-- CTA Buttons: Pickup Order & Delivery Order -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3.5 pt-1 sm:pt-2">
                        <a href="{{ $ctaHref }}"
                           class="min-h-[38px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-black/80 bg-[#f5a623] hover:bg-[#e0961f] text-black shadow-[2px_2px_0px_#000] transition active:translate-x-[1px] active:translate-y-[1px] cursor-pointer">
                            Pickup Order
                        </a>
                        <a href="{{ $ctaHref }}"
                           class="min-h-[38px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-white/80 bg-[#385850] hover:bg-[#2d4741] text-white transition cursor-pointer">
                            Delivery Order
                        </a>
                    </div>
                </div>

                <!-- Right: Burger + Speech Bubble Cluster -->
                <div class="lg:col-span-6 relative flex justify-center lg:justify-start items-center pt-7 sm:pt-8 lg:pt-10 pb-3 sm:pb-6 lg:pb-8 lg:pl-12 xl:pl-16 toon-reveal-right reveal-delay-150">
                    <div class="relative select-none -translate-x-6 sm:translate-x-0">

                        <!-- Hero Double/Triple Cheeseburger -->
                        <div class="relative z-10 flex justify-center items-end">
                            <!-- Small comic white accent lines above burger -->
                            <div class="absolute -top-3 left-[18%] flex gap-1 opacity-80 pointer-events-none z-20">
                                <span class="w-1 h-2.5 bg-white rounded-full -rotate-12"></span>
                                <span class="w-1 h-3 bg-white rounded-full"></span>
                                <span class="w-1 h-2.5 bg-white rounded-full rotate-12"></span>
                            </div>

                            <img id="hero-burger-img"
                                 src="{{ asset('images/hero-burger.png') }}"
                                 alt="Very Cheese Burger"
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="async"
                                 width="200"
                                 height="175"
                                 class="w-[136px] sm:w-[175px] md:w-[190px] lg:w-[200px] xl:w-[215px] h-auto object-contain cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105 active:scale-95 drop-shadow-[0_12px_24px_rgba(0,0,0,0.35)] select-none">
                        </div>

                        <!-- Starburst Comic Speech Bubble ("VERY CHEESE BURGER") -->
                        <div class="absolute -top-7 sm:-top-16 md:-top-20 lg:-top-[86px] xl:-top-[92px] left-[76%] sm:left-[85%] md:left-[92%] lg:left-[98%] xl:left-[100%] z-20 pointer-events-auto cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                            <img id="hero-badge-img"
                                 src="{{ asset('images/very-cheese-badge.png') }}"
                                 alt="VERY CHEESE BURGER"
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="async"
                                 width="240"
                                 height="145"
                                 class="w-[132px] sm:w-[180px] md:w-[205px] lg:w-[225px] xl:w-[240px] max-w-none h-auto object-contain drop-shadow-md select-none">
                        </div>

                    </div>
                </div>

            </div>

            <div class="w-full mt-auto">
                <!-- Checkered Accent Line (2 rows on mobile, 3 rows on sm+) -->
                <div class="w-full relative z-20 h-[24px] sm:h-[36px]" style="background: repeating-conic-gradient(#385850 0% 25%, #ffffff 0% 50%) 0 0 / 24px 24px;"></div>

                <!-- Dark Green Bottom Spacer -->
                <div class="w-full h-3.5 sm:h-9 lg:h-10"></div>
            </div>

        </div>
    </div>
</section>

@php
    $headline = $headline ?? 'SETIAP GIGITAN<br>PUNYA CERITA!';
    $headlineDesktopClass = $headlineDesktopClass ?? 'lg:text-[62px] xl:text-[72px]';
    $subtitle = $subtitle ?? 'Nikmati perpaduan rasa, tekstur, dan bahan pilihan dalam setiap hidangan.';
    $ctaHref = $ctaHref ?? route('menu');
    $deliveryHref = $deliveryHref ?? route('gofood');
    $isAnimatedHero = ($isHome ?? false) || ($animateMotion ?? false);
    $revealClass = $isAnimatedHero ? '' : ($revealClass ?? 'toon-reveal-left');
    $rightRevealClass = $isAnimatedHero ? '' : 'toon-reveal-right reveal-delay-150';
@endphp

<section id="hero-section" class="relative overflow-hidden -mt-[105px] sm:-mt-[112px]">
    <div class="w-full">
        <!-- Hero Background: Dark Slate Green (#385850) -->
        <div class="relative overflow-hidden w-full pt-[122px] sm:pt-36 lg:pt-40 min-h-0 sm:min-h-[520px] flex flex-col justify-between"
             style="background-color: #385850;">

            <!-- Hero SVG Background Pattern -->
            <img src="{{ asset('images/hero-pattern.svg') }}"
                 alt=""
                 aria-hidden="true"
                 decoding="async"
                 class="absolute inset-0 w-full h-full object-cover pointer-events-none select-none">

            <!-- Comic Sparkles (Desktop coordinates aligned with reference layout; safe framing on mobile) -->
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="24"
                 height="24"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-6 h-auto"
                 style="top: 24%; left: 4%;">
            <img src="{{ asset('images/star-sparkle.png') }}"
                 alt="Sparkle"
                 width="24"
                 height="24"
                 decoding="async"
                 class="comic-sparkle hidden sm:block absolute pointer-events-none select-none z-10 w-6 h-auto"
                 style="bottom: 16%; left: 41%;">

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

            <!-- Content Container -->
            <div class="relative z-10 max-w-[1400px] xl:max-w-[1440px] mx-auto w-full flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-8 px-5 sm:px-8 lg:px-12 xl:px-16 pt-1 sm:pt-4 lg:pt-2 pb-4 sm:pb-8 lg:pb-10">

                <!-- Left: Headline + Subtitle + Buttons -->
                <div class="w-full lg:max-w-[580px] xl:max-w-[660px] space-y-2.5 sm:space-y-4 pb-2 sm:pb-4 lg:pb-0 {{ $revealClass }}">
                    <h1 @if($isAnimatedHero) data-gsap-text="hero-heading" @endif
                        class="font-brand text-white uppercase leading-[0.96] sm:leading-[0.95] text-[34px] sm:text-[54px] {{ $headlineDesktopClass }}"
                        style="font-family: 'Luckiest Guy', cursive, sans-serif; text-shadow: 4px 4px 0px #000000;">
                        {!! $headline !!}
                    </h1>

                    <p @if($isAnimatedHero) data-gsap-text="hero-subtitle" @endif
                       class="text-[14px] sm:text-base md:text-lg lg:text-[18px] text-white/90 leading-relaxed max-w-[330px] sm:max-w-lg">
                        {{ $subtitle }}
                    </p>

                    <!-- CTA Buttons: Pickup Order & Delivery Order -->
                    <div class="flex flex-wrap items-center gap-2.5 sm:gap-3.5 pt-1 sm:pt-2">
                        <a href="{{ $ctaHref }}"
                           @if($isAnimatedHero) data-gsap-text="hero-cta" @endif
                           class="min-h-[38px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-black/80 bg-[#f5a623] hover:bg-[#e0961f] text-black shadow-[2px_2px_0px_#000] transition active:translate-x-[1px] active:translate-y-[1px] whitespace-nowrap cursor-pointer">
                            Ambil di tempat
                        </a>
                        <a href="{{ $deliveryHref }}"
                           @if($isAnimatedHero) data-gsap-text="hero-cta" @endif
                           class="min-h-[38px] sm:min-h-[44px] inline-flex items-center justify-center font-medium text-xs sm:text-sm px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl border border-white/80 bg-[#385850] hover:bg-[#2d4741] text-white transition whitespace-nowrap cursor-pointer">
                            Pesan Antar
                        </a>
                    </div>
                </div>

                <!-- Right: Burger + Speech Bubble Cluster -->
                <div @if($isAnimatedHero) data-motion-card="hero-burger" @endif class="relative flex justify-center lg:justify-end items-center shrink-0 pt-7 sm:pt-8 lg:pt-0 pb-3 sm:pb-6 lg:pb-0 lg:pr-[240px] xl:pr-[284px] {{ $rightRevealClass }}">
                    <div class="relative select-none -translate-x-6 sm:-translate-x-16 md:-translate-x-20 lg:translate-x-0">

                        <!-- Hero Double/Triple Cheeseburger -->
                        <div class="relative z-10 flex justify-center items-end">
                            <!-- Small comic white accent lines above top-left of burger -->
                            <div class="absolute -top-2.5 left-[4%] -rotate-[24deg] flex gap-1 opacity-85 pointer-events-none z-20">
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
                                 width="285"
                                 height="250"
                                 class="w-[144px] sm:w-[190px] md:w-[210px] lg:w-[240px] xl:w-[285px] h-auto object-contain cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105 active:scale-95 drop-shadow-[0_12px_24px_rgba(0,0,0,0.35)] select-none">
                        </div>

                        <!-- Desktop Sparkle: between upper burger & speech bubble -->
                        <img src="{{ asset('images/star-sparkle.png') }}"
                             alt="Sparkle"
                             width="20"
                             height="20"
                             decoding="async"
                             class="comic-sparkle hidden sm:block absolute -top-6 lg:-top-7 left-[92%] lg:left-[95%] pointer-events-none select-none z-10 w-5 h-auto">

                        <!-- Desktop Sparkle: below speech bubble / right of burger bottom -->
                        <img src="{{ asset('images/star-sparkle.png') }}"
                             alt="Sparkle"
                             width="20"
                             height="20"
                             decoding="async"
                             class="comic-sparkle hidden sm:block absolute bottom-1 lg:bottom-2 left-[112%] lg:left-[116%] pointer-events-none select-none z-10 w-5 h-auto">

                        <!-- Starburst Comic Speech Bubble ("VERY CHEESE BURGER") -->
                        <div class="absolute -top-7 sm:-top-10 md:-top-11 lg:-top-7 xl:-top-9 left-[76%] sm:left-[88%] md:left-[94%] lg:left-[108%] xl:left-[110%] z-20 pointer-events-auto cursor-pointer transition-transform duration-300 ease-[cubic-bezier(0.22,1,0.36,1)] hover:scale-105">
                            <img id="hero-badge-img"
                                 src="{{ asset('images/very-cheese-badge.png') }}"
                                 alt="VERY CHEESE BURGER"
                                 fetchpriority="high"
                                 loading="eager"
                                 decoding="async"
                                 width="255"
                                 height="154"
                                 class="w-[132px] sm:w-[180px] md:w-[205px] lg:w-[220px] xl:w-[255px] max-w-none h-auto object-contain drop-shadow-md select-none">
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

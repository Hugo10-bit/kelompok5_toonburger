@extends('layouts.app')

@section('title', 'Tentang Kami - Toon Burger')

@section('content')
<div>
    {{-- Negative top margin pulls the perspective grid behind the sticky translucent navbar, matching contact.blade.php. --}}
    <section class="relative overflow-hidden -mt-[88px] sm:-mt-[96px] pt-[118px] sm:pt-[126px] pb-10 sm:pb-14 lg:pb-16 px-4 sm:px-6 lg:px-8 border-b border-[#E2D9C5]"
             style="background-color: #FAF3E3;">

        <div class="absolute inset-0 pointer-events-none select-none overflow-hidden z-0" aria-hidden="true">
            <svg class="w-full h-full" viewBox="0 0 1440 700" preserveAspectRatio="none" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g stroke="#DFD5C0" stroke-width="1">
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

        <div class="relative z-10 max-w-6xl mx-auto toon-reveal">
            <div class="bg-white rounded-[26px] border-[1.5px] border-black shadow-[5px_6px_0px_#8F9693] p-4 sm:p-6 lg:p-7">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 lg:gap-8 items-center">

                    <div class="lg:col-span-6 grid grid-cols-2 gap-3 sm:gap-4">
                        <div class="rounded-2xl overflow-hidden bg-[#141414] aspect-[351/429]">
                            <img src="{{ asset('images/about-burger-1.png') }}"
                                 alt="Burger daging sapi panggang Toon Burger dengan keju leleh dan beef strip renyah"
                                 width="351"
                                 height="429"
                                 fetchpriority="high"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="rounded-2xl overflow-hidden bg-[#24120A] aspect-[351/429]">
                            <img src="{{ asset('images/about-burger-2.png') }}"
                                 alt="Detail lelehan dua macam keju dan daging asap panggang di dalam roti brioche"
                                 width="351"
                                 height="429"
                                 loading="eager"
                                 class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="lg:col-span-6 space-y-3.5 sm:space-y-4 lg:pr-3 py-1">
                        <h1 class="text-2xl sm:text-3xl lg:text-[30px] text-[#27443E] uppercase tracking-wide leading-tight"
                            style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                            TENTANG TOON BURGER
                        </h1>

                        <p class="text-xs sm:text-[13.5px] text-[#4B5563] leading-relaxed">
                            Toon Burger lahir dari mimpi sederhana: menciptakan burger yang tidak hanya mengenyangkan perut, tetapi juga menghadirkan kebahagiaan sejati seperti saat menonton kartun favorit di masa kecil.
                        </p>

                        <p class="text-xs sm:text-[13.5px] text-[#4B5563] leading-relaxed">
                            Banyak burger modern kehilangan jati dirinya, seperti daging yang kering, roti yang terlalu manis, atau saus buatan pabrik yang serba instan. Di Toon Burger, kami memilih jalur yang berbeda: kami menggunakan <strong class="font-semibold text-[#1F2937]">100% daging sapi lokal pilihan</strong> tanpa campuran tepung, memanggang roti brioche mentega lembut setiap pagi, dan meracik saus khas dapur kami dari nol.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section aria-label="Capaian Toon Burger"
             class="w-full border-b border-[#E2D9C5] py-7 sm:py-9 lg:py-10 px-4 sm:px-6 lg:px-8"
             style="background-color: #FAF3E3;">
        <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-y-6 gap-x-6 sm:gap-x-8 toon-reveal">
            <div class="flex flex-col items-start md:items-start">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-[#111827] tracking-tight leading-none">
                    15.000+
                </span>
                <span class="text-[11.5px] sm:text-xs text-[#57534E] font-medium mt-1.5">
                    Burger Terjual &amp; Ludes
                </span>
            </div>

            <div class="flex flex-col items-start md:items-start">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-[#111827] tracking-tight leading-none">
                    100%
                </span>
                <span class="text-[11.5px] sm:text-xs text-[#57534E] font-medium mt-1.5">
                    Terbuat dari daging asli
                </span>
            </div>

            <div class="flex flex-col items-start md:items-start">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-[#111827] tracking-tight leading-none">
                    90%
                </span>
                <span class="text-[11.5px] sm:text-xs text-[#57534E] font-medium mt-1.5">
                    Kepuasan Pelanggan
                </span>
            </div>

            <div class="flex flex-col items-start md:items-start">
                <span class="text-2xl sm:text-3xl lg:text-[34px] font-extrabold text-[#111827] tracking-tight leading-none">
                    5.0/5.0
                </span>
                <span class="text-[11.5px] sm:text-xs text-[#57534E] font-medium mt-1.5">
                    Rating pelanggan di Gofood
                </span>
            </div>
        </div>
    </section>

    <section class="about-fine-grid-bg py-10 sm:py-13 lg:py-16 px-4 sm:px-6 lg:px-8 border-b border-[#E2D9C5]">
        <div class="max-w-6xl mx-auto toon-reveal">
            <div id="about-visi-misi-carousel"
                 role="region"
                 aria-roledescription="carousel"
                 aria-label="Visi dan Misi Toon Burger"
                 class="relative w-full h-[320px] sm:h-[380px] lg:h-[445px] rounded-[24px] sm:rounded-[28px] overflow-hidden bg-[#121816] shadow-[0_14px_34px_-10px_rgba(30,46,43,0.22)] select-none">

                <div class="absolute inset-0">
                    <img data-slide-photo="0"
                         src="{{ asset('images/about-visi.png') }}"
                         alt="Hidangan lengkap burger sapi, ayam goreng renyah, kentang goreng, dan saus racikan dapur Toon Burger"
                         width="1010"
                         height="350"
                         class="about-slide-photo is-active absolute inset-0 w-full h-full object-cover object-[58%_center] sm:object-center">

                    <img data-slide-photo="1"
                         src="{{ asset('images/about-misi.png') }}"
                         alt="Pelanggan menikmati double smash burger hangat dengan keju leleh dan bawang karamel"
                         width="1010"
                         height="350"
                         class="about-slide-photo absolute inset-0 w-full h-full object-cover object-center">
                </div>

                {{-- Stationary dark scrim guarantees >= 4.5:1 AA contrast across the entire bottom caption and controls area. --}}
                <div class="absolute inset-0 z-10 pointer-events-none"
                     aria-hidden="true"
                     style="background: linear-gradient(to top, rgba(8, 12, 11, 0.95) 0%, rgba(8, 12, 11, 0.84) 32%, rgba(8, 12, 11, 0.30) 58%, rgba(8, 12, 11, 0) 78%);"></div>

                <div class="absolute inset-x-0 bottom-0 z-20 px-5 pt-5 pb-6 sm:px-7 sm:pt-7 sm:pb-8 lg:px-9 lg:pt-9 lg:pb-10 flex flex-col sm:flex-row sm:items-end justify-between gap-4">

                    <div id="about-carousel-live" class="relative min-h-[108px] sm:min-h-[96px] flex-1 max-w-xl" aria-live="off">
                        <div data-slide-caption="0"
                             class="about-slide-caption is-active">
                            <h2 class="text-lg sm:text-xl lg:text-[23px] font-bold text-white tracking-tight leading-snug">
                                Visi Kami
                            </h2>
                            <p class="text-xs sm:text-[13.5px] text-white/95 leading-relaxed mt-1.5">
                                Menjadi destinasi burger lokal kebanggaan Banjarbaru yang menyajikan rasa daging sapi asli, roti brioche panggang segar, dan saus racikan dapur sendiri dalam setiap porsi yang jujur dan mengenyangkan.
                            </p>
                        </div>

                        <div data-slide-caption="1"
                             aria-hidden="true"
                             class="about-slide-caption absolute inset-x-0 bottom-0">
                            <h2 class="text-lg sm:text-xl lg:text-[23px] font-bold text-white tracking-tight leading-snug">
                                Misi Kami
                            </h2>
                            <p class="text-xs sm:text-[13.5px] text-white/95 leading-relaxed mt-1.5">
                                Menggiling 100% daging sapi pilihan tanpa campuran tepung setiap hari, memanggang burger saat pesanan masuk agar tiba tetap hangat, serta menjaga standar dapur halal dan bersih untuk setiap pelanggan.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2.5 shrink-0 self-end">
                        <button type="button"
                                id="about-carousel-prev"
                                onclick="stepAboutSlide(-1)"
                                aria-label="Slide sebelumnya (Visi atau Misi)"
                                class="w-11 h-11 rounded-full border-[1.5px] border-white/85 bg-[#0B1110]/75 hover:bg-white hover:text-[#111827] text-white flex items-center justify-center transition cursor-pointer active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F4BE1E]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m0 0l6-6m-6 6l6 6"/>
                            </svg>
                        </button>

                        <button type="button"
                                id="about-carousel-next"
                                onclick="stepAboutSlide(1)"
                                aria-label="Slide berikutnya (Visi atau Misi)"
                                class="w-11 h-11 rounded-full border-[1.5px] border-white/85 bg-[#0B1110]/75 hover:bg-white hover:text-[#111827] text-white flex items-center justify-center transition cursor-pointer active:scale-95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#F4BE1E]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0l-6-6m6 6l-6 6"/>
                            </svg>
                        </button>
                    </div>

                </div>

                {{-- Bottom 10-second progress bar synchronized with the automatic Visi/Misi slide transition. --}}
                <div class="absolute inset-x-0 bottom-0 z-30 h-1.5 sm:h-[6px] bg-white/15 overflow-hidden pointer-events-none" aria-hidden="true">
                    <div id="about-carousel-progress"
                         class="h-full w-full bg-white origin-left"
                         style="transform: scaleX(0); will-change: transform;"></div>
                </div>
            </div>
        </div>
    </section>

    @php
        $reviews = [
            [
                'name' => 'Putri Arina',
                'quote' => 'Telat mau nyobain karena baru kesampaian, enakk bangett baru tau sayur selada dkk ya disaus makanya gurih bangett, next bakal order lagi',
                'theme' => 'yellow',
                'tilt' => 'lg:rotate-[2.4deg]',
            ],
            [
                'name' => 'Bram',
                'quote' => 'Rasa udah improve, udah engga ada dominan asam lagi dan sudah balance, saus signature nya sudah mulai berasa, good job',
                'theme' => 'green',
                'tilt' => 'lg:-rotate-[1.5deg]',
            ],
            [
                'name' => 'Hasnul',
                'quote' => 'Enak bangett burgernyaaa, menunya dilengkapin lagi plisssssss',
                'theme' => 'cream',
                'tilt' => 'lg:rotate-[2deg]',
            ],
            [
                'name' => 'Nadya Nabilah',
                'quote' => 'Tertau karna iklan, baru pertama nyoba eh seenak ituuu, balik lagi besokk',
                'theme' => 'yellow',
                'tilt' => 'lg:-rotate-[1.6deg]',
            ],
            [
                'name' => 'Jihan',
                'quote' => 'Enak bangettttttt, kejunyaaaaaaaa',
                'theme' => 'cream',
                'tilt' => 'lg:-rotate-[2.8deg]',
            ],
            [
                'name' => 'Ayu Dewi Fortuna',
                'quote' => 'Enakk sekali burgernya dan red velvet nya enak juga',
                'theme' => 'yellow',
                'tilt' => 'lg:rotate-[1.3deg]',
            ],
            [
                'name' => 'Anindya Esti',
                'quote' => 'Selalu enak, bestttt burger in townn!!!',
                'theme' => 'green',
                'tilt' => 'lg:-rotate-[1.8deg]',
            ],
        ];

        $themeStyles = [
            'yellow' => [
                'bg' => 'bg-[#F4BE1E]',
                'star' => 'text-[#1E2E2B]',
                'name' => 'text-[#1E2E2B]',
                'quote' => 'text-[#243733]',
                'divider' => 'border-[#1E2E2B]/25',
                'watermark' => 'text-[#1E2E2B]/15',
            ],
            'green' => [
                'bg' => 'bg-[#3B5954]',
                'star' => 'text-white',
                'name' => 'text-white',
                'quote' => 'text-[#F1F6F5]',
                'divider' => 'border-white/30',
                'watermark' => 'text-white/15',
            ],
            'cream' => [
                'bg' => 'bg-[#F6EBB9]',
                'star' => 'text-[#2D4C46]',
                'name' => 'text-[#1E2E2B]',
                'quote' => 'text-[#2A413D]',
                'divider' => 'border-[#27443E]/25',
                'watermark' => 'text-[#27443E]/15',
            ],
        ];
    @endphp

    <section class="retro-grid-bg pt-12 pb-24 sm:pt-16 sm:pb-28 lg:pt-20 lg:pb-32 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12 lg:mb-14 toon-reveal">
                <h2 class="text-2xl sm:text-3xl lg:text-[34px] text-[#27443E] uppercase tracking-wide leading-tight"
                    style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive;">
                    KATA MEREKA YANG UDAH NYOBA!
                </h2>
                <p class="text-xs sm:text-[13px] text-[#57534E] leading-relaxed mt-2 flex items-center justify-center gap-2 flex-wrap">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#57534E] shrink-0" aria-hidden="true"></span>
                    <span>Karena rasa yang enak nggak bohong, intip apa kata mereka yang udah ngerasain kenyang puasnya burger racikan dapur kami.</span>
                </p>
            </div>

            {{-- Desktop uses the 4 + 3 staggered sticky-note wall; tablet reflows to a 2-column grid; phone stacks cleanly. --}}
            <div class="hidden lg:block space-y-5 toon-reveal">
                <div class="grid grid-cols-4 gap-3.5">
                    @foreach(array_slice($reviews, 0, 4) as $review)
                        @php $s = $themeStyles[$review['theme']]; @endphp
                        <article class="sticky-review-card relative {{ $s['bg'] }} {{ $review['tilt'] }} border-[2.5px] border-white rounded-[6px] shadow-[0_12px_24px_-6px_rgba(30,46,43,0.22)] p-5 min-h-[245px] flex flex-col items-center justify-between text-center">
                            <div class="w-full flex flex-col items-center">
                                <div class="flex items-center justify-center gap-1.5 {{ $s['star'] }} mt-1" aria-label="Rating 5 dari 5 bintang">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.18 3.63a1 1 0 00.95.69h3.817c.969 0 1.371 1.24.588 1.81l-3.088 2.244a1 1 0 00-.364 1.118l1.18 3.63c.3.921-.755 1.688-1.54 1.118l-3.088-2.244a1 1 0 00-1.175 0l-3.088 2.244c-.784.57-1.838-.197-1.539-1.118l1.18-3.63a1 1 0 00-.364-1.118L2.52 9.057c-.783-.57-.38-1.81.588-1.81h3.817a1 1 0 00.95-.69l1.174-3.63z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <h3 class="font-bold text-xs {{ $s['name'] }} mt-4">
                                    {{ $review['name'] }}
                                </h3>

                                <div class="w-4/5 border-t border-dashed {{ $s['divider'] }} my-2.5" aria-hidden="true"></div>

                                <p class="text-[11.5px] leading-relaxed font-medium {{ $s['quote'] }}">
                                    "{{ $review['quote'] }}"
                                </p>
                            </div>

                            <div class="pt-3 {{ $s['watermark'] }}" aria-hidden="true">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                                </svg>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="grid grid-cols-3 gap-4 max-w-[760px] mx-auto">
                    @foreach(array_slice($reviews, 4, 3) as $review)
                        @php $s = $themeStyles[$review['theme']]; @endphp
                        <article class="sticky-review-card relative {{ $s['bg'] }} {{ $review['tilt'] }} border-[2.5px] border-white rounded-[6px] shadow-[0_12px_24px_-6px_rgba(30,46,43,0.22)] p-5 min-h-[245px] flex flex-col items-center justify-between text-center">
                            <div class="w-full flex flex-col items-center">
                                <div class="flex items-center justify-center gap-1.5 {{ $s['star'] }} mt-1" aria-label="Rating 5 dari 5 bintang">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.18 3.63a1 1 0 00.95.69h3.817c.969 0 1.371 1.24.588 1.81l-3.088 2.244a1 1 0 00-.364 1.118l1.18 3.63c.3.921-.755 1.688-1.54 1.118l-3.088-2.244a1 1 0 00-1.175 0l-3.088 2.244c-.784.57-1.838-.197-1.539-1.118l1.18-3.63a1 1 0 00-.364-1.118L2.52 9.057c-.783-.57-.38-1.81.588-1.81h3.817a1 1 0 00.95-.69l1.174-3.63z"/>
                                        </svg>
                                    @endfor
                                </div>

                                <h3 class="font-bold text-xs {{ $s['name'] }} mt-4">
                                    {{ $review['name'] }}
                                </h3>

                                <div class="w-4/5 border-t border-dashed {{ $s['divider'] }} my-2.5" aria-hidden="true"></div>

                                <p class="text-[11.5px] leading-relaxed font-medium {{ $s['quote'] }}">
                                    "{{ $review['quote'] }}"
                                </p>
                            </div>

                            <div class="pt-3 {{ $s['watermark'] }}" aria-hidden="true">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                                </svg>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5 lg:hidden toon-reveal">
                @foreach($reviews as $idx => $review)
                    @php
                        $s = $themeStyles[$review['theme']];
                        $mobileTilt = $idx % 2 === 0 ? 'sm:rotate-[1deg]' : 'sm:-rotate-[1deg]';
                        $lastSpan = $idx === count($reviews) - 1 ? 'sm:col-span-2 sm:max-w-[calc(50%-0.625rem)] sm:mx-auto w-full' : '';
                    @endphp
                    <article class="sticky-review-card relative {{ $s['bg'] }} {{ $mobileTilt }} {{ $lastSpan }} border-[2.5px] border-white rounded-[8px] shadow-[0_10px_22px_-6px_rgba(30,46,43,0.2)] p-5 min-h-[210px] flex flex-col items-center justify-between text-center">
                        <div class="w-full flex flex-col items-center">
                            <div class="flex items-center justify-center gap-1.5 {{ $s['star'] }}" aria-label="Rating 5 dari 5 bintang">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.18 3.63a1 1 0 00.95.69h3.817c.969 0 1.371 1.24.588 1.81l-3.088 2.244a1 1 0 00-.364 1.118l1.18 3.63c.3.921-.755 1.688-1.54 1.118l-3.088-2.244a1 1 0 00-1.175 0l-3.088 2.244c-.784.57-1.838-.197-1.539-1.118l1.18-3.63a1 1 0 00-.364-1.118L2.52 9.057c-.783-.57-.38-1.81.588-1.81h3.817a1 1 0 00.95-.69l1.174-3.63z"/>
                                    </svg>
                                @endfor
                            </div>

                            <h3 class="font-bold text-xs sm:text-[13px] {{ $s['name'] }} mt-3.5">
                                {{ $review['name'] }}
                            </h3>

                            <div class="w-4/5 border-t border-dashed {{ $s['divider'] }} my-2.5" aria-hidden="true"></div>

                            <p class="text-xs leading-relaxed font-medium {{ $s['quote'] }}">
                                "{{ $review['quote'] }}"
                            </p>
                        </div>

                        <div class="pt-3 {{ $s['watermark'] }}" aria-hidden="true">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 3h-2v3h-3l1 14h6l1-14h-3V3zM7 11c-2.76 0-5 1.79-5 4h10c0-2.21-2.24-4-5-4zm-5 6c0 1.66 1.34 3 3 3h4c1.66 0 3-1.34 3-3H2z"/>
                            </svg>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>
</div>

<script src="{{ asset('js/pages/about.js') }}"></script>
@endsection

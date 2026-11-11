<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Page Not Found - Toon Burger</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&family=Fredoka:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #8687ab;
            color: #2d294a;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .font-comic-num {
            font-family: 'Fredoka', 'Plus Jakarta Sans', sans-serif;
        }

        @keyframes gentleFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(-1deg); }
        }

        @keyframes bubbleBob {
            0%, 100% { transform: scale(1) translateY(0); }
            50% { transform: scale(1.03) translateY(-4px); }
        }

        .anim-ghost {
            animation: gentleFloat 5s ease-in-out infinite;
        }

        .anim-bubble {
            animation: bubbleBob 3.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen w-full bg-[#8687ab] relative flex flex-col justify-between overflow-x-hidden selection:bg-[#aed581] selection:text-[#2d294a]">

    <!-- Decorative Subtle Background Swirls (matching watermarks in reference image) -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden select-none opacity-20">
        <!-- Top Left Swirl -->
        <svg class="absolute -top-12 -left-12 w-96 h-96 text-white/30" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,20 C120,20 140,30 150,50 C160,70 155,95 140,110 C125,125 100,130 80,120 C60,110 50,85 60,65 C70,45 95,45 105,60 C115,75 105,95 90,95 C75,95 70,80 80,70 C90,60 100,70 100,80" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>
        </svg>
        <!-- Top Right Swirl -->
        <svg class="absolute top-24 right-12 w-80 h-80 text-white/20" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,20 C140,20 170,50 170,90 C170,130 140,160 100,160 C60,160 30,130 30,90 C30,60 55,35 85,35 C115,35 140,60 140,90 C140,115 120,135 95,135 C70,135 55,115 55,95 C55,80 70,65 85,65" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round"/>
        </svg>
        <!-- Center Right Swirl -->
        <svg class="absolute top-1/2 -right-16 w-96 h-96 text-white/25" viewBox="0 0 200 200" fill="currentColor">
            <circle cx="100" cy="100" r="70" fill="none" stroke="currentColor" stroke-width="6" stroke-dasharray="12 12"/>
            <circle cx="100" cy="100" r="45" fill="none" stroke="currentColor" stroke-width="6" stroke-dasharray="8 8"/>
            <circle cx="100" cy="100" r="20" fill="none" stroke="currentColor" stroke-width="6"/>
        </svg>
        <!-- Bottom Left Swirl -->
        <svg class="absolute bottom-6 left-1/3 w-72 h-72 text-white/15" viewBox="0 0 200 200" fill="currentColor">
            <path d="M100,30 C135,30 160,55 160,90 C160,125 135,150 100,150 C65,150 40,125 40,90 C40,65 60,45 85,45 C110,45 130,65 130,90" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
        </svg>
    </div>

    <!-- Top Header Bar matching reference image (Logo on Left, Web URL on Right) -->
    <header class="relative z-20 w-full px-6 sm:px-12 pt-6 sm:pt-8 flex items-center justify-between">
        <!-- Logo Area with border box matching "YOUR LOGO" aesthetic in photo -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-lg border-2 border-[#b2d56d] bg-[#8687ab]/40 hover:bg-[#8687ab]/80 transition group shadow-sm">
            <img src="{{ asset('images/logo.png') }}" alt="Toon Burger" class="w-8 h-8 sm:w-9 sm:h-9 object-contain group-hover:rotate-6 transition-transform">
            <div class="leading-none text-left">
                <span class="block text-[10px] sm:text-[11px] font-black tracking-widest text-[#b2d56d] uppercase">TOON</span>
                <span class="block text-[10px] sm:text-[11px] font-black tracking-widest text-[#b2d56d] uppercase">BURGER</span>
            </div>
        </a>

        <!-- Top Right Web Address matching "www.yourwebhere.com" in photo -->
        <div class="text-[#b2d56d] text-xs sm:text-sm md:text-base font-bold tracking-wider hover:text-white transition">
            <a href="{{ route('home') }}">www.toonburger.com</a>
        </div>
    </header>

    <!-- Main Content Stage -->
    <main class="relative z-10 w-full max-w-7xl mx-auto px-6 sm:px-10 py-4 sm:py-8 flex-1 flex flex-col lg:flex-row items-center lg:items-end justify-between gap-8 lg:gap-4">
        
        <!-- Left: Ghost Dog Character with Interactive "GO TO HOME" Speech Bubble -->
        <div class="relative w-full max-w-md lg:max-w-[500px] flex flex-col items-center lg:items-start anim-ghost pt-4 lg:pt-0">
            
            <div class="relative inline-block">
                
                <!-- The Ghost Dog Illustration -->
                <img src="{{ asset('images/ghost-dog-transparent.png') }}" 
                     alt="Ghost Dog 404" 
                     class="w-[280px] sm:w-[350px] md:w-[410px] lg:w-[460px] h-auto object-contain select-none drop-shadow-[0_12px_24px_rgba(45,41,74,0.3)]">

                <!-- Interactive "GO TO HOME" Speech Bubble emerging from dog snout -->
                <!-- Desktop & Tablet Position -->
                <div class="absolute -right-6 sm:-right-12 md:-right-16 top-[28%] sm:top-[30%] z-30 anim-bubble">
                    <a href="{{ route('home') }}" 
                       class="group relative inline-flex items-center justify-center px-5 sm:px-7 py-2.5 sm:py-3.5 bg-white text-[#2d294a] font-black text-xs sm:text-sm md:text-base tracking-wider rounded-[30px] border-[3px] border-[#363152] shadow-[4px_4px_0px_#363152] hover:bg-[#b2d56d] hover:text-[#2d294a] hover:shadow-[6px_6px_0px_#363152] hover:-translate-y-1 active:translate-y-0 transition-all duration-200 uppercase cursor-pointer select-none">
                        
                        <span>GO TO HOME</span>

                        <!-- Speech bubble pointer pointing left towards dog's snout -->
                        <span class="absolute -left-3.5 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[10px] border-y-transparent border-r-[14px] border-r-[#363152]"></span>
                        <span class="absolute -left-2.5 top-1/2 -translate-y-1/2 w-0 h-0 border-y-[8px] border-y-transparent border-r-[11px] border-r-white group-hover:border-r-[#b2d56d] transition-colors"></span>
                    </a>
                </div>

            </div>

        </div>

        <!-- Right: Bold 404 Title & Organic Green Card -->
        <div class="w-full max-w-xl lg:max-w-2xl flex flex-col items-center lg:items-start text-center lg:text-left mb-6 lg:mb-12">
            
            <!-- Giant 404 Numbers with Solid Drop Shadow matching photo -->
            <div class="select-none mb-2 sm:mb-4">
                <h1 class="font-comic-num text-[110px] sm:text-[160px] md:text-[200px] lg:text-[230px] font-black text-[#aed581] leading-[0.85] tracking-tight"
                    style="text-shadow: 6px 6px 0px #45405e, 10px 10px 0px rgba(0,0,0,0.18);">
                    404
                </h1>
            </div>

            <!-- Green Organic Blob Card matching photo -->
            <div class="w-full bg-[#aed581] text-[#2d294a] rounded-[36px] sm:rounded-[44px] p-6 sm:p-9 md:p-10 shadow-[8px_8px_0px_#45405e] border-2 border-[#96bf68] relative">
                
                <!-- Heading matching photo -->
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-[#2d294a] tracking-tight uppercase m-0 leading-tight">
                    PAGE NOT FOUND
                </h2>

                <!-- Description matching photo text -->
                <p class="text-sm sm:text-base md:text-[17px] text-[#343050] font-semibold leading-relaxed mt-3 mb-1">
                    We're sorry, the page you're looking for doesn't exist.
                </p>
                <p class="text-xs sm:text-sm text-[#48436c] font-medium leading-relaxed">
                    If you think something's not working, 
                    <a href="{{ route('whatsapp') }}" target="_blank" rel="noopener noreferrer" class="underline underline-offset-2 font-bold text-[#2d294a] hover:text-black transition">
                        report an issue
                    </a>.
                </p>

                <!-- Indonesian Friendly Helper -->
                <p class="text-xs sm:text-xs text-[#524d77] italic mt-3 pt-3 border-t border-[#9ec772]">
                    (Halaman yang Anda tuju tidak ditemukan atau tautan telah berpindah alamat. Silakan kembali ke menu utama.)
                </p>

                <!-- Navigation Quick Actions -->
                <div class="mt-5 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-[#2d294a] text-white hover:bg-black font-bold text-xs sm:text-sm transition shadow-sm">
                        &larr; Beranda
                    </a>
                    <a href="{{ route('menu') }}" 
                       class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-white text-[#2d294a] hover:bg-gray-100 font-bold text-xs sm:text-sm transition shadow-sm border border-[#2d294a]/20">
                        Lihat Menu
                    </a>
                    <a href="{{ route('whatsapp') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full bg-transparent hover:bg-black/5 text-[#2d294a] font-bold text-xs sm:text-sm transition">
                        Bantuan WhatsApp &rarr;
                    </a>
                </div>

            </div>

        </div>

    </main>

    <!-- Bottom Margin / Footer Accent -->
    <footer class="relative z-10 w-full py-3 px-6 text-center text-xs text-white/50 select-none">
        &copy; {{ date('Y') }} Toon Burger. All Rights Reserved.
    </footer>

</body>
</html>

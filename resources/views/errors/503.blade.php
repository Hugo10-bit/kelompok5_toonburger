<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Matrix Maintenance | Toon Burger</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #070707;
            color: #ffffff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .font-matrix-title {
            font-family: 'Oswald', 'Impact', sans-serif;
            letter-spacing: 0.04em;
        }

        @keyframes pillPulseRed {
            0%, 100% { box-shadow: 0 0 20px rgba(239, 68, 68, 0.7), inset 0 2px 4px rgba(255, 255, 255, 0.4); }
            50% { box-shadow: 0 0 35px rgba(239, 68, 68, 1), inset 0 2px 6px rgba(255, 255, 255, 0.6); }
        }

        @keyframes pillPulseBlue {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.7), inset 0 2px 4px rgba(255, 255, 255, 0.4); }
            50% { box-shadow: 0 0 35px rgba(59, 130, 246, 1), inset 0 2px 6px rgba(255, 255, 255, 0.6); }
        }

        .anim-glow-red {
            animation: pillPulseRed 2.5s infinite ease-in-out;
        }

        .anim-glow-blue {
            animation: pillPulseBlue 2.5s infinite ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen w-full bg-[#070707] flex flex-col justify-between selection:bg-[#ED5B2D] selection:text-white">

    <!-- Top White Header Nav (matching reference image) -->
    <nav class="w-full bg-white text-black py-2.5 px-6 sm:px-12 flex items-center justify-between border-b border-gray-200 z-50">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <img src="{{ asset('images/logo.png') }}" alt="Toon Burger" class="w-7 h-7 sm:w-8 sm:h-8 object-contain group-hover:rotate-6 transition-transform">
            <span class="font-matrix-title font-bold text-sm sm:text-base tracking-widest text-[#27443E] uppercase">TOON BURGER</span>
        </a>
        <div class="flex items-center gap-5 sm:gap-8 text-[11px] sm:text-xs font-bold tracking-widest text-gray-800 uppercase">
            <a href="{{ route('home') }}" class="hover:text-[#DE3B28] transition">BERANDA</a>
            <a href="{{ route('menu') }}" class="hover:text-[#DE3B28] transition">MENU</a>
            <a href="{{ route('about') }}" class="hidden sm:inline-block hover:text-[#DE3B28] transition">TENTANG</a>
            <a href="{{ route('contact') }}" class="hidden sm:inline-block hover:text-[#DE3B28] transition">KONTAK</a>
            <a href="{{ route('whatsapp') }}" target="_blank" class="text-[#25D366] hover:text-[#1eb355] transition">WHATSAPP</a>
        </div>
    </nav>

    <!-- Main Matrix Presentation -->
    <main class="w-full flex-1 flex flex-col items-center justify-center pt-8 sm:pt-10 pb-6 px-4">
        
        <!-- Header Text Section -->
        <div class="max-w-4xl w-full text-center mb-4 sm:mb-6">
            <h1 class="font-matrix-title text-3xl sm:text-5xl md:text-6xl font-black text-[#ED5B2D] uppercase tracking-wide leading-tight drop-shadow-[0_2px_10px_rgba(237,91,45,0.3)]">
                THE MATRIX IS CURRENTLY UNDER SYSTEM MAINTENANCE.
            </h1>
            
            <div class="mt-3 sm:mt-4 space-y-1 text-xs sm:text-sm md:text-[15px] font-bold text-gray-300 uppercase tracking-wider font-mono leading-relaxed px-2">
                <p>YOU TAKE THE BLUE PILL, YOU RETURN TO OUR HOMEPAGE AND WAIT WHILE THE GRILL REBOOTS.</p>
                <p class="text-gray-400">YOU TAKE THE RED PILL, YOU CONTACT OUR KITCHEN CREW DIRECTLY VIA WHATSAPP TO SECURE YOUR ORDER.</p>
            </div>

            <p class="text-[11px] sm:text-xs text-gray-500 italic mt-2">
                (Dapur dan sistem sedang dalam pemeliharaan rutin. Pilih pil merah untuk pesan via WhatsApp atau pil biru untuk kembali ke beranda.)
            </p>
        </div>

        <!-- Center Morpheus Stage with Clickable Glowing Pills -->
        <div class="relative w-full max-w-4xl mx-auto flex flex-col items-center justify-center">
            
            <!-- Morpheus 503 Image Base -->
            <div class="relative w-full overflow-hidden rounded-xl shadow-[0_20px_50px_rgba(0,0,0,0.9)]">
                <img src="{{ asset('images/morpheus-503.png') }}" 
                     alt="Morpheus 503 - Choose The Red Pill or The Blue Pill" 
                     class="w-full h-auto object-contain select-none pointer-events-none block">

                <!-- Interactive Overlays on Morpheus Hands -->
                <!-- Left Hand: RED PILL (WHATSAPP ORDER) -->
                <a href="{{ route('whatsapp') }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   title="Pilih Pil Merah: Pesan Manual via WhatsApp"
                   class="absolute left-[27%] sm:left-[28%] md:left-[29%] top-[65%] sm:top-[67%] -translate-x-1/2 -translate-y-1/2 w-[34%] sm:w-[26%] md:w-[22%] h-[18%] sm:h-[16%] rounded-full cursor-pointer z-20 group flex items-center justify-center">
                    <span class="sr-only">Ambil Pil Merah - WhatsApp</span>
                    <!-- Glowing Indicator Ring on hover -->
                    <span class="absolute inset-0 rounded-full border-2 border-red-400/80 group-hover:border-white anim-glow-red transition-all duration-300"></span>
                    <span class="relative text-[10px] sm:text-xs md:text-sm font-black uppercase tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)] opacity-95 group-hover:scale-110 transition-transform">
                        WHATSAPP
                    </span>
                </a>

                <!-- Right Hand: BLUE PILL (HOMEPAGE) -->
                <a href="{{ route('home') }}" 
                   title="Pilih Pil Biru: Kembali ke Beranda"
                   class="absolute left-[64%] sm:left-[64%] md:left-[64%] top-[65%] sm:top-[67%] -translate-x-1/2 -translate-y-1/2 w-[34%] sm:w-[26%] md:w-[22%] h-[18%] sm:h-[16%] rounded-full cursor-pointer z-20 group flex items-center justify-center">
                    <span class="sr-only">Ambil Pil Biru - Beranda</span>
                    <!-- Glowing Indicator Ring on hover -->
                    <span class="absolute inset-0 rounded-full border-2 border-blue-400/80 group-hover:border-white anim-glow-blue transition-all duration-300"></span>
                    <span class="relative text-[10px] sm:text-xs md:text-sm font-black uppercase tracking-wider text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.9)] opacity-95 group-hover:scale-110 transition-transform">
                        HOMEPAGE
                    </span>
                </a>
            </div>

            <!-- Mobile & Tablet Accessible Action Buttons directly under Morpheus -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 sm:gap-6 z-30">
                <!-- Red Pill Button -->
                <a href="{{ route('whatsapp') }}" 
                   target="_blank"
                   rel="noopener noreferrer"
                   class="group inline-flex items-center gap-2 px-6 sm:px-8 py-3 rounded-full bg-gradient-to-r from-[#b71c1c] via-[#f44336] to-[#d32f2f] text-white font-black text-xs sm:text-sm tracking-wider uppercase border border-red-400 shadow-[0_0_20px_rgba(244,67,54,0.6)] hover:shadow-[0_0_35px_rgba(244,67,54,1)] hover:scale-105 active:scale-95 transition-all">
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                    <span>Ambil Pil Merah (WhatsApp)</span>
                </a>

                <!-- Blue Pill Button -->
                <a href="{{ route('home') }}" 
                   class="group inline-flex items-center gap-2 px-6 sm:px-8 py-3 rounded-full bg-gradient-to-r from-[#0d47a1] via-[#2196f3] to-[#1976d2] text-white font-black text-xs sm:text-sm tracking-wider uppercase border border-blue-400 shadow-[0_0_20px_rgba(33,150,243,0.6)] hover:shadow-[0_0_35px_rgba(33,150,243,1)] hover:scale-105 active:scale-95 transition-all">
                    <span class="w-2.5 h-2.5 rounded-full bg-white animate-ping"></span>
                    <span>Ambil Pil Biru (Beranda)</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Bottom Footer Note -->
    <footer class="w-full py-4 text-center text-xs text-gray-500 font-mono tracking-wider border-t border-gray-900 bg-[#050505]">
        &copy; {{ date('Y') }} TOON BURGER • MATRIX ERROR PROTOCOL 503
    </footer>

</body>
</html>

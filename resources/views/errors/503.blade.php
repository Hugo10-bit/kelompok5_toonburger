<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Maintenance - Toon Burger</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #000000;
            color: #ffffff;
            font-family: 'Times New Roman', Times, Georgia, serif;
            overflow: hidden;
            user-select: none;
            -webkit-user-select: none;
        }

        .serif-num {
            font-family: 'Times New Roman', Times, Georgia, serif;
            font-weight: 700;
            line-height: 0.8;
            letter-spacing: -0.05em;
        }

        @keyframes floatSlow1 {
            0%, 100% { transform: translate(0, 0) rotate(-15deg); }
            50% { transform: translate(-12px, -16px) rotate(-18deg); }
        }
        @keyframes floatSlow2 {
            0%, 100% { transform: translate(0, 0) rotate(25deg); }
            50% { transform: translate(14px, -12px) rotate(22deg); }
        }
        @keyframes tunnelPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        .anim-float-1 { animation: floatSlow1 8s ease-in-out infinite; }
        .anim-float-2 { animation: floatSlow2 9.5s ease-in-out infinite; }
        .anim-tunnel { animation: tunnelPulse 6s ease-in-out infinite; }
    </style>
</head>
<body class="relative min-h-screen w-full bg-black flex items-center justify-center overflow-hidden m-0 p-0">

    <!-- Top Left Header Indicator matching reference -->
    <div class="fixed top-6 left-6 z-40 text-gray-400 text-sm sm:text-base font-sans tracking-wide flex items-center gap-2">
        <a href="{{ route('home') }}" class="text-white hover:text-gray-300 font-semibold tracking-wider uppercase transition">
            Toon Burger
        </a>
        <span class="text-gray-600">•</span>
        <span class="text-gray-400">503 Maintenance</span>
    </div>

    <!-- Background Canvas Container for Scattered 503 Numbers -->
    <div id="parallax-container" class="absolute inset-0 pointer-events-none overflow-hidden select-none transition-transform duration-100 ease-out">
        
        <!-- Scattered Large Numbers Across Canvas matching reference image -->
        <!-- Top Left Cluster -->
        <span class="serif-num absolute text-[160px] sm:text-[230px] text-white/20 -top-16 -left-16 rotate-[-18deg] anim-float-1">503</span>
        <span class="serif-num absolute text-[120px] sm:text-[180px] text-white/35 top-20 -left-10 rotate-[28deg]">503</span>
        <span class="serif-num absolute text-[140px] sm:text-[210px] text-white/15 top-64 -left-12 rotate-[-35deg] anim-float-2">503</span>
        <span class="serif-num absolute text-[100px] sm:text-[150px] text-white/25 bottom-8 -left-8 rotate-[55deg]">503</span>

        <!-- Bottom Left / Floor -->
        <span class="serif-num absolute text-[150px] sm:text-[220px] text-white/30 -bottom-16 left-1/4 rotate-[-15deg] anim-float-1">503</span>
        <span class="serif-num absolute text-[110px] sm:text-[160px] text-white/20 bottom-12 left-1/3 rotate-[45deg]">503</span>

        <!-- Top Right Cluster -->
        <span class="serif-num absolute text-[180px] sm:text-[260px] text-white/25 -top-20 -right-16 rotate-[24deg] anim-float-2">503</span>
        <span class="serif-num absolute text-[130px] sm:text-[190px] text-white/35 top-28 right-4 rotate-[-22deg]">503</span>
        <span class="serif-num absolute text-[140px] sm:text-[200px] text-white/15 top-72 right-[-20px] rotate-[48deg] anim-float-1">503</span>

        <!-- Bottom Right Cluster -->
        <span class="serif-num absolute text-[150px] sm:text-[220px] text-white/30 bottom-16 -right-10 rotate-[-38deg]">503</span>
        <span class="serif-num absolute text-[170px] sm:text-[240px] text-white/20 -bottom-16 right-1/4 rotate-[12deg] anim-float-2">503</span>

        <!-- Top Center Scatter -->
        <span class="serif-num absolute text-[110px] sm:text-[160px] text-white/20 -top-8 left-1/2 -translate-x-1/2 rotate-[-8deg]">503</span>
        <span class="serif-num absolute text-[90px] sm:text-[130px] text-white/10 top-12 left-[38%] rotate-[18deg]">503</span>

        <!-- THE CENTRAL RABBIT HOLE / TUNNEL OF 503s -->
        <div class="absolute inset-0 flex items-center justify-center anim-tunnel">
            <span class="serif-num absolute text-[180px] sm:text-[280px] md:text-[340px] text-white/80 transform -translate-x-12 -translate-y-16 rotate-[-12deg]">503</span>
            <span class="serif-num absolute text-[160px] sm:text-[250px] md:text-[300px] text-white/75 transform -translate-x-6 -translate-y-12 rotate-[-8deg]">503</span>
            <span class="serif-num absolute text-[140px] sm:text-[220px] md:text-[260px] text-white/70 transform translate-x-0 -translate-y-8 rotate-[-4deg]">503</span>
            <span class="serif-num absolute text-[120px] sm:text-[190px] md:text-[225px] text-white/60 transform translate-x-5 -translate-y-4 rotate-[0deg]">503</span>
            <span class="serif-num absolute text-[100px] sm:text-[160px] md:text-[190px] text-white/50 transform translate-x-9 -translate-y-1 rotate-[4deg]">503</span>
            <span class="serif-num absolute text-[85px] sm:text-[135px] md:text-[160px] text-white/40 transform translate-x-12 translate-y-2 rotate-[8deg]">503</span>
            <span class="serif-num absolute text-[70px] sm:text-[110px] md:text-[130px] text-white/35 transform translate-x-14 translate-y-5 rotate-[12deg]">503</span>
            <span class="serif-num absolute text-[55px] sm:text-[90px] md:text-[105px] text-white/30 transform translate-x-16 translate-y-7 rotate-[16deg]">503</span>
            <span class="serif-num absolute text-[42px] sm:text-[70px] md:text-[82px] text-white/25 transform translate-x-17 translate-y-9 rotate-[20deg]">503</span>
            <span class="serif-num absolute text-[30px] sm:text-[50px] md:text-[60px] text-white/20 transform translate-x-18 translate-y-11 rotate-[24deg]">503</span>
            <span class="serif-num absolute text-[20px] sm:text-[35px] md:text-[42px] text-white/15 transform translate-x-19 translate-y-12 rotate-[28deg]">503</span>
            <span class="serif-num absolute text-[14px] sm:text-[22px] md:text-[28px] text-white/10 transform translate-x-20 translate-y-13 rotate-[32deg]">503</span>
        </div>

    </div>

    <!-- Crisp Minimalist White Card matching reference photo -->
    <div class="relative z-30 max-w-[420px] sm:max-w-[450px] w-full mx-4 bg-white text-black p-7 sm:p-9 shadow-[0_25px_50px_rgba(0,0,0,0.6)] rounded-none sm:rounded-xs border border-gray-100">
        
        <!-- Exact Typography & Phrasing matching the uploaded image -->
        <p class="text-[14px] sm:text-[15px] leading-relaxed font-serif text-gray-900 m-0">
            Dapur kami sedang dalam perawatan rutin. While we polish the grill, please go outside and enjoy the sunshine.
        </p>

        <p class="text-[12px] sm:text-[13px] text-gray-500 leading-relaxed font-serif mt-3 italic">
            (Sistem Toon Burger sedang diperbarui untuk pelayanan yang lebih prima. Kami akan segera kembali melayani pesanan Anda.)
        </p>

        <p class="text-[13px] sm:text-[14px] leading-relaxed font-serif text-gray-800 mt-5 pt-3 border-t border-gray-200">
            Butuh pesanan mendesak atau pertanyaan? Hubungi kami di 
            <a href="mailto:Toonburger@gmail.com" class="underline underline-offset-2 hover:text-[#DE3B28] transition font-sans font-medium text-xs sm:text-sm">
                Toonburger@gmail.com
            </a>
        </p>

        <!-- Action Links: Home, Reload, WhatsApp -->
        <div class="mt-6 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3 text-xs font-sans">
            <button type="button" onclick="window.location.reload()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-black text-white hover:bg-[#27443E] transition font-semibold cursor-pointer">
                &#x21bb; Muat Ulang
            </button>
            
            <a href="{{ route('home') }}" class="px-4 py-2 border border-gray-300 hover:border-black text-gray-800 hover:text-black transition font-medium">
                Beranda
            </a>

            <a href="{{ route('whatsapp') }}" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-[#25D366] transition inline-flex items-center gap-1 font-medium">
                WhatsApp &rarr;
            </a>
        </div>

    </div>

    <!-- Mouse Parallax Script -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const x = (e.clientX / window.innerWidth - 0.5) * 22;
            const y = (e.clientY / window.innerHeight - 0.5) * 22;
            const container = document.getElementById('parallax-container');
            if (container) {
                container.style.transform = `translate3d(${x * 0.8}px, ${y * 0.8}px, 0)`;
            }
        }, { passive: true });
    </script>

</body>
</html>

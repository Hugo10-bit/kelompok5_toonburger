<img src="{{ asset('images/toonburger-logo-white.png') }}"
     alt="Toon Burger"
     {{ $attributes->merge(['class' => 'h-16 w-auto object-contain drop-shadow-md']) }}
     onerror="this.onerror=null; this.src='{{ asset('images/toon-head.png') }}';">

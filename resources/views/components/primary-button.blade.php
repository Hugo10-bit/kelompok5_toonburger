<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-3 min-h-[44px] bg-[#466967] hover:bg-[#344E4C] border border-transparent rounded-xl font-bold text-xs sm:text-sm text-white tracking-wide shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-[#466967] focus:ring-offset-2 transition active:scale-98 cursor-pointer']) }}>
    {{ $slot }}
</button>

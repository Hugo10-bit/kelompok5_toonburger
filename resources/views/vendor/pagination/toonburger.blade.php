@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2 sm:gap-2.5 pt-6 sm:pt-8 select-none">
        {{-- Previous Page Link (Only shown if on page 2 or later, or keep hidden/shown according to mockup) --}}
        @if ($paginator->onFirstPage())
            {{-- Optional previous arrow or keep as in mockup where first button is page 1 --}}
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white text-[#374151] hover:text-[#111827] font-semibold flex items-center justify-center text-sm border border-gray-200/90 shadow-2xs hover:border-gray-300 hover:shadow-xs transition cursor-pointer">
                &larr;
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="w-8 h-10 sm:w-9 sm:h-11 text-gray-400 font-bold flex items-center justify-center text-sm tracking-widest">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-[#3D5A53] text-white font-black flex items-center justify-center text-sm shadow-xs border border-[#3D5A53]">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white text-[#374151] hover:text-[#111827] font-semibold flex items-center justify-center text-sm border border-gray-200/90 shadow-2xs hover:border-gray-300 hover:shadow-xs transition cursor-pointer">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-white text-[#374151] hover:text-[#111827] font-bold flex items-center justify-center text-sm border border-gray-200/90 shadow-2xs hover:border-gray-300 hover:shadow-xs transition cursor-pointer">
                &rarr;
            </a>
        @endif
    </nav>
@endif


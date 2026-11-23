@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();

        if ($lastPage <= 5) {
            $pageItems = range(1, $lastPage);
        } elseif ($currentPage <= 3) {
            $pageItems = [1, 2, 3, 4, '...', $lastPage];
        } elseif ($currentPage >= $lastPage - 2) {
            $pageItems = [1, '...', $lastPage - 3, $lastPage - 2, $lastPage - 1, $lastPage];
        } else {
            $pageItems = [1, '...', $currentPage - 1, $currentPage, $currentPage + 1, '...', $lastPage];
        }
    @endphp
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 pt-8 sm:pt-10 select-none">
        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}"
               rel="prev"
               aria-label="Halaman Sebelumnya"
               @if(!empty($scrollTarget)) data-scroll-target="{{ $scrollTarget }}" @endif
               class="w-10 h-10 sm:w-11 sm:h-11 rounded-[8px] bg-white text-[#6B7280] hover:text-[#1F2937] hover:border-[#3B5550]/60 font-medium flex items-center justify-center text-sm border border-[#D4D6D8] shadow-2xs transition cursor-pointer active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
        @endif

        {{-- Compact Window Page Items --}}
        @foreach ($pageItems as $item)
            @if ($item === '...')
                <span aria-hidden="true" class="px-1 sm:px-2 h-10 sm:h-11 text-[#6B7280] font-medium flex items-center justify-center text-sm tracking-widest">
                    &hellip;
                </span>
            @elseif ((int) $item === $currentPage)
                <span aria-current="page"
                      class="w-10 h-10 sm:w-11 sm:h-11 rounded-[8px] bg-[#3B5550] text-white font-semibold flex items-center justify-center text-sm border border-[#3B5550] shadow-2xs">
                    {{ $item }}
                </span>
            @else
                <a href="{{ $paginator->url($item) }}"
                   aria-label="Halaman {{ $item }}"
                   @if(!empty($scrollTarget)) data-scroll-target="{{ $scrollTarget }}" @endif
                   class="w-10 h-10 sm:w-11 sm:h-11 rounded-[8px] bg-white text-[#6B7280] hover:text-[#1F2937] hover:border-[#3B5550]/60 font-medium flex items-center justify-center text-sm border border-[#D4D6D8] shadow-2xs transition cursor-pointer active:scale-95">
                    {{ $item }}
                </a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               rel="next"
               aria-label="Halaman Berikutnya"
               @if(!empty($scrollTarget)) data-scroll-target="{{ $scrollTarget }}" @endif
               class="w-10 h-10 sm:w-11 sm:h-11 rounded-[8px] bg-white text-[#6B7280] hover:text-[#1F2937] hover:border-[#3B5550]/60 font-medium flex items-center justify-center text-sm border border-[#D4D6D8] shadow-2xs transition cursor-pointer active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        @endif
    </nav>
@endif

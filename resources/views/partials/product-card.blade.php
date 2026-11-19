<div class="bg-white rounded-[18px] sm:rounded-[24px] border-2 border-black shadow-[3px_4px_0px_rgba(0,0,0,0.5)] sm:shadow-[6px_6px_0px_rgba(0,0,0,0.5)] hover:shadow-[6px_6px_0px_rgba(39,68,62,0.85)] sm:hover:shadow-[8px_8px_0px_rgba(39,68,62,0.85)] p-2.5 sm:p-4 flex flex-col justify-between group hover:-translate-y-1 transition-[transform,box-shadow] duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] {{ $revealClass ?? 'toon-reveal' }}"
     @if(!empty($cardStyle)) style="{{ $cardStyle }}" @endif>
    <div onclick="openProductModal({{ $productId }})" class="cursor-pointer">
        <div class="w-full aspect-[1.35] sm:aspect-[1.45] rounded-xl sm:rounded-2xl overflow-hidden bg-gray-100"
             @if(!empty($bgColor)) style="background-color: {{ $bgColor }};" @endif>
            <img src="{{ \App\Services\ImageDataUriService::toAssetUrl($image, 'images/burger-bg.jpg') }}"
                 alt="{{ $name }}"
                 loading="lazy"
                 decoding="async"
                 width="600"
                 height="414"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-[520ms] ease-[cubic-bezier(0.22,1,0.36,1)] select-none">
        </div>

        <div class="pt-2 sm:pt-3 pb-0.5 sm:pb-1">
            <span class="text-[9.5px] sm:text-[11px] font-bold text-[#D97706] uppercase tracking-wide block truncate">
                {{ $badge }}
            </span>
            <h3 class="font-bold text-xs sm:text-base text-gray-900 mt-0.5 leading-snug line-clamp-1 sm:line-clamp-none group-hover:text-[#27443E] transition-colors duration-[420ms]">
                {{ $name }}
            </h3>
            <p class="text-[10.5px] sm:text-xs text-gray-500 line-clamp-2 leading-snug sm:leading-relaxed mt-0.5 sm:mt-1">
                {{ $description }}
            </p>
        </div>
    </div>

    <div class="pt-2 sm:pt-3 flex items-center justify-between gap-1.5 border-t border-gray-100 mt-2 sm:mt-3">
        <span class="font-black text-xs sm:text-base text-gray-900 whitespace-nowrap">
            Rp {{ number_format($price, 0, ',', '.') }}
        </span>
        @if(isset($storeSetting) && $storeSetting->isClosed())
            <button type="button"
                    onclick="promptStoreClosed()"
                    class="min-w-[50px] sm:min-w-[64px] min-h-[34px] sm:min-h-[44px] px-2.5 py-1.5 sm:px-3.5 sm:py-2 shrink-0 whitespace-nowrap bg-gray-200 text-gray-600 text-[11px] sm:text-[13px] font-semibold rounded-lg sm:rounded-[11px] flex items-center justify-center cursor-not-allowed">
                Tutup
            </button>
        @else
            <button type="button"
                    onclick="openProductModal({{ $productId }})"
                    data-i18n-app="card_order_btn"
                    class="min-w-[50px] sm:min-w-[64px] min-h-[34px] sm:min-h-[44px] px-2.5 py-1.5 sm:px-3.5 sm:py-2 shrink-0 whitespace-nowrap bg-[#27443E] hover:bg-[#1E3631] text-white text-[11px] sm:text-[13px] font-medium rounded-lg sm:rounded-[11px] flex items-center justify-center transition active:scale-95 shadow-xs cursor-pointer focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#27443E]">
                Pesan
            </button>
        @endif
    </div>
</div>

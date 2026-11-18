@if(isset($storeSetting) && $storeSetting->isClosed())
    <div class="bg-[#FFF2F2] border-2 border-[#DC2626] shadow-[3px_3px_0px_#991B1B] rounded-2xl px-4 py-3 sm:px-5 sm:py-3.5 flex items-start sm:items-center gap-3 text-left">
        <span class="w-8 h-8 rounded-full bg-red-100 border border-red-200 text-[#DC2626] flex items-center justify-center shrink-0 mt-0.5 sm:mt-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </span>
        <div class="min-w-0 flex-1 text-xs sm:text-sm leading-snug">
            <div class="font-extrabold text-[#991B1B] uppercase tracking-wide">
                Outlet Sedang Tutup ({{ $storeSetting->displayReason() }})
            </div>
            <p class="text-[11.5px] sm:text-xs text-[#7F1D1D] mt-0.5 leading-relaxed">
                Maaf, pemesanan dan checkout sementara dinonaktifkan. Jam operasional outlet: <strong>{{ $storeSetting->operating_hours ?? '17:00–22:00 WITA' }}</strong>.
            </p>
        </div>
    </div>
@endif

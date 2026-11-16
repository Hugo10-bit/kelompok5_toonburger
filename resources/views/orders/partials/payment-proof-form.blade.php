<form action="{{ route('orders.payment.proof', $order->order_number) }}"
      method="POST"
      enctype="multipart/form-data"
      data-proof-form="{{ $prefix }}"
      class="space-y-3 text-left">
    @csrf
    <input type="hidden" name="proof_data" id="{{ $prefix }}-proof-data" value="">

    <div>
        <label for="{{ $prefix }}-proof-input"
               class="block border-2 border-dashed border-gray-300 hover:border-[#385850] bg-gray-50/80 hover:bg-emerald-50/30 rounded-2xl p-3.5 text-center cursor-pointer transition">
            <input type="file"
                   id="{{ $prefix }}-proof-input"
                   name="proof_image"
                   accept="image/jpeg,image/png,image/webp"
                   class="sr-only">

            <div id="{{ $prefix }}-empty-state" class="space-y-1 py-1">
                <div class="w-9 h-9 rounded-full bg-emerald-100 text-[#385850] flex items-center justify-center mx-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                </div>
                <div class="text-xs font-bold text-gray-800">
                    Pilih / Upload Bukti Transfer
                </div>
                <div class="text-[11px] text-gray-500">
                    Screenshot m-Banking / E-Wallet (JPG, PNG, WEBP)
                </div>
            </div>

            <div id="{{ $prefix }}-preview-state" class="hidden space-y-2">
                <img id="{{ $prefix }}-preview-img"
                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1 1'%3E%3C/svg%3E"
                     alt="Preview Bukti Pembayaran"
                     class="max-h-36 w-auto mx-auto rounded-xl border border-gray-200 object-contain shadow-2xs">
                <div class="flex items-center justify-center gap-2 text-[11px]">
                    <span id="{{ $prefix }}-file-name" class="font-semibold text-gray-700 truncate max-w-[200px]"></span>
                    <button type="button"
                            data-proof-clear="{{ $prefix }}"
                            class="text-red-600 hover:underline font-semibold cursor-pointer">
                        Ganti / Hapus
                    </button>
                </div>
            </div>
        </label>
    </div>

    <div>
        <input type="text"
               name="payment_proof_note"
               maxlength="255"
               value="{{ old('payment_proof_note', $order->payment_proof_note) }}"
               placeholder="Nama pengirim / catatan transfer (opsional)"
               class="w-full bg-white border border-gray-300 rounded-xl px-3.5 py-2.5 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#385850] focus:ring-1 focus:ring-[#385850] transition">
    </div>

    <div id="{{ $prefix }}-client-error" class="hidden text-[11px] font-semibold text-red-600 bg-red-50 border border-red-200 rounded-xl px-3 py-2"></div>

    <button type="submit"
            data-proof-submit
            class="w-full bg-green-600 hover:bg-green-700 active:scale-[0.99] text-white font-semibold text-xs py-3.5 px-4 rounded-xl shadow-md transition flex items-center justify-center gap-2 cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span data-submit-text>{{ $submitLabel ?? 'Kirim Bukti Pembayaran' }}</span>
    </button>
</form>

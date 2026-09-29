@extends('layouts.admin')

@section('title', 'Manajemen Kupon & Promo - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <!-- Settings Navigation Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 select-none">
        <a href="{{ route('admin.coupons') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-[#385A56] text-white shadow-xs flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            <span>Voucher & Kupon Promo</span>
        </a>
        <a href="{{ route('admin.tables') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80 shadow-xs flex items-center gap-2 shrink-0 transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <span>Meja Restoran</span>
        </a>
        <a href="{{ route('admin.pos') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-white hover:bg-gray-50 text-gray-700 border border-gray-200/80 shadow-xs flex items-center gap-2 shrink-0 transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span>Buka Kasir / POS</span>
        </a>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Voucher & Kupon Promo</h1>
            <p class="text-xs text-gray-400 mt-1">Buat kode voucher diskon baru dan pantau penggunaan promo pelanggan Toon Burger.</p>
        </div>
        <button onclick="document.getElementById('add-coupon-modal').classList.remove('hidden')" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-xs transition flex items-center gap-2 select-none self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Buat Voucher Baru</span>
        </button>
    </div>

    <!-- Coupons Table -->
    <div class="border border-gray-200/80 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F0F4F3] text-gray-600 font-bold border-b border-gray-200/70 text-[11px] tracking-wide">
                    <tr>
                        <th class="py-3.5 px-4">Kode Kupon</th>
                        <th class="py-3.5 px-4">Tipe & Nilai Diskon</th>
                        <th class="py-3.5 px-4">Min. Belanja & Max Diskon</th>
                        <th class="py-3.5 px-4">Penggunaan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($coupons as $coup)
                        <tr class="hover:bg-gray-50/70 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-xs bg-gray-100 text-gray-800 px-3 py-1 rounded-full border border-gray-200">
                                    {{ $coup->code }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 font-bold text-gray-900">
                                @if($coup->discount_type === 'percentage')
                                    Diskon {{ intval($coup->discount_value) }}%
                                @else
                                    Potongan Rp {{ number_format($coup->discount_value, 0, ',', '.') }}
                                @endif
                            </td>

                            <td class="py-3.5 px-4 text-gray-600">
                                <div>Min. Belanja: <strong class="text-gray-900">Rp {{ number_format($coup->min_spend, 0, ',', '.') }}</strong></div>
                                <div>Max. Potongan: <strong class="text-gray-900">{{ $coup->max_discount ? 'Rp ' . number_format($coup->max_discount, 0, ',', '.') : 'Tanpa Batas' }}</strong></div>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-bold text-gray-900">{{ $coup->usage_count }}</span>
                                <span class="text-gray-400">/ {{ $coup->usage_limit ?: 'tak terbatas' }} kali</span>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $coup->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-rose-100 text-rose-800 border border-rose-200' }}">
                                    {{ $coup->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-right">
                                <form action="{{ route('admin.coupons.toggle', $coup->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-gray-100 hover:bg-gray-200 font-bold px-3.5 py-1.5 rounded-full transition text-xs text-gray-700 border border-gray-300">
                                        {{ $coup->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-400">
                                Belum ada kupon diskon yang dibuat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ADD COUPON MODAL -->
<div id="add-coupon-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-[2px] hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-8 shadow-2xl space-y-4 border border-gray-100 animate-modal-pop">
        <div class="pb-1">
            <h3 class="font-extrabold text-2xl text-gray-900 tracking-tight">Buat Kupon Promo Baru</h3>
            <p class="text-xs text-gray-400 mt-1">Tambahkan kode voucher untuk diskon pesanan.</p>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-3.5 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Kode Voucher</label>
                <input type="text" name="code" required placeholder="Contoh: TOONDEAL20" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 uppercase font-bold focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Tipe Diskon</label>
                    <select name="discount_type" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-bold focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rp)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Nilai Diskon</label>
                    <input type="number" name="discount_value" required placeholder="20" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-bold focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3.5">
                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Min. Belanja (Rp)</label>
                    <input type="number" name="min_spend" placeholder="50000" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1.5">Max Diskon (Rp)</label>
                    <input type="number" name="max_discount" placeholder="25000" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Batas Pemakaian (Opsional)</label>
                <input type="number" name="usage_limit" placeholder="100" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>

            <div class="pt-2 space-y-3 text-center">
                <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-2.5 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                    Simpan Kupon
                </button>
                <button type="button" onclick="document.getElementById('add-coupon-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 font-semibold text-xs transition inline-block">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

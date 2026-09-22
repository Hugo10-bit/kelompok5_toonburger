@extends('layouts.admin')

@section('title', 'Manajemen Kupon & Promo - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Voucher & Kupon Promo</h1>
            <p class="text-xs text-gray-500 mt-1">Buat kode voucher diskon baru dan pantau penggunaan promo pelanggan Toon Burger.</p>
        </div>
        <button onclick="document.getElementById('add-coupon-modal').classList.remove('hidden')" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold text-xs px-5 py-2.5 rounded-full shadow-sm transition flex items-center gap-2 self-start sm:self-center">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>+ Buat Voucher Baru</span>
        </button>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-toon-cream/50 text-gray-500 font-bold border-b border-[#E6DEC8] uppercase text-[10px] tracking-wider">
                    <tr>
                        <th class="p-4">Kode Kupon</th>
                        <th class="p-4">Tipe & Nilai Diskon</th>
                        <th class="p-4">Min. Belanja & Max Diskon</th>
                        <th class="p-4">Penggunaan</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($coupons as $coup)
                        <tr class="hover:bg-toon-cream/20 transition">
                            <td class="p-4">
                                <span class="font-mono-code font-black text-xs bg-toon-cream text-toon-granite px-3 py-1 rounded-full border border-toon-granite/20">
                                    {{ $coup->code }}
                                </span>
                            </td>

                            <td class="p-4 font-bold text-gray-900">
                                @if($coup->discount_type === 'percentage')
                                    Diskon {{ intval($coup->discount_value) }}%
                                @else
                                    Potongan Rp {{ number_format($coup->discount_value, 0, ',', '.') }}
                                @endif
                            </td>

                            <td class="p-4 text-gray-600">
                                <div>Min. Belanja: <strong class="text-gray-900 font-mono-code">Rp {{ number_format($coup->min_spend, 0, ',', '.') }}</strong></div>
                                <div>Max. Potongan: <strong class="text-gray-900 font-mono-code">{{ $coup->max_discount ? 'Rp ' . number_format($coup->max_discount, 0, ',', '.') : 'Tanpa Batas' }}</strong></div>
                            </td>

                            <td class="p-4">
                                <span class="font-black text-gray-900 font-mono-code">{{ $coup->usage_count }}</span>
                                <span class="text-gray-400">/ {{ $coup->usage_limit ?: 'tak terbatas' }} kali</span>
                            </td>

                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase {{ $coup->is_active ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-red-100 text-toon-rust border border-red-200' }}">
                                    {{ $coup->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>

                            <td class="p-4 text-right">
                                <form action="{{ route('admin.coupons.toggle', $coup->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-toon-cream hover:bg-toon-wheat font-bold px-3.5 py-1.5 rounded-full transition text-xs text-toon-granite border border-toon-granite/20">
                                        {{ $coup->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400">
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
<div id="add-coupon-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs hidden">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-7 shadow-2xl space-y-4 border border-[#E6DEC8]">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100">
            <div>
                <h3 class="font-extrabold text-base text-gray-900">Buat Kupon Promo Baru</h3>
                <p class="text-xs text-gray-400">Tambahkan kode voucher untuk diskon pesanan.</p>
            </div>
            <button onclick="document.getElementById('add-coupon-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-700 text-lg font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-3 text-xs">
            @csrf

            <div>
                <label class="block font-bold text-gray-700 mb-1">Kode Voucher:</label>
                <input type="text" name="code" required placeholder="Contoh: TOONDEAL20" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-mono-code uppercase font-bold focus:outline-none focus:border-toon-granite">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Tipe Diskon:</label>
                    <select name="discount_type" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-bold focus:outline-none">
                        <option value="percentage">Persentase (%)</option>
                        <option value="fixed">Nominal Tetap (Rp)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Nilai Diskon:</label>
                    <input type="number" name="discount_value" required placeholder="20" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-mono-code font-bold focus:outline-none focus:border-toon-granite">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-gray-700 mb-1">Min. Belanja (Rp):</label>
                    <input type="number" name="min_spend" placeholder="50000" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-mono-code focus:outline-none">
                </div>

                <div>
                    <label class="block font-bold text-gray-700 mb-1">Max Diskon (Rp):</label>
                    <input type="number" name="max_discount" placeholder="25000" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-mono-code focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1">Batas Pemakaian (Opsional):</label>
                <input type="number" name="usage_limit" placeholder="100" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-2.5 font-mono-code focus:outline-none">
            </div>

            <div class="pt-3 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('add-coupon-modal').classList.add('hidden')" class="px-4 py-2.5 rounded-full font-bold text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-2.5 px-6 rounded-full transition text-xs">
                    Simpan Kupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

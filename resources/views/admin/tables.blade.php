@extends('layouts.admin')

@section('title', 'Manajemen Meja Restoran - Toon Burger Admin')

@section('admin_content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Settings Navigation Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1">
        <a href="{{ route('admin.coupons') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-white hover:bg-gray-100 text-gray-700 border border-[#E6DEC8] shadow-xs flex items-center gap-2 shrink-0 transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
            <span>Voucher & Kupon Promo</span>
        </a>
        <a href="{{ route('admin.tables') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-[#3D5A58] text-white shadow-xs flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
            <span>Meja Restoran</span>
        </a>
        <a href="{{ route('admin.pos') }}" class="px-5 py-2.5 rounded-full text-xs font-bold bg-white hover:bg-gray-100 text-gray-700 border border-[#E6DEC8] shadow-xs flex items-center gap-2 shrink-0 transition">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <span>Buka Kasir / POS</span>
        </a>
    </div>

    <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Manajemen Meja Restoran</h1>
            <p class="text-xs text-gray-500 mt-1">Pantau ketersediaan meja, status terisi (occupied), dan tautan QR pemesanan pelanggan Toon Burger.</p>
        </div>
    </div>

    <!-- Tables Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($tables as $table)
            <div class="bg-white rounded-3xl p-5 border-2 {{ $table->status === 'occupied' ? 'border-toon-rust bg-red-50/20' : ($table->status === 'reserved' ? 'border-amber-400 bg-amber-50/20' : 'border-toon-granite/40 bg-emerald-50/10') }} shadow-xs flex flex-col justify-between space-y-4 hover:shadow-md transition">
                
                <div>
                    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                        <h3 class="font-extrabold text-base text-gray-900">{{ $table->table_number }}</h3>
                        <span class="text-[10px] font-black uppercase px-2.5 py-0.5 rounded-full {{ $table->status === 'occupied' ? 'bg-red-100 text-toon-rust border border-red-200' : ($table->status === 'reserved' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-toon-cream text-toon-granite border border-toon-granite/20') }}">
                            {{ $table->status }}
                        </span>
                    </div>

                    <div class="py-3 text-xs text-gray-600 space-y-1">
                        <div>Kapasitas: <strong class="text-gray-900">{{ $table->capacity }} Orang</strong></div>
                        <div>Pesanan Aktif: <strong class="text-toon-granite font-mono-code">{{ $table->orders_count }} Transaksi</strong></div>
                    </div>

                    <!-- QR Link -->
                    <div class="bg-toon-cream/40 p-2.5 rounded-2xl text-center border border-[#EFE5D0]">
                        <a href="{{ route('menu', ['table' => $table->table_number]) }}" target="_blank" class="text-[11px] font-bold text-toon-granite hover:underline inline-flex items-center gap-1">
                            <span>Buka Menu Meja Ini</span>
                            <span>&rarr;</span>
                        </a>
                    </div>
                </div>

                <!-- Update Status Form -->
                <form action="{{ route('admin.tables.status', $table->id) }}" method="POST" class="pt-2 border-t border-gray-100">
                    @csrf
                    <div class="flex items-center gap-1.5 text-[11px]">
                        <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-full p-2 font-bold text-gray-800 focus:outline-none focus:border-toon-granite">
                            <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Available (Kosong)</option>
                            <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Occupied (Terisi)</option>
                            <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reserved (Dipesan)</option>
                        </select>
                        <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold px-3.5 py-2 rounded-full transition shadow-2xs">
                            Ubah
                        </button>
                    </div>
                </form>

            </div>
        @endforeach
    </div>

</div>
@endsection

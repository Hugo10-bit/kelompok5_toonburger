@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.admin')

@section('title', 'Profil Admin - Toon Burger Admin')

@section('admin_content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="bg-white p-6 rounded-3xl border border-[#E6DEC8] shadow-xs">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Profil Admin</h1>
        <p class="text-xs text-gray-500 mt-1">Kelola informasi data profil, alamat email, dan keamanan akun admin Toon Burger.</p>
    </div>

    <!-- Main Profile Card (SESUAI MOCKUP FOTO) -->
    <div class="bg-white rounded-3xl border border-[#E6DEC8] shadow-xs p-6 sm:p-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: Avatar & Overview -->
            <div class="md:col-span-4 flex flex-col items-center text-center p-6 rounded-2xl bg-toon-cream/40 border border-[#EFE5D0] space-y-4">
                <div class="relative">
                    <div class="w-28 h-28 rounded-full bg-toon-wheat text-toon-granite font-extrabold text-3xl flex items-center justify-center shadow-md border-4 border-white tracking-wider">
                        TB
                    </div>
                    <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-emerald-500 border-2 border-white flex items-center justify-center text-white text-[10px]" title="Aktif Online">
                        ✓
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-black text-gray-900 leading-tight">{{ $user->name ?? 'Toon Burger' }}</h2>
                    <p class="text-xs font-semibold text-gray-400 mt-0.5">{{ $user->email ?? 'admin@toonburger.com' }}</p>
                    <div class="mt-2.5">
                        <span class="inline-block bg-toon-granite text-white text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-2xs">
                            Administrator
                        </span>
                    </div>
                </div>

                <div class="w-full pt-4 border-t border-gray-200/60 text-left text-xs space-y-2 text-gray-600">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">Role:</span>
                        <span class="font-bold text-gray-800 capitalize">{{ $user->role ?? 'Admin' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">Bergabung:</span>
                        <span class="font-bold text-gray-800 font-mono-code">{{ $user->created_at ? $user->created_at->format('d M Y') : '2024' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">Status:</span>
                        <span class="font-bold text-emerald-600">Terverifikasi</span>
                    </div>
                </div>
            </div>

            <!-- Right Column: Edit Profile Form -->
            <div class="md:col-span-8 space-y-6">
                <div>
                    <h3 class="font-extrabold text-base text-gray-900">Perbarui Kredensial Akun</h3>
                    <p class="text-xs text-gray-400">Pastikan informasi email dan password selalu terlindungi dengan baik.</p>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 text-xs">
                    @csrf

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nama Lengkap:</label>
                        <input type="text" name="name" value="{{ old('name', $user->name ?? 'Toon Burger') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
                        @error('name') <span class="text-toon-rust text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Alamat Email:</label>
                        <input type="email" name="email" value="{{ old('email', $user->email ?? 'admin@toonburger.com') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
                        @error('email') <span class="text-toon-rust text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-bold text-gray-700 mb-1">Nomor Telepon (Opsional):</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '08123456789') }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 font-medium focus:outline-none focus:border-toon-granite focus:bg-white transition">
                        @error('phone_number') <span class="text-toon-rust text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <div class="mb-3">
                            <h4 class="font-bold text-gray-800 text-xs">Ganti Kata Sandi (Opsional)</h4>
                            <p class="text-[11px] text-gray-400">Kosongkan jika Anda tidak bermaksud mengubah kata sandi.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Kata Sandi Baru:</label>
                                <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                                @error('password') <span class="text-toon-rust text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi:</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-3 focus:outline-none focus:border-toon-granite focus:bg-white transition">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex items-center justify-end">
                        <button type="submit" class="bg-toon-granite hover:bg-toon-granite-dark text-white font-bold py-3 px-8 rounded-full shadow-sm transition text-xs flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection

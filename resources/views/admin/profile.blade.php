@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.admin')

@section('title', 'Profil Admin - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-3xl border border-gray-200/80 shadow-xs p-6 sm:p-8 max-w-4xl mx-auto space-y-7">

    <!-- Header Section (Sesuai Mockup Foto Board 6) -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Profil Admin</h1>
        <p class="text-xs text-gray-400 mt-1">Kelola informasi akun dan kata sandi admin</p>
    </div>

    <!-- Avatar & Admin Identity Header -->
    <div class="flex items-center gap-4 pb-2">
        <div class="w-14 h-14 rounded-full bg-[#F59E0B] text-white font-black text-xl flex items-center justify-center shadow-xs shrink-0 select-none">
            TB
        </div>
        <div>
            <h2 class="text-lg font-black text-gray-900 leading-tight">{{ $user->name ?? 'Toon Burger' }}</h2>
            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email ?? 'toonburger@gmail.com' }}</p>
        </div>
    </div>

    <!-- Form 1: Informasi Profil -->
    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 text-xs">
        @csrf

        <div>
            <label class="block font-bold text-gray-700 mb-1.5">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name ?? 'Toon Burger') }}" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            @error('name') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? 'toonburger@gmail.com') }}" required class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                @error('email') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Nomor Telepon</label>
                <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '081345956487') }}" placeholder="Contoh: 081345956487" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                @error('phone_number') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-3 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                Simpan Perubahan
            </button>
        </div>
    </form>

    <hr class="border-gray-200/70 my-6">

    <!-- Form 2: Ubah Kata Sandi -->
    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 text-xs">
        @csrf
        <input type="hidden" name="name" value="{{ $user->name ?? 'Toon Burger' }}">
        <input type="hidden" name="email" value="{{ $user->email ?? 'toonburger@gmail.com' }}">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
                @error('password') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-bold text-gray-700 mb-1.5">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full bg-[#F4F5F7] border border-gray-200/80 rounded-xl p-3 font-medium focus:outline-none focus:border-[#385A56] focus:bg-white transition text-gray-800">
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" class="bg-[#385A56] hover:bg-[#2D4B47] active:scale-95 text-white font-bold py-3 px-6 rounded-full w-full shadow-xs transition text-xs select-none">
                Perbarui Password
            </button>
        </div>
    </form>

</div>
@endsection

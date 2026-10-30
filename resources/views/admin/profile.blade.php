@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.admin')

@section('title', 'Profil Admin - Toon Burger Admin')

@section('admin_content')
<div class="bg-white rounded-[28px] sm:rounded-[32px] border border-gray-200/80 shadow-xs p-6 sm:p-8 space-y-6">

    <div>
        <h1 class="text-2xl sm:text-[28px] font-bold text-[#333333] tracking-tight">Profil Admin</h1>
        <p class="text-xs sm:text-[13px] text-gray-500 mt-1">Kelola informasi akun dan profil admin</p>
    </div>

    <div class="flex items-center gap-4 pt-1 pb-2">
        <div class="w-16 h-16 rounded-full bg-[#F79E1B] text-white font-bold text-lg flex items-center justify-center relative shrink-0 select-none">
            <span>Tb</span>
            <span class="w-5 h-5 rounded-full bg-[#D1D5DB] border border-white flex items-center justify-center text-gray-600 absolute bottom-0 right-0 shadow-2xs">
                <svg class="w-2.5 h-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
            </span>
        </div>
        <div>
            <h2 class="text-xl font-normal text-gray-800 leading-tight">{{ $user->name ?: 'Toon Burger' }}</h2>
            <p class="text-xs text-gray-400 mt-0.5">{{ $user->email ?: 'Toonburger@gmail.com' }}</p>
        </div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 text-xs">
        @csrf

        <div>
            <label for="profile-username" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Username</label>
            <input type="text"
                   id="profile-username"
                   name="name"
                   value="{{ old('name', $user->name ?: 'Toon Burger') }}"
                   required
                   class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800">
            @error('name') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <label for="profile-email" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Email</label>
                <input type="email"
                       id="profile-email"
                       name="email"
                       value="{{ old('email', $user->email ?: 'Toonburger@gmail.com') }}"
                       required
                       class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800">
                @error('email') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="profile-phone" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Nomor telfon</label>
                <input type="text"
                       id="profile-phone"
                       name="phone_number"
                       value="{{ old('phone_number', $user->phone_number ?: '085780153872') }}"
                       class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800">
                @error('phone_number') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="profile-address" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Alamat</label>
            <input type="text"
                   id="profile-address"
                   name="address"
                   value="{{ old('address', $user->address ?: 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714') }}"
                   class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800">
            @error('address') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-1">
            <button type="submit" class="bg-[#415C58] hover:bg-[#344B48] active:scale-[0.99] text-white font-medium py-3 px-6 rounded-xl w-full min-h-[44px] shadow-2xs transition text-xs select-none cursor-pointer">
                Simpan
            </button>
        </div>
    </form>

    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4 pt-6 text-xs">
        @csrf
        <input type="hidden" name="name" value="{{ $user->name ?: 'Toon Burger' }}">
        <input type="hidden" name="email" value="{{ $user->email ?: 'Toonburger@gmail.com' }}">
        <input type="hidden" name="phone_number" value="{{ $user->phone_number ?: '085780153872' }}">
        <input type="hidden" name="address" value="{{ $user->address ?: 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714' }}">

        <div>
            <label for="profile-new-password" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Password baru</label>
            <input type="password"
                   id="profile-new-password"
                   name="password"
                   placeholder="Masukkan Password"
                   class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal placeholder-gray-400 focus:outline-none focus:border-[#415C58] transition text-gray-800">
            @error('password') <span class="text-[#DE3B28] text-[11px] font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="profile-confirm-password" class="block font-bold text-gray-800 mb-1.5 text-[11px]">Konfirmasi Password</label>
            <input type="password"
                   id="profile-confirm-password"
                   name="password_confirmation"
                   placeholder="Konfirmasi Password"
                   class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 min-h-[44px] text-xs font-normal placeholder-gray-400 focus:outline-none focus:border-[#415C58] transition text-gray-800">
        </div>

        <div class="pt-1">
            <button type="submit" class="bg-[#415C58] hover:bg-[#344B48] active:scale-[0.99] text-white font-medium py-3 px-6 rounded-xl w-full min-h-[44px] shadow-2xs transition text-xs select-none cursor-pointer">
                Simpan
            </button>
        </div>
    </form>

</div>
@endsection

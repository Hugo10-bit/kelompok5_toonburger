@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.app')

@section('title', 'Info Akun & Profil - Toon Burger')
@section('footer_bg', 'orders-dot-bg')

@section('content')
@php
    $rawInitials = substr(trim($user?->name ?: 'Tb'), 0, 2);
    $userInitials = ucfirst(strtolower($rawInitials));
@endphp
<div class="orders-dot-bg min-h-screen -mt-[88px] sm:-mt-[96px] pt-[112px] sm:pt-[128px] pb-14 sm:pb-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-medium text-gray-500 hover:text-[#27443E] transition mb-1.5">
            <span>&lsaquo;</span>
            <span>Kembali Ke Beranda</span>
        </a>

        <!-- Page Heading -->
        <div class="mb-6 sm:mb-7">
            <h1 class="font-brand text-2xl sm:text-3xl lg:text-[34px] text-[#35524D] uppercase tracking-wide leading-tight"
                style="font-family: 'BBH Hegarty', 'Luckiest Guy', cursive, sans-serif;">
                INFO AKUN &amp; PROFIL
            </h1>
            <p class="text-xs sm:text-[13px] text-gray-500 mt-1">
                Kelola data diri, alamat, dan keamanan akun Toon Burger kamu.
            </p>
        </div>

        <!-- CARD 1: DATA DIRI & AVATAR -->
        <div class="bg-white rounded-[22px] sm:rounded-[26px] border border-gray-300/80 shadow-[4px_5px_0px_rgba(0,0,0,0.18)] p-6 sm:p-9 lg:p-10">

            <div class="flex items-center gap-4 sm:gap-5 mb-7 sm:mb-8 min-w-0">
                <div class="relative shrink-0 select-none">
                    <button type="button"
                            onclick="document.getElementById('customer-profile-avatar-input').click()"
                            title="Ubah Foto Profil"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#F5A623] text-white font-semibold text-xl sm:text-2xl flex items-center justify-center relative overflow-hidden cursor-pointer group focus:outline-none ring-2 ring-gray-200">
                        @if(!empty($user?->avatar))
                            <img id="customer-profile-avatar-preview"
                                 src="{{ $user->avatar_url }}"
                                 data-initial-src="{{ $user->avatar_url }}"
                                 alt="Avatar"
                                 class="w-full h-full object-cover">
                            <span id="customer-profile-avatar-initials" class="hidden">{{ $userInitials }}</span>
                        @else
                            <img id="customer-profile-avatar-preview" src="" data-initial-src="" alt="Avatar" class="w-full h-full object-cover hidden">
                            <span id="customer-profile-avatar-initials">{{ $userInitials }}</span>
                        @endif
                        <span class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </span>
                    </button>
                    <button type="button"
                            onclick="document.getElementById('customer-profile-avatar-input').click()"
                            title="Ubah Foto Profil"
                            aria-label="Ubah Foto Profil"
                            class="w-6 h-6 rounded-full bg-[#EFEFEF] hover:bg-gray-200 border-2 border-white flex items-center justify-center text-gray-700 absolute bottom-0 right-0 shadow-xs cursor-pointer transition active:scale-95 focus:outline-none z-10">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                    </button>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-xl sm:text-[26px] font-bold text-[#262626] leading-tight break-words">{{ $user?->name }}</h2>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5 break-all">{{ $user?->email }}</p>
                    @error('avatar') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <form id="customer-profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6 text-sm">
                @csrf
                <input type="hidden" name="avatar_data" id="customer-profile-avatar-data" value="">
                <input type="file"
                       id="customer-profile-avatar-input"
                       name="avatar"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                       class="hidden"
                       onchange="handleCustomerPageAvatarChange(this)">

                <div>
                    <label for="customer-profile-name" class="block font-bold text-gray-800 mb-1.5 text-xs">Username</label>
                    <input type="text"
                           id="customer-profile-name"
                           name="name"
                           value="{{ old('name', $user?->name) }}"
                           required
                           class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                    @error('name') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-10">
                    <div>
                        <label for="customer-profile-email" class="block font-bold text-gray-800 mb-1.5 text-xs">Email</label>
                        <input type="email"
                               id="customer-profile-email"
                               name="email"
                               value="{{ old('email', $user?->email) }}"
                               required
                               class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                        @error('email') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="customer-profile-phone" class="block font-bold text-gray-800 mb-1.5 text-xs">Nomor telfon</label>
                        <input type="tel"
                               id="customer-profile-phone"
                               name="phone_number"
                               inputmode="numeric"
                               pattern="[0-9]+(-[0-9]+)*"
                               maxlength="15"
                               value="{{ old('phone_number', $user?->phone_number) }}"
                               placeholder="Masukkan nomor telepon"
                               class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                        @error('phone_number') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="customer-profile-address" class="block font-bold text-gray-800 mb-1.5 text-xs">Alamat</label>
                    <input type="text"
                           id="customer-profile-address"
                           name="address"
                           value="{{ old('address', $user?->address) }}"
                           placeholder="Masukkan alamat lengkap"
                           class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                    @error('address') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="button"
                            onclick="const f=document.getElementById('customer-profile-form'); if(f) f.reset(); const p=document.getElementById('customer-profile-avatar-preview'); const i=document.getElementById('customer-profile-avatar-initials'); const d=document.getElementById('customer-profile-avatar-data'); if(d) d.value=''; if(p){ const initSrc=p.getAttribute('data-initial-src'); if(initSrc){ p.src=initSrc; p.classList.remove('hidden'); if(i) i.classList.add('hidden'); } else { p.src=''; p.classList.add('hidden'); if(i) i.classList.remove('hidden'); } }"
                            class="min-w-[96px] sm:min-w-[110px] py-2 px-5 rounded-xl border border-gray-400/90 bg-white hover:bg-gray-50 active:scale-[0.99] text-gray-700 font-medium text-xs sm:text-[13px] transition select-none cursor-pointer">
                        Reset
                    </button>
                    <button type="submit"
                            class="min-w-[96px] sm:min-w-[110px] py-2 px-5 rounded-xl bg-[#385652] hover:bg-[#2B4440] active:scale-[0.99] text-white font-medium text-xs sm:text-[13px] shadow-2xs transition select-none cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- CARD 2: UBAH PASSWORD -->
        <div class="mt-6 sm:mt-7 bg-white rounded-[22px] sm:rounded-[26px] border border-gray-300/80 shadow-[4px_5px_0px_rgba(0,0,0,0.18)] p-6 sm:p-9 lg:p-10">
            <form id="customer-password-form" action="{{ route('profile.update') }}" method="POST" class="space-y-6 text-sm">
                @csrf
                <input type="hidden" name="name" value="{{ $user?->name }}">
                <input type="hidden" name="email" value="{{ $user?->email }}">
                <input type="hidden" name="phone_number" value="{{ $user?->phone_number }}">
                <input type="hidden" name="address" value="{{ $user?->address }}">

                <div>
                    <label for="customer-profile-new-password" class="block font-bold text-gray-800 mb-1.5 text-xs">Password baru</label>
                    <input type="password"
                           id="customer-profile-new-password"
                           name="password"
                           placeholder="Masukkan Password"
                           class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                    @error('password') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer-profile-confirm-password" class="block font-bold text-gray-800 mb-1.5 text-xs">Konfirmasi Password</label>
                    <input type="password"
                           id="customer-profile-confirm-password"
                           name="password_confirmation"
                           placeholder="Konfirmasi Password"
                           class="w-full border-0 border-b border-gray-300 focus:border-[#385652] bg-transparent px-1 py-2 text-xs sm:text-[13.5px] font-normal text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-0 transition">
                </div>

                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="reset"
                            class="min-w-[96px] sm:min-w-[110px] py-2 px-5 rounded-xl border border-gray-400/90 bg-white hover:bg-gray-50 active:scale-[0.99] text-gray-700 font-medium text-xs sm:text-[13px] transition select-none cursor-pointer">
                        Reset
                    </button>
                    <button type="submit"
                            class="min-w-[96px] sm:min-w-[110px] py-2 px-5 rounded-xl bg-[#385652] hover:bg-[#2B4440] active:scale-[0.99] text-white font-medium text-xs sm:text-[13px] shadow-2xs transition select-none cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal Konfirmasi Edit Profil -->
        <div id="customer-profile-confirm-modal"
             class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
            <div class="fixed inset-0 bg-[#1B2B28]/40 backdrop-blur-[2px] transition-opacity duration-200"
                 onclick="closeCustomerProfileConfirmModal()"></div>

            <div class="relative bg-[#FFFDF8] rounded-[28px] sm:rounded-[32px] shadow-2xl p-6 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-[#E5DEC9] mx-auto my-auto">
                <div class="w-20 h-20 sm:w-[104px] sm:h-[104px] rounded-full border-[5.5px] sm:border-[7.5px] border-[#3B6E64] flex items-center justify-center mx-auto mb-5 sm:mb-6 bg-[#FFFDF8] shrink-0 text-[#3B6E64]">
                    <svg id="customer-profile-modal-icon-profile" class="w-8 h-8 sm:w-11 sm:h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <svg id="customer-profile-modal-icon-password" class="w-8 h-8 sm:w-11 sm:h-11 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <svg id="customer-profile-modal-icon-avatar" class="w-8 h-8 sm:w-11 sm:h-11 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>

                <h3 id="customer-profile-confirm-title" class="text-xl sm:text-[26px] font-bold text-[#27443E] tracking-tight mb-2.5 sm:mb-3">
                    Konfirmasi Simpan Profil
                </h3>

                <p id="customer-profile-confirm-message" class="text-xs sm:text-sm text-[#637873] leading-relaxed mb-6 sm:mb-8 max-w-[340px] mx-auto">
                    Apakah Anda yakin ingin menyimpan perubahan pada profil ini?
                </p>

                <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
                    <button type="button"
                            onclick="closeCustomerProfileConfirmModal()"
                            class="min-w-[115px] sm:min-w-[140px] px-5 sm:px-6 py-2.5 sm:py-3 rounded-full border border-[#C9C1AA] text-[#35524B] text-xs sm:text-sm font-medium hover:bg-[#FAF7EE] active:scale-95 transition cursor-pointer">
                        Batalkan
                    </button>
                    <button type="button"
                            id="customer-profile-confirm-proceed-btn"
                            class="min-w-[115px] sm:min-w-[140px] px-5 sm:px-6 py-2.5 sm:py-3 rounded-full bg-[#3B6E64] hover:bg-[#315D54] text-white text-xs sm:text-sm font-medium shadow-md active:scale-95 transition cursor-pointer">
                        Ya, Simpan
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.app')

@section('title', 'Profil Saya - Toon Burger')
@section('footer_bg', 'retro-grid-bg')

@section('content')
@php
    $userInitials = strtoupper(substr($user?->name ?: 'TB', 0, 2));
@endphp
<div class="retro-grid-bg min-h-screen -mt-[88px] sm:-mt-[96px] pt-[112px] sm:pt-[124px] pb-12 sm:pb-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#FFFDF8] rounded-[24px] sm:rounded-[32px] border border-[#E5DEC9] shadow-[0_6px_24px_rgba(39,68,62,0.06)] p-5 sm:p-9 lg:p-10 space-y-5 sm:space-y-7">

            <div>
                <h1 class="text-xl sm:text-[30px] lg:text-[34px] font-bold text-[#27443E] tracking-tight leading-tight">Profil Saya</h1>
                <p class="text-xs sm:text-[15px] text-[#637873] mt-1.5">Kelola informasi akun dan profil Anda</p>
            </div>

            <div class="flex items-center gap-4 sm:gap-5 pt-1 pb-4 border-b border-[#ECE5D3] min-w-0">
                <div class="relative shrink-0 select-none">
                    <button type="button"
                            onclick="document.getElementById('customer-profile-avatar-input').click()"
                            title="Ubah Foto Profil"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#F5A623] text-white font-bold text-xl sm:text-2xl flex items-center justify-center relative overflow-hidden cursor-pointer group focus:outline-none ring-2 ring-[#ECE5D3]">
                        @if(!empty($user?->avatar))
                            <img id="customer-profile-avatar-preview"
                                 src="{{ $user->avatar_url }}"
                                 alt="Avatar"
                                 class="w-full h-full object-cover">
                            <span id="customer-profile-avatar-initials" class="hidden">{{ $userInitials }}</span>
                        @else
                            <img id="customer-profile-avatar-preview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                            <span id="customer-profile-avatar-initials">{{ $userInitials }}</span>
                        @endif
                        <span class="absolute inset-0 bg-[#27443E]/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
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
                            class="w-6 h-6 rounded-full bg-[#E5E0D2] hover:bg-[#D7D0BE] border-2 border-[#FFFDF8] flex items-center justify-center text-[#35524B] absolute bottom-0 right-0 shadow-2xs cursor-pointer transition active:scale-95 focus:outline-none z-10">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                        </svg>
                    </button>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-lg sm:text-2xl font-semibold text-[#27443E] leading-tight break-words">{{ $user?->name }}</h2>
                    <p class="text-xs sm:text-sm text-[#6C807B] mt-0.5 break-all">{{ $user?->email }}</p>
                    <p class="text-[11px] text-[#8E9E99] mt-1">Format foto: JPG atau PNG (maks. 4 MB)</p>
                    @error('avatar') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <form id="customer-profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-sm">
                @csrf
                <input type="hidden" name="avatar_data" id="customer-profile-avatar-data" value="">
                <input type="file"
                       id="customer-profile-avatar-input"
                       name="avatar"
                       accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                       class="hidden"
                       onchange="handleCustomerPageAvatarChange(this)">

                <div>
                    <label for="customer-profile-name" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Username</label>
                    <input type="text"
                           id="customer-profile-name"
                           name="name"
                           value="{{ old('name', $user?->name) }}"
                           required
                           class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                    @error('name') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-7">
                    <div>
                        <label for="customer-profile-email" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Email</label>
                        <input type="email"
                               id="customer-profile-email"
                               name="email"
                               value="{{ old('email', $user?->email) }}"
                               required
                               class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                        @error('email') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="customer-profile-phone" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Nomor telfon</label>
                        <input type="tel"
                               id="customer-profile-phone"
                               name="phone_number"
                               inputmode="numeric"
                               pattern="[0-9]+(-[0-9]+)*"
                               maxlength="15"
                               value="{{ old('phone_number', $user?->phone_number) }}"
                               placeholder="Masukkan nomor telepon"
                               class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-[#9AA7A2] focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                        @error('phone_number') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="customer-profile-address" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Alamat</label>
                    <input type="text"
                           id="customer-profile-address"
                           name="address"
                           value="{{ old('address', $user?->address) }}"
                           placeholder="Masukkan alamat lengkap"
                           class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-[#9AA7A2] focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                    @error('address') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-1">
                    <button type="submit" class="bg-[#3B6E64] hover:bg-[#315D54] active:scale-[0.99] text-white font-medium py-3.5 px-6 rounded-xl w-full min-h-[48px] shadow-2xs transition text-sm select-none cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>

            <form id="customer-password-form" action="{{ route('profile.update') }}" method="POST" class="space-y-5 pt-6 text-sm border-t border-[#ECE5D3]">
                @csrf
                <input type="hidden" name="name" value="{{ $user?->name }}">
                <input type="hidden" name="email" value="{{ $user?->email }}">
                <input type="hidden" name="phone_number" value="{{ $user?->phone_number }}">
                <input type="hidden" name="address" value="{{ $user?->address }}">

                <div>
                    <label for="customer-profile-new-password" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Password baru</label>
                    <input type="password"
                           id="customer-profile-new-password"
                           name="password"
                           placeholder="Masukkan Password"
                           class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-[#9AA7A2] focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                    @error('password') <span class="text-[#C83E2B] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="customer-profile-confirm-password" class="block font-semibold text-[#35524B] mb-2 text-xs sm:text-[13px]">Konfirmasi Password</label>
                    <input type="password"
                           id="customer-profile-confirm-password"
                           name="password_confirmation"
                           placeholder="Konfirmasi Password"
                           class="w-full bg-[#FAF7EE] focus:bg-[#FFFDF8] border border-[#E2DAC4] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-[#9AA7A2] focus:outline-none focus:border-[#3B6E64] transition text-[#27443E]">
                </div>

                <div class="pt-1">
                    <button type="submit" class="bg-[#3B6E64] hover:bg-[#315D54] active:scale-[0.99] text-white font-medium py-3.5 px-6 rounded-xl w-full min-h-[48px] shadow-2xs transition text-sm select-none cursor-pointer">
                        Simpan
                    </button>
                </div>
            </form>

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
</div>
@endsection

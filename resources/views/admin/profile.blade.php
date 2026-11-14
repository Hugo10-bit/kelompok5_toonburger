@php $errors = $errors ?? new \Illuminate\Support\ViewErrorBag; @endphp
@extends('layouts.admin')

@section('title', 'Profil Admin - Toon Burger Admin')

@section('admin_content')
<div class="bg-white dark:bg-[#2B2B2B] rounded-[28px] sm:rounded-[32px] border border-gray-200/80 dark:border-[#3F3F3F] shadow-xs p-6 sm:p-9 lg:p-10 flex-1 flex flex-col justify-between space-y-7">

    <div>
        <h1 class="text-2xl sm:text-[32px] lg:text-[36px] font-bold text-[#333333] dark:text-white tracking-tight leading-tight" data-i18n="prof_title">Profil Admin</h1>
        <p class="text-sm sm:text-[15px] text-gray-500 dark:text-[#D4D4D4] mt-1.5" data-i18n="prof_sub">Kelola informasi akun dan profil admin</p>
    </div>

    <div class="flex items-center gap-5 pt-1 pb-2">
        <div class="relative shrink-0 select-none">
            <button type="button"
                    onclick="document.getElementById('profile-avatar-input').click()"
                    title="Ubah Foto Profil"
                    class="w-20 h-20 rounded-full bg-[#F79E1B] text-white font-bold text-2xl flex items-center justify-center relative overflow-hidden cursor-pointer group focus:outline-none">
                @if(!empty($user?->avatar))
                    <img id="profile-avatar-preview"
                         src="{{ str_starts_with($user->avatar, 'http') ? $user->avatar : asset($user->avatar) }}"
                         alt="Avatar"
                         class="w-full h-full object-cover">
                    <span id="profile-avatar-initials" class="hidden">Tb</span>
                @else
                    <img id="profile-avatar-preview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                    <span id="profile-avatar-initials">Tb</span>
                @endif
                <span class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                </span>
            </button>
            <button type="button"
                    onclick="document.getElementById('profile-avatar-input').click()"
                    title="Ubah Foto Profil"
                    aria-label="Ubah Foto Profil"
                    class="w-6 h-6 rounded-full bg-[#D1D5DB] hover:bg-[#BFC5CE] dark:bg-[#4F4F4F] dark:hover:bg-[#616161] border border-white dark:border-[#2B2B2B] flex items-center justify-center text-gray-600 dark:text-white absolute bottom-0 right-0 shadow-2xs cursor-pointer transition active:scale-95 focus:outline-none z-10">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
                </svg>
            </button>
        </div>
        <div>
            <h2 class="text-2xl font-normal text-gray-800 dark:text-white leading-tight">{{ $user?->name ?: 'Toon Burger' }}</h2>
            <p class="text-sm text-gray-400 dark:text-[#BDBDBD] mt-0.5">{{ $user?->email ?: 'Toonburger@gmail.com' }}</p>
            @error('avatar') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>
    </div>

    <form id="admin-profile-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-sm">
        @csrf
        <input type="file"
               id="profile-avatar-input"
               name="avatar"
               accept="image/png,image/jpeg,image/jpg,image/webp,image/gif"
               class="hidden"
               onchange="handleAdminAvatarChange(this)">

        <div>
            <label for="profile-username" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_username">Username</label>
            <input type="text"
                   id="profile-username"
                   name="name"
                   value="{{ old('name', $user?->name ?: 'Toon Burger') }}"
                   required
                   class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
            @error('name') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 sm:gap-7">
            <div>
                <label for="profile-email" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_email">Email</label>
                <input type="email"
                       id="profile-email"
                       name="email"
                       value="{{ old('email', $user?->email ?: 'Toonburger@gmail.com') }}"
                       required
                       class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
                @error('email') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="profile-phone" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_phone">Nomor telfon</label>
                <input type="text"
                       id="profile-phone"
                       name="phone_number"
                       value="{{ old('phone_number', $user?->phone_number ?: '085780153872') }}"
                       class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
                @error('phone_number') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label for="profile-address" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_address">Alamat</label>
            <input type="text"
                   id="profile-address"
                   name="address"
                   value="{{ old('address', $user?->address ?: 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714') }}"
                   class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
            @error('address') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-1">
            <button type="submit" class="bg-[#415C58] hover:bg-[#344B48] active:scale-[0.99] text-white font-medium py-3.5 px-6 rounded-xl w-full min-h-[48px] shadow-2xs transition text-sm select-none cursor-pointer" data-i18n="prof_save">
                Simpan
            </button>
        </div>
    </form>

    <form id="admin-password-form" action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5 pt-6 text-sm">
        @csrf
        <input type="hidden" name="name" value="{{ $user?->name ?: 'Toon Burger' }}">
        <input type="hidden" name="email" value="{{ $user?->email ?: 'Toonburger@gmail.com' }}">
        <input type="hidden" name="phone_number" value="{{ $user?->phone_number ?: '085780153872' }}">
        <input type="hidden" name="address" value="{{ $user?->address ?: 'Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjar Baru, Kalimantan Selatan 70714' }}">

        <div>
            <label for="profile-new-password" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_new_pass">Password baru</label>
            <input type="password"
                   id="profile-new-password"
                   name="password"
                   placeholder="Masukkan Password"
                   data-i18n-attr="placeholder:prof_new_pass_ph"
                   class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-gray-400 dark:placeholder-[#9E9E9E] focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
            @error('password') <span class="text-[#DE3B28] text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="profile-confirm-password" class="block font-bold text-gray-800 dark:text-[#E5E5E5] mb-2 text-xs sm:text-[13px]" data-i18n="prof_conf_pass">Konfirmasi Password</label>
            <input type="password"
                   id="profile-confirm-password"
                   name="password_confirmation"
                   placeholder="Konfirmasi Password"
                   data-i18n-attr="placeholder:prof_conf_pass_ph"
                   class="w-full bg-white dark:bg-[#383838] border border-gray-200 dark:border-[#525252] rounded-xl px-5 py-3.5 min-h-[48px] text-sm font-normal placeholder-gray-400 dark:placeholder-[#9E9E9E] focus:outline-none focus:border-[#415C58] transition text-gray-800 dark:text-white">
        </div>

        <div class="pt-1">
            <button type="submit" class="bg-[#415C58] hover:bg-[#344B48] active:scale-[0.99] text-white font-medium py-3.5 px-6 rounded-xl w-full min-h-[48px] shadow-2xs transition text-sm select-none cursor-pointer" data-i18n="prof_save">
                Simpan
            </button>
        </div>
    </form>

    <!-- Modal Konfirmasi Edit Profil Admin -->
    <div id="profile-confirm-modal"
         class="fixed inset-0 z-[99999] hidden items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-[2px] transition-opacity duration-200"
             onclick="closeProfileConfirmModal()"></div>

        <div class="relative bg-white dark:bg-[#303030] rounded-[28px] sm:rounded-[32px] shadow-2xl p-8 sm:p-10 max-w-[440px] w-full text-center z-10 select-none animate-modal-pop border border-gray-100 dark:border-[#4A4A4A] mx-auto my-auto">
            <div class="w-24 h-24 sm:w-[104px] sm:h-[104px] rounded-full border-[6.5px] sm:border-[7.5px] border-[#415C58] flex items-center justify-center mx-auto mb-6 bg-white dark:bg-[#303030] shrink-0 text-[#415C58]">
                <svg id="profile-modal-icon-profile" class="w-10 h-10 sm:w-11 sm:h-11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <svg id="profile-modal-icon-password" class="w-10 h-10 sm:w-11 sm:h-11 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <svg id="profile-modal-icon-avatar" class="w-10 h-10 sm:w-11 sm:h-11 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            <h3 id="profile-confirm-title" class="text-2xl sm:text-[26px] font-bold text-gray-900 dark:text-white tracking-tight mb-3">
                Konfirmasi Simpan Profil
            </h3>

            <p id="profile-confirm-message" class="text-sm text-gray-500 dark:text-[#A3A3A3] leading-relaxed mb-8 max-w-[340px] mx-auto">
                Apakah Anda yakin ingin menyimpan perubahan pada profil admin ini?
            </p>

            <div class="flex items-center justify-center gap-4">
                <button type="button"
                        onclick="closeProfileConfirmModal()"
                        class="min-w-[130px] sm:min-w-[140px] px-6 py-3 rounded-full border border-gray-400 dark:border-gray-500 text-gray-800 dark:text-gray-100 text-sm font-semibold hover:bg-gray-50 dark:hover:bg-[#3E3E3E] active:scale-95 transition cursor-pointer">
                    Batalkan
                </button>
                <button type="button"
                        id="profile-confirm-proceed-btn"
                        class="min-w-[130px] sm:min-w-[140px] px-6 py-3 rounded-full bg-[#415C58] hover:bg-[#344B48] text-white text-sm font-semibold shadow-md active:scale-95 transition cursor-pointer">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

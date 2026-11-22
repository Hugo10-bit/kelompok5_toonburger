import { isValidJpgOrPngFile, dataUrlToFile, attachFileToInput } from './image-upload';
import { openAvatarCropperModal } from './avatar-cropper';

const ADMIN_EYE_OPEN_SVG = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
const ADMIN_EYE_OFF_SVG = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';

function isAdminProfileEn() {
    return window._tbLang === 'US' || window._tbLang === 'EN' || localStorage.getItem('tb_admin_lang') === 'US';
}

window.toggleAdminPasswordVisibility = function toggleAdminPasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const willShow = input.type === 'password';
    input.type = willShow ? 'text' : 'password';
    const icon = btn ? btn.querySelector('.eye-icon') : null;
    if (icon) {
        icon.innerHTML = willShow ? ADMIN_EYE_OFF_SVG : ADMIN_EYE_OPEN_SVG;
    }
    if (btn) {
        const isEn = isAdminProfileEn();
        btn.setAttribute(
            'aria-label',
            willShow
                ? (isEn ? 'Hide Password' : 'Sembunyikan Password')
                : (isEn ? 'Show Password' : 'Tampilkan Password')
        );
    }
};

function bindAdminPasswordMatchStatus() {
    const passInput = document.getElementById('profile-new-password');
    const confirmInput = document.getElementById('profile-confirm-password');
    const statusEl = document.getElementById('admin-password-match-status');
    if (!passInput || !confirmInput || !statusEl) return;

    const syncAdminTranslation = () => {
        if (typeof window.applyTranslations === 'function') {
            window.applyTranslations(window._tbLang || localStorage.getItem('tb_admin_lang') || 'ID', true);
        }
    };

    const updateMatchStatus = () => {
        const pass1 = passInput.value || '';
        const pass2 = confirmInput.value || '';

        if (!pass2) {
            statusEl.classList.add('hidden');
            statusEl.classList.remove('flex', 'text-emerald-600', 'dark:text-emerald-400', 'text-[#DE3B28]', 'dark:text-[#FCA5A5]');
            statusEl.innerHTML = '';
            return;
        }

        const isMatch = pass1.length > 0 && pass1 === pass2;
        statusEl.classList.remove('hidden', 'text-emerald-600', 'dark:text-emerald-400', 'text-[#DE3B28]', 'dark:text-[#FCA5A5]');
        statusEl.classList.add('flex');
        if (isMatch) {
            statusEl.classList.add('text-emerald-600', 'dark:text-emerald-400');
            statusEl.innerHTML = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg><span data-i18n="prof_pass_match">Password cocok</span>';
        } else {
            statusEl.classList.add('text-[#DE3B28]', 'dark:text-[#FCA5A5]');
            statusEl.innerHTML = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg><span data-i18n="prof_pass_mismatch">Konfirmasi password tidak cocok</span>';
        }
        syncAdminTranslation();
    };

    const showPasteBlockedNotice = () => {
        statusEl.classList.remove('hidden', 'text-emerald-600', 'dark:text-emerald-400', 'text-[#DE3B28]', 'dark:text-[#FCA5A5]');
        statusEl.classList.add('flex', 'text-[#DE3B28]', 'dark:text-[#FCA5A5]');
        statusEl.innerHTML = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg><span data-i18n="prof_pass_paste_blocked">Ketik ulang konfirmasi password secara manual</span>';
        syncAdminTranslation();
    };

    if (confirmInput.dataset.matchBound !== 'true') {
        confirmInput.dataset.matchBound = 'true';

        // Unlock readonly only when the user explicitly interacts with the confirm field
        // so mobile password managers only autofill the new password field.
        const unlockConfirmField = () => {
            if (confirmInput.hasAttribute('readonly')) {
                confirmInput.removeAttribute('readonly');
            }
        };
        confirmInput.addEventListener('pointerdown', unlockConfirmField);
        confirmInput.addEventListener('touchstart', unlockConfirmField, { passive: true });
        confirmInput.addEventListener('focus', unlockConfirmField);
        confirmInput.addEventListener('blur', () => {
            if (!confirmInput.value) {
                confirmInput.setAttribute('readonly', 'readonly');
            }
        });

        passInput.addEventListener('input', () => {
            if (document.activeElement !== confirmInput && confirmInput.value && confirmInput.value === passInput.value) {
                confirmInput.value = '';
            }
            updateMatchStatus();
        });
        passInput.addEventListener('copy', (e) => e.preventDefault());
        passInput.addEventListener('cut', (e) => e.preventDefault());
        confirmInput.addEventListener('input', () => {
            if (document.activeElement !== confirmInput) {
                confirmInput.value = '';
            }
            updateMatchStatus();
        });
        confirmInput.addEventListener('paste', (e) => {
            e.preventDefault();
            showPasteBlockedNotice();
        });
        confirmInput.addEventListener('drop', (e) => {
            e.preventDefault();
            showPasteBlockedNotice();
        });
    }
    updateMatchStatus();
}

function initAdminProfile() {
    if (!document.getElementById('profile-confirm-modal')) return;
    bindAdminPasswordMatchStatus();
    let _onProfileConfirm = null;
    let _onProfileCancel = null;
    let pendingAvatarCompression = Promise.resolve('');

    window.openProfileConfirmModal = function (options) {
        const modal = document.getElementById('profile-confirm-modal');
        const titleEl = document.getElementById('profile-confirm-title');
        const msgEl = document.getElementById('profile-confirm-message');
        const btnEl = document.getElementById('profile-confirm-proceed-btn');

        const iconProfile = document.getElementById('profile-modal-icon-profile');
        const iconPass = document.getElementById('profile-modal-icon-password');
        const iconAvatar = document.getElementById('profile-modal-icon-avatar');

        if (iconProfile) iconProfile.classList.toggle('hidden', options.type !== 'profile');
        if (iconPass) iconPass.classList.toggle('hidden', options.type !== 'password');
        if (iconAvatar) iconAvatar.classList.toggle('hidden', options.type !== 'avatar');

        if (titleEl) titleEl.textContent = options.title || 'Konfirmasi Simpan';
        if (msgEl) msgEl.textContent = options.message || 'Apakah Anda yakin ingin melanjutkan perubahan?';
        if (btnEl) btnEl.textContent = options.confirmText || 'Ya, Simpan';

        _onProfileConfirm = options.onConfirm || null;
        _onProfileCancel = options.onCancel || null;

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    };

    window.closeProfileConfirmModal = function (isConfirm = false) {
        const modal = document.getElementById('profile-confirm-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        if (!isConfirm && typeof _onProfileCancel === 'function') {
            _onProfileCancel();
        }
        _onProfileConfirm = null;
        _onProfileCancel = null;
    };

    const proceedBtn = document.getElementById('profile-confirm-proceed-btn');
    if (proceedBtn && proceedBtn.dataset.bound !== 'true') {
        proceedBtn.dataset.bound = 'true';
        proceedBtn.addEventListener('click', function () {
            const action = _onProfileConfirm;
            window.closeProfileConfirmModal(true);
            if (typeof action === 'function') {
                action();
            }
        });
    }

    function showProfileWarning(title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title,
                text,
                confirmButtonColor: '#415C58'
            });
        } else {
            alert(text);
        }
    }

    window.handleAdminAvatarChange = function (input) {
        const avatarDataInput = document.getElementById('profile-avatar-data');
        if (input) input.disabled = false;

        if (!input || !input.files || !input.files[0]) {
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        const file = input.files[0];

        if (!isValidJpgOrPngFile(file)) {
            showProfileWarning(
                'Format File Tidak Sesuai',
                'Foto profil hanya diperbolehkan berformat JPG atau PNG.'
            );
            input.value = '';
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        if (file.size > 4 * 1024 * 1024) {
            showProfileWarning(
                'Ukuran File Terlalu Besar',
                'Ukuran foto profil maksimal 4 MB.'
            );
            input.value = '';
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        const isAdminEn = window._tbLang === 'US' || window._tbLang === 'EN';
        if (avatarDataInput) avatarDataInput.value = '';
        pendingAvatarCompression = openAvatarCropperModal(file, {
            isEn: isAdminEn,
            outputSize: 512,
            maxDataUrlLength: 450000,
        }).then((dataUrl) => {
            if (!dataUrl) {
                input.value = '';
                if (avatarDataInput) avatarDataInput.value = '';
                return '';
            }

            if (avatarDataInput) avatarDataInput.value = dataUrl;
            const preview = document.getElementById('profile-avatar-preview');
            const initials = document.getElementById('profile-avatar-initials');

            if (preview) {
                preview.src = dataUrl;
                preview.classList.remove('hidden');
            }
            if (initials) {
                initials.classList.add('hidden');
            }

            return dataUrl;
        });
    };

    // Form 1: Admin Profile form submission
    const profileForm = document.getElementById('admin-profile-form');
    if (profileForm && profileForm.dataset.profileBound !== 'true') {
        profileForm.dataset.profileBound = 'true';
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!profileForm.checkValidity()) {
                profileForm.reportValidity();
                return;
            }

            const avatarInput = document.getElementById('profile-avatar-input');
            const avatarDataInput = document.getElementById('profile-avatar-data');
            const hasNewAvatar = Boolean(
                (avatarInput && avatarInput.files && avatarInput.files.length > 0)
                || (avatarDataInput && avatarDataInput.value.startsWith('data:image/'))
            );

            const message = hasNewAvatar
                ? 'Apakah Anda yakin ingin menyimpan perubahan data dan foto profil admin ini?'
                : 'Apakah Anda yakin ingin menyimpan perubahan informasi profil admin ini?';

            window.openProfileConfirmModal({
                type: hasNewAvatar ? 'avatar' : 'profile',
                title: 'Konfirmasi Simpan Profil',
                message: message,
                confirmText: 'Ya, Simpan',
                onConfirm: function () {
                    const finalizeProfileSubmit = async () => {
                        await pendingAvatarCompression;
                        const currentAvatarInput = document.getElementById('profile-avatar-input');
                        const currentAvatarData = document.getElementById('profile-avatar-data');
                        if (currentAvatarData && currentAvatarData.value.startsWith('data:image/') && currentAvatarInput) {
                            const isPng = currentAvatarData.value.startsWith('data:image/png');
                            const file = dataUrlToFile(currentAvatarData.value, isPng ? 'avatar.png' : 'avatar.jpg');
                            if (file && attachFileToInput(currentAvatarInput, file)) {
                                currentAvatarInput.disabled = false;
                                currentAvatarData.value = '';
                            } else {
                                currentAvatarInput.disabled = true;
                            }
                        }
                        profileForm.submit();
                    };

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Menyimpan Profil...',
                            html: 'Sedang memproses perubahan profil admin dalam <b></b> detik...',
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                Swal.showLoading();
                                const b = Swal.getPopup().querySelector('b');
                                setInterval(() => {
                                    if (b) b.textContent = Math.ceil(Swal.getTimerLeft() / 1000) || 1;
                                }, 100);
                            }
                        }).then(() => {
                            finalizeProfileSubmit();
                        });
                    } else {
                        finalizeProfileSubmit();
                    }
                }
            });
        });
    }

    // Form 2: Admin Password form submission
    const passwordForm = document.getElementById('admin-password-form');
    if (passwordForm && passwordForm.dataset.passwordBound !== 'true') {
        passwordForm.dataset.passwordBound = 'true';
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const pass1 = document.getElementById('profile-new-password')?.value || '';
            const pass2 = document.getElementById('profile-confirm-password')?.value || '';

            if (!pass1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Baru Kosong',
                    text: 'Silakan masukkan password baru Anda terlebih dahulu.',
                    confirmButtonColor: '#415C58'
                });
                return;
            }

            if (pass1.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Kurang Panjang',
                    text: 'Password baru minimal harus 6 karakter.',
                    confirmButtonColor: '#415C58'
                });
                return;
            }

            if (pass1 !== pass2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi Password Tidak Cocok',
                    text: 'Konfirmasi password harus sama persis dengan password baru.',
                    confirmButtonColor: '#415C58'
                });
                return;
            }

            window.openProfileConfirmModal({
                type: 'password',
                title: 'Konfirmasi Ubah Password',
                message: 'Apakah Anda yakin ingin memperbarui password akun admin?',
                confirmText: 'Ya, Ubah Password',
                onConfirm: function () {
                    Swal.fire({
                        title: 'Memperbarui Password...',
                        html: 'Sedang memproses password baru admin dalam <b></b> detik...',
                        timer: 1500,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                            const b = Swal.getPopup().querySelector('b');
                            setInterval(() => {
                                if (b) b.textContent = Math.ceil(Swal.getTimerLeft() / 1000) || 1;
                            }, 100);
                        }
                    }).then(() => {
                        passwordForm.submit();
                    });
                }
            });
        });
    }
}

initAdminProfile();
window.addEventListener('tb:admin:pjax:loaded', initAdminProfile);

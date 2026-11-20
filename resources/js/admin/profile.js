import { isValidJpgOrPngFile, dataUrlToFile, attachFileToInput } from './image-upload';
import { openAvatarCropperModal } from './avatar-cropper';

function initAdminProfile() {
    if (!document.getElementById('profile-confirm-modal')) return;
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

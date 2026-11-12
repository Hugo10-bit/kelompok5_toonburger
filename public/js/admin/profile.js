(function () {
    let _onProfileConfirm = null;
    let _onProfileCancel = null;

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

    document.getElementById('profile-confirm-proceed-btn')?.addEventListener('click', function () {
        const action = _onProfileConfirm;
        window.closeProfileConfirmModal(true);
        if (typeof action === 'function') {
            action();
        }
    });

    window.handleAdminAvatarChange = function (input) {
        if (!input.files || !input.files[0]) return;
        const file = input.files[0];

        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'warning',
                title: 'Format File Tidak Sesuai',
                text: 'Silakan pilih file gambar dengan format JPEG, PNG, JPG, WEBP, atau GIF.',
                confirmButtonColor: '#415C58'
            });
            input.value = '';
            return;
        }

        // Preview the selected image immediately
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('profile-avatar-preview');
            const initials = document.getElementById('profile-avatar-initials');

            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (initials) {
                initials.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    };

    // Form 1: Admin Profile form submission
    const profileForm = document.getElementById('admin-profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!profileForm.checkValidity()) {
                profileForm.reportValidity();
                return;
            }

            const avatarInput = document.getElementById('profile-avatar-input');
            const hasNewAvatar = avatarInput && avatarInput.files && avatarInput.files.length > 0;

            const message = hasNewAvatar
                ? 'Apakah Anda yakin ingin menyimpan perubahan data dan foto profil admin ini?'
                : 'Apakah Anda yakin ingin menyimpan perubahan informasi profil admin ini?';

            window.openProfileConfirmModal({
                type: hasNewAvatar ? 'avatar' : 'profile',
                title: 'Konfirmasi Simpan Profil',
                message: message,
                confirmText: 'Ya, Simpan',
                onConfirm: function () {
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
                        profileForm.submit();
                    });
                }
            });
        });
    }

    // Form 2: Admin Password form submission
    const passwordForm = document.getElementById('admin-password-form');
    if (passwordForm) {
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
})();

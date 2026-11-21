import { isValidJpgOrPngFile, dataUrlToFile, attachFileToInput } from '../admin/image-upload';
import { openAvatarCropperModal } from '../admin/avatar-cropper';

let isUploadingNavbarAvatar = false;
let avatarToastTimer = null;

function isProfileEn() {
    if (window._tbAppLang === 'EN' || window._tbAppLang === 'US') return true;
    try {
        const saved = localStorage.getItem('tb_lang') || localStorage.getItem('tb_admin_lang') || '';
        return saved === 'EN' || saved === 'US';
    } catch (e) {
        return false;
    }
}

function pText(idText, enText) {
    return isProfileEn() ? enText : idText;
}

function notifyAvatarFeedback(message, type = 'success') {
    const existing = document.getElementById('navbar-avatar-toast');
    if (existing) {
        existing.remove();
    }
    if (avatarToastTimer) {
        clearTimeout(avatarToastTimer);
        avatarToastTimer = null;
    }

    const isError = type === 'error';
    const toast = document.createElement('div');
    toast.id = 'navbar-avatar-toast';
    toast.setAttribute('role', 'status');
    toast.setAttribute('aria-live', 'polite');
    toast.className = [
        'fixed bottom-5 right-5 z-[9999] max-w-[calc(100vw-2.5rem)]',
        'inline-flex items-center gap-2.5 px-3.5 py-2.5 rounded-2xl',
        'bg-white border border-gray-200/90 shadow-lg text-xs font-semibold text-gray-800',
        'transition-all duration-200 translate-y-2 opacity-0 pointer-events-auto',
    ].join(' ');

    const iconWrap = document.createElement('span');
    iconWrap.className = isError
        ? 'w-5 h-5 rounded-full bg-red-100 text-red-600 inline-flex items-center justify-center shrink-0'
        : 'w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 inline-flex items-center justify-center shrink-0';
    iconWrap.setAttribute('aria-hidden', 'true');
    iconWrap.innerHTML = isError
        ? '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>'
        : '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>';

    const textEl = document.createElement('span');
    textEl.className = 'leading-snug';
    textEl.textContent = message;

    toast.appendChild(iconWrap);
    toast.appendChild(textEl);
    document.body.appendChild(toast);

    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    });

    avatarToastTimer = setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-2', 'opacity-0');
        setTimeout(() => toast.remove(), 220);
    }, 2600);
}

function renderAvatarSlots(avatarUrl) {
    const slots = document.querySelectorAll('[data-user-avatar-slot]');
    slots.forEach((slot) => {
        if (avatarUrl) {
            slot.innerHTML = '';
            const img = document.createElement('img');
            img.src = avatarUrl;
            img.alt = 'Avatar';
            img.className = 'w-full h-full object-cover';
            slot.appendChild(img);
        } else {
            slot.textContent = slot.dataset.userInitials || 'TB';
        }
    });
}

function captureAvatarSlotsState() {
    return Array.from(document.querySelectorAll('[data-user-avatar-slot]')).map((slot) => ({
        slot,
        html: slot.innerHTML,
    }));
}

function restoreAvatarSlotsState(snapshot) {
    snapshot.forEach(({ slot, html }) => {
        slot.innerHTML = html;
    });
}

export function triggerNavbarAvatarPicker(event) {
    if (event) {
        event.stopPropagation();
    }
    if (isUploadingNavbarAvatar) return;

    const input = document.getElementById('navbar-avatar-input');
    if (input) {
        input.click();
    }
}

export async function handleNavbarAvatarChange(input) {
    if (!input || !input.files || !input.files[0]) return;
    if (isUploadingNavbarAvatar) return;

    const file = input.files[0];

    if (!isValidJpgOrPngFile(file)) {
        input.value = '';
        notifyAvatarFeedback(
            pText('Format foto profil hanya diperbolehkan JPG atau PNG.', 'Profile photo must be a JPG or PNG file.'),
            'error'
        );
        return;
    }

    if (file.size > 4 * 1024 * 1024) {
        input.value = '';
        notifyAvatarFeedback(
            pText('Ukuran foto profil maksimal 4 MB.', 'Maximum profile photo size is 4 MB.'),
            'error'
        );
        return;
    }

    const uploadUrl = input.dataset.uploadUrl || '/profile/avatar';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const previousSnapshot = captureAvatarSlotsState();

    isUploadingNavbarAvatar = true;
    try {
        const dataUrl = await openAvatarCropperModal(file, {
            isEn: isProfileEn(),
            outputSize: 480,
            maxDataUrlLength: 450000,
        });

        input.value = '';

        if (!dataUrl) {
            return;
        }

        renderAvatarSlots(dataUrl);

        const isPng = dataUrl.startsWith('data:image/png');
        const fileObj = dataUrlToFile(dataUrl, isPng ? 'avatar.png' : 'avatar.jpg');
        const formData = new FormData();
        if (fileObj) {
            formData.append('avatar', fileObj);
        } else {
            formData.append('avatar_data', dataUrl);
        }

        const response = await fetch(uploadUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'application/json',
            },
            body: formData,
        });

        const payload = await response.json().catch(() => ({}));
        if (!response.ok || !payload.success) {
            restoreAvatarSlotsState(previousSnapshot);
            notifyAvatarFeedback(
                isProfileEn()
                    ? 'Failed to update profile photo.'
                    : (payload.message || 'Gagal memperbarui foto profil.'),
                'error'
            );
            return;
        }

        if (payload.avatar_url) {
            renderAvatarSlots(payload.avatar_url);
        }
        notifyAvatarFeedback(
            isProfileEn()
                ? 'Profile photo updated successfully!'
                : (payload.message || 'Foto profil berhasil diperbarui!'),
            'success'
        );
    } catch (err) {
        restoreAvatarSlotsState(previousSnapshot);
        notifyAvatarFeedback(
            pText('Terjadi gangguan koneksi saat mengunggah foto profil.', 'Network error while uploading profile photo.'),
            'error'
        );
    } finally {
        isUploadingNavbarAvatar = false;
    }
}

function initCustomerProfilePage() {
    if (!document.getElementById('customer-profile-confirm-modal')) return;

    let onConfirmAction = null;
    let pendingAvatarCompression = Promise.resolve('');

    window.openCustomerProfileConfirmModal = function (options) {
        const modal = document.getElementById('customer-profile-confirm-modal');
        const titleEl = document.getElementById('customer-profile-confirm-title');
        const msgEl = document.getElementById('customer-profile-confirm-message');
        const btnEl = document.getElementById('customer-profile-confirm-proceed-btn');

        const iconProfile = document.getElementById('customer-profile-modal-icon-profile');
        const iconPass = document.getElementById('customer-profile-modal-icon-password');
        const iconAvatar = document.getElementById('customer-profile-modal-icon-avatar');

        if (iconProfile) iconProfile.classList.toggle('hidden', options.type !== 'profile');
        if (iconPass) iconPass.classList.toggle('hidden', options.type !== 'password');
        if (iconAvatar) iconAvatar.classList.toggle('hidden', options.type !== 'avatar');

        if (titleEl) titleEl.textContent = options.title || pText('Konfirmasi Simpan', 'Confirm Save');
        if (msgEl) msgEl.textContent = options.message || pText('Apakah Anda yakin ingin melanjutkan perubahan?', 'Are you sure you want to continue?');
        if (btnEl) btnEl.textContent = options.confirmText || pText('Ya, Simpan', 'Yes, Save');

        onConfirmAction = options.onConfirm || null;

        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    };

    window.closeCustomerProfileConfirmModal = function () {
        const modal = document.getElementById('customer-profile-confirm-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        onConfirmAction = null;
    };

    const proceedBtn = document.getElementById('customer-profile-confirm-proceed-btn');
    if (proceedBtn && proceedBtn.dataset.bound !== 'true') {
        proceedBtn.dataset.bound = 'true';
        proceedBtn.addEventListener('click', function () {
            const action = onConfirmAction;
            window.closeCustomerProfileConfirmModal();
            if (typeof action === 'function') {
                action();
            }
        });
    }

    function showProfileWarning(title, text) {
        if (typeof window.Swal !== 'undefined') {
            window.Swal.fire({
                icon: 'warning',
                title,
                text,
                confirmButtonColor: '#3B6E64',
            });
        } else {
            notifyAvatarFeedback(text, 'error');
        }
    }

    window.handleCustomerPageAvatarChange = function (input) {
        const avatarDataInput = document.getElementById('customer-profile-avatar-data');
        if (input) input.disabled = false;

        if (!input || !input.files || !input.files[0]) {
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        const file = input.files[0];

        if (!isValidJpgOrPngFile(file)) {
            showProfileWarning(
                pText('Format File Tidak Sesuai', 'Invalid File Format'),
                pText('Foto profil hanya diperbolehkan berformat JPG atau PNG.', 'Profile photo must be in JPG or PNG format.')
            );
            input.value = '';
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        if (file.size > 4 * 1024 * 1024) {
            showProfileWarning(
                pText('Ukuran File Terlalu Besar', 'File Too Large'),
                pText('Ukuran foto profil maksimal 4 MB.', 'Maximum profile photo size is 4 MB.')
            );
            input.value = '';
            if (avatarDataInput) avatarDataInput.value = '';
            pendingAvatarCompression = Promise.resolve('');
            return;
        }

        if (avatarDataInput) avatarDataInput.value = '';
        pendingAvatarCompression = openAvatarCropperModal(file, {
            isEn: isProfileEn(),
            outputSize: 512,
            maxDataUrlLength: 450000,
        }).then((dataUrl) => {
            if (!dataUrl) {
                input.value = '';
                if (avatarDataInput) avatarDataInput.value = '';
                return '';
            }

            if (avatarDataInput) avatarDataInput.value = dataUrl;
            const preview = document.getElementById('customer-profile-avatar-preview');
            const initials = document.getElementById('customer-profile-avatar-initials');

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

    const profileForm = document.getElementById('customer-profile-form');
    if (profileForm && profileForm.dataset.profileBound !== 'true') {
        profileForm.dataset.profileBound = 'true';
        profileForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (!profileForm.checkValidity()) {
                profileForm.reportValidity();
                return;
            }

            const avatarInput = document.getElementById('customer-profile-avatar-input');
            const avatarDataInput = document.getElementById('customer-profile-avatar-data');
            const hasNewAvatar = Boolean(
                (avatarInput && avatarInput.files && avatarInput.files.length > 0)
                || (avatarDataInput && avatarDataInput.value.startsWith('data:image/'))
            );

            const message = hasNewAvatar
                ? pText(
                    'Apakah Anda yakin ingin menyimpan perubahan data dan foto profil ini?',
                    'Are you sure you want to save your profile details and new photo?'
                )
                : pText(
                    'Apakah Anda yakin ingin menyimpan perubahan informasi profil ini?',
                    'Are you sure you want to save changes to your profile information?'
                );

            window.openCustomerProfileConfirmModal({
                type: hasNewAvatar ? 'avatar' : 'profile',
                title: pText('Konfirmasi Simpan Profil', 'Confirm Save Profile'),
                message,
                confirmText: pText('Ya, Simpan', 'Yes, Save'),
                onConfirm: function () {
                    const finalizeProfileSubmit = async () => {
                        await pendingAvatarCompression;
                        const currentAvatarInput = document.getElementById('customer-profile-avatar-input');
                        const currentAvatarData = document.getElementById('customer-profile-avatar-data');
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

                    if (typeof window.Swal !== 'undefined') {
                        window.Swal.fire({
                            title: pText('Menyimpan Profil...', 'Saving Profile...'),
                            html: pText(
                                'Sedang memproses perubahan profil dalam <b></b> detik...',
                                'Updating your profile in <b></b> seconds...'
                            ),
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                window.Swal.showLoading();
                                const b = window.Swal.getPopup().querySelector('b');
                                setInterval(() => {
                                    if (b) b.textContent = Math.ceil(window.Swal.getTimerLeft() / 1000) || 1;
                                }, 100);
                            },
                        }).then(() => {
                            finalizeProfileSubmit();
                        });
                    } else {
                        finalizeProfileSubmit();
                    }
                },
            });
        });
    }

    const passwordForm = document.getElementById('customer-password-form');
    if (passwordForm && passwordForm.dataset.passwordBound !== 'true') {
        passwordForm.dataset.passwordBound = 'true';
        passwordForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const pass1 = document.getElementById('customer-profile-new-password')?.value || '';
            const pass2 = document.getElementById('customer-profile-confirm-password')?.value || '';

            if (!pass1) {
                showProfileWarning(
                    pText('Password Baru Kosong', 'Empty New Password'),
                    pText('Silakan masukkan password baru Anda terlebih dahulu.', 'Please enter your new password first.')
                );
                return;
            }
            if (pass1.length < 6) {
                showProfileWarning(
                    pText('Password Kurang Panjang', 'Password Too Short'),
                    pText('Password baru minimal harus 6 karakter.', 'New password must be at least 6 characters.')
                );
                return;
            }
            if (pass1 !== pass2) {
                showProfileWarning(
                    pText('Konfirmasi Password Tidak Cocok', 'Password Confirmation Mismatch'),
                    pText('Konfirmasi password harus sama persis dengan password baru.', 'Password confirmation must match the new password.')
                );
                return;
            }

            window.openCustomerProfileConfirmModal({
                type: 'password',
                title: pText('Konfirmasi Ubah Password', 'Confirm Password Change'),
                message: pText(
                    'Apakah Anda yakin ingin memperbarui password akun Anda?',
                    'Are you sure you want to update your account password?'
                ),
                confirmText: pText('Ya, Ubah Password', 'Yes, Change Password'),
                onConfirm: function () {
                    if (typeof window.Swal !== 'undefined') {
                        window.Swal.fire({
                            title: pText('Memperbarui Password...', 'Updating Password...'),
                            html: pText(
                                'Sedang memproses password baru dalam <b></b> detik...',
                                'Updating your new password in <b></b> seconds...'
                            ),
                            timer: 1500,
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            didOpen: () => {
                                window.Swal.showLoading();
                                const b = window.Swal.getPopup().querySelector('b');
                                setInterval(() => {
                                    if (b) b.textContent = Math.ceil(window.Swal.getTimerLeft() / 1000) || 1;
                                }, 100);
                            },
                        }).then(() => {
                            passwordForm.submit();
                        });
                    } else {
                        passwordForm.submit();
                    }
                },
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', initCustomerProfilePage);

Object.assign(window, {
    triggerNavbarAvatarPicker,
    handleNavbarAvatarChange,
});

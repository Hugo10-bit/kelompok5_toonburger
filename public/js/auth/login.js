const translations = {
    id: {
        currentLabel: 'Indonesia',
        loginTitle: 'Selamat Datang Kembali!',
        loginSubtitle: 'Tolong isi detail anda terlebih dahulu.',
        loginEmailLabel: 'Username',
        loginEmailPlaceholder: 'Masukkan Username',
        loginPasswordLabel: 'Password',
        loginPasswordPlaceholder: 'Masukkan Password',
        rememberMe: 'Ingat Saya',
        forgotPassword: 'Lupa Password?',
        loginButton: 'Login',
        noAccount: 'Belum Punya Akun?',
        signUpNow: 'Daftar Sekarang',
        registerTitle: 'Buat Akun',
        registerSubtitle: 'Bergabung dengan keluarga Toon Burger',
        regUsernameLabel: 'Username',
        regUsernamePlaceholder: 'Masukkan username anda',
        regEmailLabel: 'Email',
        regEmailPlaceholder: 'Masukkan email anda',
        regPhoneLabel: 'Nomor Telepon',
        regPhonePlaceholder: 'Masukkan nomor telepon anda',
        regPasswordLabel: 'Password',
        regPasswordPlaceholder: 'Masukkan password (min. 6 karakter)',
        registerButton: 'Daftar',
        haveAccount: 'Sudah punya akun?',
        loginNow: 'Login Sekarang',
        pageTitleLogin: 'Selamat Datang Kembali! - Toon Burger',
        pageTitleRegister: 'Buat Akun - Toon Burger',
        themeAriaLight: 'Beralih ke mode gelap',
        themeAriaDark: 'Beralih ke mode terang',
        themeLightTooltip: 'Mode Terang',
        themeDarkTooltip: 'Mode Gelap'
    },
    en: {
        currentLabel: 'English',
        loginTitle: 'Welcome Back!',
        loginSubtitle: 'Please enter your detail first',
        loginEmailLabel: 'Username or Email',
        loginEmailPlaceholder: 'Enter your username or email',
        loginPasswordLabel: 'Password',
        loginPasswordPlaceholder: 'Enter your password',
        rememberMe: 'Remember Me',
        forgotPassword: 'Forgot Password?',
        loginButton: 'Login',
        noAccount: "Don't have an account?",
        signUpNow: 'Sign Up Now',
        registerTitle: 'Create Account',
        registerSubtitle: 'Join Toon Burger family',
        regUsernameLabel: 'Username',
        regUsernamePlaceholder: 'Enter your username',
        regEmailLabel: 'Email',
        regEmailPlaceholder: 'Enter your email',
        regPhoneLabel: 'Mobile Number',
        regPhonePlaceholder: 'Enter your mobile number',
        regPasswordLabel: 'Password',
        regPasswordPlaceholder: 'Enter your password (min. 6 characters)',
        registerButton: 'Sign Up',
        haveAccount: 'Already have an account?',
        loginNow: 'Login Now',
        pageTitleLogin: 'Welcome Back! - Toon Burger',
        pageTitleRegister: 'Create Account - Toon Burger',
        themeAriaLight: 'Switch to dark mode',
        themeAriaDark: 'Switch to light mode',
        themeLightTooltip: 'Light Mode',
        themeDarkTooltip: 'Dark Mode'
    }
};

function toggleTheme() {
    const isDark = document.documentElement.classList.contains('dark');
    setTheme(isDark ? 'light' : 'dark');
}

function setTheme(theme) {
    const btn = document.getElementById('theme-toggle-btn');
    const sunIcon = document.getElementById('theme-sun-icon');
    const moonIcon = document.getElementById('theme-moon-icon');
    const currentLang = localStorage.getItem('toon_lang') || 'id';
    const t = translations[currentLang] || translations.id;

    if (theme === 'dark') {
        document.documentElement.classList.add('dark');
        document.documentElement.style.colorScheme = 'dark';
        localStorage.setItem('toon_theme', 'dark');
        if (btn) {
            btn.setAttribute('aria-checked', 'true');
            btn.setAttribute('aria-label', t.themeAriaDark);
        }
        if (sunIcon) {
            sunIcon.className = "w-6 h-6 rounded-full bg-transparent text-gray-400 flex items-center justify-center transition-all duration-200";
        }
        if (moonIcon) {
            moonIcon.className = "w-6 h-6 rounded-full bg-[#3D3D3D] text-gray-100 shadow-xs flex items-center justify-center transition-all duration-200";
        }
    } else {
        document.documentElement.classList.remove('dark');
        document.documentElement.style.colorScheme = 'light';
        localStorage.setItem('toon_theme', 'light');
        if (btn) {
            btn.setAttribute('aria-checked', 'false');
            btn.setAttribute('aria-label', t.themeAriaLight);
        }
        if (sunIcon) {
            sunIcon.className = "w-6 h-6 rounded-full bg-white text-gray-700 shadow-xs flex items-center justify-center transition-all duration-200";
        }
        if (moonIcon) {
            moonIcon.className = "w-6 h-6 rounded-full bg-transparent text-gray-400 flex items-center justify-center transition-all duration-200";
        }
    }
}

function toggleLanguageDropdown(e) {
    e.stopPropagation();
    const menu = document.getElementById('lang-dropdown-menu');
    const chevron = document.getElementById('lang-chevron');
    const btn = document.getElementById('lang-toggle-btn');
    if (!menu) return;
    const isHidden = menu.classList.contains('hidden');
    menu.classList.toggle('hidden', !isHidden);
    if (chevron) chevron.classList.toggle('rotate-180', isHidden);
    if (btn) btn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
}

function changeLanguage(lang) {
    if (!translations[lang]) return;
    localStorage.setItem('toon_lang', lang);
    try {
        localStorage.setItem('tb_lang', lang === 'en' ? 'EN' : 'ID');
        localStorage.setItem('tb_admin_lang', lang === 'en' ? 'US' : 'ID');
    } catch (e) {}
    applyLanguage(lang);

    const menu = document.getElementById('lang-dropdown-menu');
    const chevron = document.getElementById('lang-chevron');
    const btn = document.getElementById('lang-toggle-btn');
    if (menu) menu.classList.add('hidden');
    if (chevron) chevron.classList.remove('rotate-180');
    if (btn) btn.setAttribute('aria-expanded', 'false');
}

function applyLanguage(lang) {
    const t = translations[lang] || translations.id;

    const currentLabel = document.getElementById('lang-current-label');
    if (currentLabel) currentLabel.textContent = t.currentLabel;

    const checkId = document.getElementById('check-id');
    const checkEn = document.getElementById('check-en');
    if (checkId) checkId.classList.toggle('hidden', lang !== 'id');
    if (checkEn) checkEn.classList.toggle('hidden', lang !== 'en');

    // Login Form
    const loginTitle = document.getElementById('login-title');
    if (loginTitle) loginTitle.textContent = t.loginTitle;
    const loginSubtitle = document.getElementById('login-subtitle');
    if (loginSubtitle) loginSubtitle.textContent = t.loginSubtitle;
    const loginEmailLabel = document.getElementById('login-email-label');
    if (loginEmailLabel) loginEmailLabel.textContent = t.loginEmailLabel;
    const loginEmail = document.getElementById('login-email');
    if (loginEmail) loginEmail.placeholder = t.loginEmailPlaceholder;
    const loginPasswordLabel = document.getElementById('login-password-label');
    if (loginPasswordLabel) loginPasswordLabel.textContent = t.loginPasswordLabel;
    const loginPassword = document.getElementById('login-password');
    if (loginPassword) loginPassword.placeholder = t.loginPasswordPlaceholder;
    const rememberText = document.getElementById('remember-label-text');
    if (rememberText) rememberText.textContent = t.rememberMe;
    const forgotPassLink = document.getElementById('forgot-pass-link');
    if (forgotPassLink) forgotPassLink.textContent = t.forgotPassword;
    const loginBtnText = document.getElementById('login-btn-text');
    if (loginBtnText) loginBtnText.textContent = t.loginButton;
    const noAccountText = document.getElementById('no-account-text');
    if (noAccountText) noAccountText.textContent = t.noAccount;
    const switchToRegisterBtn = document.getElementById('switch-to-register-btn');
    if (switchToRegisterBtn) switchToRegisterBtn.textContent = t.signUpNow;

    // Register Form
    const registerTitle = document.getElementById('register-title');
    if (registerTitle) registerTitle.textContent = t.registerTitle;
    const registerSubtitle = document.getElementById('register-subtitle');
    if (registerSubtitle) registerSubtitle.textContent = t.registerSubtitle;
    const regUsernameLabel = document.getElementById('reg-username-label');
    if (regUsernameLabel) regUsernameLabel.textContent = t.regUsernameLabel;
    const regUsername = document.getElementById('register-username');
    if (regUsername) regUsername.placeholder = t.regUsernamePlaceholder;
    const regEmailLabel = document.getElementById('reg-email-label');
    if (regEmailLabel) regEmailLabel.textContent = t.regEmailLabel;
    const regEmail = document.getElementById('register-email');
    if (regEmail) regEmail.placeholder = t.regEmailPlaceholder;
    const regPhoneLabel = document.getElementById('reg-phone-label');
    if (regPhoneLabel) regPhoneLabel.textContent = t.regPhoneLabel;
    const regPhone = document.getElementById('register-phone');
    if (regPhone) regPhone.placeholder = t.regPhonePlaceholder;
    const regPassLabel = document.getElementById('reg-pass-label');
    if (regPassLabel) regPassLabel.textContent = t.regPasswordLabel;
    const regPass = document.getElementById('register-password');
    if (regPass) regPass.placeholder = t.regPasswordPlaceholder;
    const registerBtnText = document.getElementById('register-btn-text');
    if (registerBtnText) registerBtnText.textContent = t.registerButton;
    const haveAccountText = document.getElementById('have-account-text');
    if (haveAccountText) haveAccountText.textContent = t.haveAccount;
    const switchToLoginBtn = document.getElementById('switch-to-login-btn');
    if (switchToLoginBtn) switchToLoginBtn.textContent = t.loginNow;

    const isLoginActive = !document.getElementById('login-form-panel').classList.contains('hidden');
    document.title = isLoginActive ? t.pageTitleLogin : t.pageTitleRegister;

    const isDark = document.documentElement.classList.contains('dark');
    const themeBtn = document.getElementById('theme-toggle-btn');
    if (themeBtn) {
        themeBtn.setAttribute('aria-label', isDark ? t.themeAriaDark : t.themeAriaLight);
    }
    const sunIcon = document.getElementById('theme-sun-icon');
    if (sunIcon) sunIcon.setAttribute('title', t.themeLightTooltip);
    const moonIcon = document.getElementById('theme-moon-icon');
    if (moonIcon) moonIcon.setAttribute('title', t.themeDarkTooltip);
}

// Close dropdown when clicking outside
document.addEventListener('click', function (e) {
    const container = document.getElementById('lang-dropdown-container');
    const menu = document.getElementById('lang-dropdown-menu');
    const chevron = document.getElementById('lang-chevron');
    const btn = document.getElementById('lang-toggle-btn');
    if (container && !container.contains(e.target)) {
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
    }
});

// Close dropdown on Escape key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        const menu = document.getElementById('lang-dropdown-menu');
        const chevron = document.getElementById('lang-chevron');
        const btn = document.getElementById('lang-toggle-btn');
        if (menu && !menu.classList.contains('hidden')) {
            menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
    }
});

function dismissAlert(alertEl) {
    if (!alertEl || alertEl.dataset.dismissing === 'true') return;
    alertEl.dataset.dismissing = 'true';
    alertEl.classList.add('alert-dismissing');
    setTimeout(function () {
        if (alertEl && alertEl.parentElement) {
            alertEl.remove();
        }
    }, 450);
}

function initAutoDismissAlerts(delay = 3500) {
    const alerts = document.querySelectorAll('.alert-auto-dismiss');
    alerts.forEach(function (alert) {
        if (alert.classList.contains('hidden')) return;
        if (alert.dataset.hasTimer === 'true') return;
        alert.dataset.hasTimer = 'true';
        setTimeout(function () {
            dismissAlert(alert);
        }, delay);
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const savedLang = localStorage.getItem('toon_lang') || (localStorage.getItem('tb_lang') ? localStorage.getItem('tb_lang').toLowerCase() : 'id');
    applyLanguage(savedLang);

    const savedTheme = localStorage.getItem('toon_theme') || 'light';
    setTheme(savedTheme);

    initAutoDismissAlerts();

    if (localStorage.getItem('tb_logged_out') === '1') {
        const warnAlert = document.getElementById('alert-warning');
        if (warnAlert) {
            warnAlert.classList.remove('hidden');
            warnAlert.classList.add('flex');
            setTimeout(function () {
                dismissAlert(warnAlert);
            }, 3500);
        }
        localStorage.removeItem('tb_logged_out');
    }
});

function switchToRegister() {
    document.getElementById('login-form-panel').classList.add('hidden');
    document.getElementById('register-form-panel').classList.remove('hidden');
    const currentLang = localStorage.getItem('toon_lang') || 'id';
    document.title = (translations[currentLang] || translations.id).pageTitleRegister;
    const registerUrl = document.body.dataset.registerUrl || '/register';
    window.history.replaceState(null, '', registerUrl);
}

function switchToLogin() {
    document.getElementById('register-form-panel').classList.add('hidden');
    document.getElementById('login-form-panel').classList.remove('hidden');
    const currentLang = localStorage.getItem('toon_lang') || 'id';
    document.title = (translations[currentLang] || translations.id).pageTitleLogin;
    const loginUrl = document.body.dataset.loginUrl || '/login';
    window.history.replaceState(null, '', loginUrl);
}

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    if (!input) return;
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';

    if (isPassword) {
        btn.setAttribute('aria-label', 'Sembunyikan Password');
        btn.innerHTML = `<svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3l18 18"/></svg>`;
    } else {
        btn.setAttribute('aria-label', 'Tampilkan Password');
        btn.innerHTML = `<svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
    }
}

// Reload page on Back / Forward navigation to prevent displaying cached authenticated views after logout
window.addEventListener('pageshow', function (event) {
    if (localStorage.getItem('tb_logged_out') === '1') {
        const warnAlert = document.getElementById('alert-warning');
        if (warnAlert) {
            warnAlert.classList.remove('hidden');
            warnAlert.classList.add('flex');
            setTimeout(function () {
                dismissAlert(warnAlert);
            }, 3500);
        }
        localStorage.removeItem('tb_logged_out');
    }

    const navEntries = window.performance && window.performance.getEntriesByType ? window.performance.getEntriesByType("navigation") : [];
    const isBackForward = event.persisted ||
        (navEntries.length > 0 && navEntries[0].type === 'back_forward') ||
        (window.performance && window.performance.navigation && window.performance.navigation.type === 2);

    if (isBackForward) {
        window.location.reload();
    }
});

// Login form submission with SweetAlert2 cooldown delay & feedback
document.addEventListener('DOMContentLoaded', function () {
    const flashSuccess = document.body.dataset.flashSuccess;
    if (flashSuccess && typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: flashSuccess,
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end',
            timerProgressBar: true
        });
    }

    const loginForm = document.querySelector('#login-form-panel form');
    if (loginForm) {
        let isLoggingIn = false;
        loginForm.addEventListener('submit', function (e) {
            if (isLoggingIn) return;
            e.preventDefault();

            const submitBtn = loginForm.querySelector('button[type="submit"]');
            const emailInput = document.getElementById('login-email');
            const passInput = document.getElementById('login-password');

            if (!emailInput || !emailInput.value.trim() || !passInput || !passInput.value) {
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
            }

            const formData = new FormData(loginForm);

            fetch(loginForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const data = await response.json().catch(() => ({}));
                if (response.ok && data.success) {
                    isLoggingIn = true;
                    try { localStorage.removeItem('tb_logged_out'); } catch (e) {}

                    let timerInterval;
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        html: 'Selamat datang kembali! Mengalihkan ke dashboard dalam <b></b> detik...',
                        timer: 1500,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            const b = Swal.getPopup().querySelector('b');
                            timerInterval = setInterval(() => {
                                if (b) b.textContent = Math.ceil(Swal.getTimerLeft() / 1000) || 1;
                            }, 100);
                        },
                        willClose: () => {
                            clearInterval(timerInterval);
                        }
                    }).then(() => {
                        window.location.href = data.redirect || document.body.dataset.dashboardUrl || '/dashboard';
                    });
                } else {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    let errorMsg = 'Username atau password yang Anda masukkan salah!';
                    if (data.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        if (firstKey && data.errors[firstKey][0]) {
                            errorMsg = data.errors[firstKey][0];
                        }
                    } else if (data.message) {
                        errorMsg = data.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal',
                        text: errorMsg,
                        confirmButtonColor: '#466967',
                        confirmButtonText: 'Coba Lagi'
                    });
                }
            })
            .catch(() => {
                isLoggingIn = true;
                loginForm.submit();
            });
        });
    }
});

import { initPhoneAutoFormat } from '../utils/phone-format';

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => initPhoneAutoFormat());
} else {
    initPhoneAutoFormat();
}

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

    if (typeof renderLoginThrottleUI === 'function') {
        renderLoginThrottleUI();
    }
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

function showLoginSuccessModal(redirectUrl = null) {
    const isEn = (localStorage.getItem('toon_lang') === 'en');
    const targetUrl = redirectUrl || document.body.dataset.dashboardUrl || '/dashboard';

    return Swal.fire({
        html: `
            <div class="tb-popup-content">
                <div class="tb-popup-icon-wrap">
                    <div class="tb-popup-icon-box">
                        <!-- Scalloped Badge (Green) -->
                        <svg viewBox="0 0 100 100" class="tb-icon-svg tb-badge-success" fill="currentColor">
                            <path d="M 50.0 14.0 A 14 14 0 0 1 71.2 20.9 A 14 14 0 0 1 84.2 38.9 A 14 14 0 0 1 84.2 61.1 A 14 14 0 0 1 71.2 79.1 A 14 14 0 0 1 50.0 86.0 A 14 14 0 0 1 28.8 79.1 A 14 14 0 0 1 15.8 61.1 A 14 14 0 0 1 15.8 38.9 A 14 14 0 0 1 28.8 20.9 A 14 14 0 0 1 50.0 14.0 Z" />
                        </svg>
                        <!-- White Checkmark -->
                        <svg viewBox="0 0 100 100" class="tb-symbol-svg">
                            <path d="M37 51 L46 60 L64 41" fill="none" stroke="#ffffff" stroke-width="6.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
                <h3 class="tb-popup-title">${isEn ? 'Login Successful!' : 'Login Berhasil!'}</h3>
                <p class="tb-popup-desc">
                    ${isEn
                        ? 'Your account has been connected. You will be automatically redirected to the main page.'
                        : 'Akunmu sudah terhubung. Kamu akan diarahkan ke halaman utama secara otomatis.'}
                </p>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: isEn ? 'Continue' : 'Lanjutkan',
        buttonsStyling: false,
        customClass: {
            container: 'tb-auth-swal-container',
            popup: 'tb-auth-popup',
            confirmButton: 'tb-auth-btn-success'
        },
        timer: 2200,
        timerProgressBar: false,
        allowOutsideClick: false
    }).then(() => {
        window.location.href = targetUrl;
    });
}

let _loginLockoutUntil = 0;
let _loginLockoutInterval = null;

function isLoginEn() {
    return (localStorage.getItem('toon_lang') || 'id') === 'en';
}

function extractThrottleSeconds(msg) {
    if (!msg || typeof msg !== 'string') return 0;
    const isThrottle = /too many|terlalu banyak/i.test(msg);
    if (!isThrottle) return 0;
    const match = msg.match(/(\d+)\s*(?:seconds?|detik)/i);
    return match ? parseInt(match[1], 10) : 0;
}

function getThrottlePopupHtml(seconds) {
    const isEn = isLoginEn();
    if (seconds > 0) {
        return isEn
            ? `Too many login attempts. Please try again in <strong>${seconds}</strong> ${seconds === 1 ? 'second' : 'seconds'}.`
            : `Terlalu banyak percobaan login. Silakan coba lagi dalam <strong>${seconds}</strong> detik.`;
    }
    return isEn
        ? 'Cooldown finished. You can try logging in again now.'
        : 'Waktu tunggu selesai. Kamu sudah bisa mencoba login kembali.';
}

function getThrottleInlineHtml(seconds) {
    const isEn = isLoginEn();
    const clockSvg = '<svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>';
    const text = isEn
        ? `Too many login attempts. Try again in ${seconds} ${seconds === 1 ? 'second' : 'seconds'}.`
        : `Terlalu banyak percobaan login. Coba lagi dalam ${seconds} detik.`;
    return `${clockSvg}<span>${text}</span>`;
}

function getRemainingLockoutSeconds() {
    if (!_loginLockoutUntil) return 0;
    return Math.max(0, Math.ceil((_loginLockoutUntil - Date.now()) / 1000));
}

function renderLoginThrottleUI() {
    const remaining = getRemainingLockoutSeconds();
    const timerEl = document.getElementById('login-throttle-timer');
    const popupTextEl = document.getElementById('tb-throttle-popup-text');
    const loginForm = document.querySelector('#login-form-panel form');
    const submitBtn = loginForm ? loginForm.querySelector('button[type="submit"]') : null;

    if (remaining > 0) {
        if (timerEl) {
            timerEl.innerHTML = getThrottleInlineHtml(remaining);
            timerEl.classList.remove('hidden');
            timerEl.classList.add('flex');
        }
        if (popupTextEl) {
            popupTextEl.innerHTML = getThrottlePopupHtml(remaining);
        }
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    } else {
        if (timerEl) {
            timerEl.classList.add('hidden');
            timerEl.classList.remove('flex');
            timerEl.innerHTML = '';
        }
        if (popupTextEl) {
            popupTextEl.innerHTML = getThrottlePopupHtml(0);
        }
        if (submitBtn && _loginLockoutUntil > 0) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
        _loginLockoutUntil = 0;
        if (_loginLockoutInterval) {
            clearInterval(_loginLockoutInterval);
            _loginLockoutInterval = null;
        }
    }
}

function startLoginThrottleCountdown(seconds) {
    if (!seconds || seconds <= 0) return;
    _loginLockoutUntil = Date.now() + seconds * 1000;
    renderLoginThrottleUI();
    if (_loginLockoutInterval) {
        clearInterval(_loginLockoutInterval);
    }
    _loginLockoutInterval = setInterval(renderLoginThrottleUI, 1000);
}

function escapeLoginHtml(str) {
    return String(str ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function showLoginErrorModal(customMsg = null, throttleSeconds = 0) {
    const isEn = isLoginEn();
    const defaultMsg = isEn
        ? "The email or password you entered doesn't match. Please double-check and try again."
        : "Email atau kata sandi yang kamu masukkan belum sesuai. Coba cek dan ulangi lagi ya.";
    const isThrottle = throttleSeconds > 0;
    const descHtml = isThrottle
        ? `<p id="tb-throttle-popup-text" class="tb-popup-desc">${getThrottlePopupHtml(throttleSeconds)}</p>`
        : `<p class="tb-popup-desc">${escapeLoginHtml(customMsg || defaultMsg)}</p>`;

    return Swal.fire({
        html: `
            <div class="tb-popup-content">
                <div class="tb-popup-icon-wrap">
                    <div class="tb-popup-icon-box">
                        <!-- Rounded Red Warning Triangle -->
                        <svg viewBox="0 0 100 100" class="tb-icon-svg tb-triangle-error" fill="currentColor">
                            <path d="M 44.5 24.5 L 19.5 69.5 C 16.5 75 20.5 81.5 27 81.5 L 73 81.5 C 79.5 81.5 83.5 75 80.5 69.5 L 55.5 24.5 C 52.5 19 47.5 19 44.5 24.5 Z" />
                        </svg>
                        <!-- White Exclamation Mark -->
                        <svg viewBox="0 0 100 100" class="tb-symbol-svg">
                            <line x1="50" y1="41" x2="50" y2="58" stroke="#ffffff" stroke-width="6" stroke-linecap="round" />
                            <circle cx="50" cy="70" r="3.2" fill="#ffffff" />
                        </svg>
                    </div>
                </div>
                <h3 class="tb-popup-title">${isEn ? 'Login Failed!' : 'Login Gagal!'}</h3>
                ${descHtml}
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: isEn ? 'Try again' : 'Coba lagi',
        buttonsStyling: false,
        customClass: {
            container: 'tb-auth-swal-container',
            popup: 'tb-auth-popup',
            confirmButton: 'tb-auth-btn-error'
        }
    });
}

// Login form submission with SweetAlert2 cooldown delay & feedback
document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.querySelector('#login-form-panel form');
    if (loginForm) {
        // If server rendered a throttle error alert on initial load, start the live countdown immediately
        const serverAlert = document.querySelector('[role="alert"]');
        if (serverAlert) {
            const initThrottle = extractThrottleSeconds(serverAlert.textContent || '');
            if (initThrottle > 0) {
                startLoginThrottleCountdown(initThrottle);
            }
        }

        let isLoggingIn = false;
        loginForm.addEventListener('submit', function (e) {
            if (isLoggingIn) return;
            e.preventDefault();

            const remaining = getRemainingLockoutSeconds();
            if (remaining > 0) {
                showLoginErrorModal(null, remaining);
                return;
            }

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
                    showLoginSuccessModal(data.redirect);
                } else {
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    }
                    const isEn = isLoginEn();
                    let rawError = null;

                    if (data.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        if (firstKey && data.errors[firstKey][0]) {
                            rawError = data.errors[firstKey][0];
                        }
                    } else if (data.message && !data.message.includes('CSRF')) {
                        rawError = data.message;
                    }

                    const throttleSeconds = extractThrottleSeconds(rawError);
                    if (throttleSeconds > 0) {
                        startLoginThrottleCountdown(throttleSeconds);
                        showLoginErrorModal(null, throttleSeconds);
                    } else {
                        const isGenericAuthError = rawError && /credentials do not match|username, email, atau password/i.test(rawError);
                        const displayMsg = (!isEn && rawError && !isGenericAuthError) ? rawError : null;
                        showLoginErrorModal(displayMsg, 0);
                    }
                }
            })
            .catch(() => {
                isLoggingIn = true;
                loginForm.submit();
            });
        });
    }
});

Object.assign(window, {
    toggleTheme,
    setTheme,
    toggleLanguageDropdown,
    changeLanguage,
    applyLanguage,
    dismissAlert,
    initAutoDismissAlerts,
    switchToRegister,
    switchToLogin,
    togglePasswordVisibility,
    showLoginSuccessModal,
    showLoginErrorModal,
});

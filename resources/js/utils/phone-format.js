const PHONE_INPUT_SELECTOR = 'input[type="tel"], input[name="phone"], input[name="phone_number"], input[name="customer_phone"]';

/**
 * Format local Indonesian mobile numbers (08xxxxxxxxxx -> 08xx-xxxx-xxxx)
 * while leaving international (+...) or unique non-08 formats untouched.
 */
export function formatIndonesianPhone(value) {
    const trimmed = String(value || '').trim();
    if (!trimmed) return '';

    // Keep international numbers (+...) or custom formats intact
    if (trimmed.startsWith('+') || /[^0-9\s-]/.test(trimmed)) {
        return trimmed;
    }

    const digits = trimmed.replace(/\D/g, '');
    if (digits.startsWith('08') && digits.length >= 10 && digits.length <= 13) {
        return `${digits.slice(0, 4)}-${digits.slice(4, 8)}-${digits.slice(8)}`;
    }

    return trimmed;
}

function applyPhoneFormatToInput(input) {
    if (!input || input.type === 'hidden') return;
    const raw = input.value || '';
    const formatted = formatIndonesianPhone(raw);
    if (raw !== formatted) {
        input.value = formatted;
    }
}

export function formatAllPhoneInputs(root = document) {
    if (!root || typeof root.querySelectorAll !== 'function') return;
    root.querySelectorAll(PHONE_INPUT_SELECTOR).forEach((input) => {
        if (input.value) {
            applyPhoneFormatToInput(input);
        }
    });
}

export function initPhoneAutoFormat() {
    formatAllPhoneInputs(document);

    if (window._tbPhoneAutoFormatBound) return;
    window._tbPhoneAutoFormatBound = true;

    // Only format after the user finishes typing (blur) or submits the form
    document.addEventListener('blur', (e) => {
        const target = e.target;
        if (target && target.matches && target.matches(PHONE_INPUT_SELECTOR)) {
            applyPhoneFormatToInput(target);
        }
    }, true);

    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (form && typeof form.querySelectorAll === 'function') {
            formatAllPhoneInputs(form);
        }
    }, true);
}

const PHONE_INPUT_SELECTOR = 'input[type="tel"], input[name="phone"], input[name="phone_number"], input[name="customer_phone"]';

const ALLOWED_CONTROL_KEYS = new Set([
    'Backspace',
    'Delete',
    'Tab',
    'Escape',
    'Enter',
    'ArrowLeft',
    'ArrowRight',
    'ArrowUp',
    'ArrowDown',
    'Home',
    'End',
]);

/**
 * Strip all non-digit characters, then auto-format local Indonesian
 * mobile numbers (08xxxxxxxxxx -> 08xx-xxxx-xxxx).
 */
export function formatIndonesianPhone(value) {
    const digits = String(value || '').replace(/\D/g, '');
    if (!digits) return '';

    if (digits.startsWith('08') && digits.length >= 10 && digits.length <= 13) {
        return `${digits.slice(0, 4)}-${digits.slice(4, 8)}-${digits.slice(8)}`;
    }

    return digits;
}

function configurePhoneInputAttributes(input) {
    if (!input || input.type === 'hidden') return;
    input.setAttribute('inputmode', 'numeric');
    input.setAttribute('pattern', '[0-9]+(-[0-9]+)*');
}

function sanitizeDigitsInInput(input) {
    if (!input || input.type === 'hidden') return;
    configurePhoneInputAttributes(input);

    const raw = input.value || '';
    const maxLen = input.maxLength > 0 ? input.maxLength : 0;
    let digits = raw.replace(/\D/g, '');
    if (maxLen > 0 && digits.length > maxLen) {
        digits = digits.slice(0, maxLen);
    }

    if (raw !== digits) {
        const start = typeof input.selectionStart === 'number' ? input.selectionStart : null;
        let nextCaret = null;
        if (start !== null) {
            nextCaret = raw.slice(0, start).replace(/\D/g, '').length;
            if (maxLen > 0 && nextCaret > maxLen) nextCaret = maxLen;
        }
        input.value = digits;
        if (nextCaret !== null && document.activeElement === input) {
            try {
                input.setSelectionRange(nextCaret, nextCaret);
            } catch (_) {
                // Ignore selection errors on unsupported input types
            }
        }
    }
}

function applyPhoneFormatToInput(input) {
    if (!input || input.type === 'hidden') return;
    configurePhoneInputAttributes(input);

    const raw = input.value || '';
    const formatted = formatIndonesianPhone(raw);
    if (raw !== formatted) {
        input.value = formatted;
    }
}

export function formatAllPhoneInputs(root = document) {
    if (!root || typeof root.querySelectorAll !== 'function') return;
    root.querySelectorAll(PHONE_INPUT_SELECTOR).forEach((input) => {
        configurePhoneInputAttributes(input);
        if (input.value) {
            applyPhoneFormatToInput(input);
        }
    });
}

export function initPhoneAutoFormat() {
    formatAllPhoneInputs(document);

    if (window._tbPhoneAutoFormatBound) return;
    window._tbPhoneAutoFormatBound = true;

    // Strictly block non-digit printable keys while typing
    document.addEventListener('keydown', (e) => {
        const target = e.target;
        if (!target || !target.matches || !target.matches(PHONE_INPUT_SELECTOR) || target.type === 'hidden') return;
        if (e.ctrlKey || e.metaKey || e.altKey) return;
        if (ALLOWED_CONTROL_KEYS.has(e.key)) return;
        if (e.key && e.key.length === 1 && !/^[0-9]$/.test(e.key)) {
            e.preventDefault();
        }
    }, true);

    // Strip any non-digits during live input (covers mobile keyboards & autofill)
    document.addEventListener('input', (e) => {
        const target = e.target;
        if (target && target.matches && target.matches(PHONE_INPUT_SELECTOR)) {
            sanitizeDigitsInInput(target);
        }
    }, true);

    // Sanitize pasted text to digits only
    document.addEventListener('paste', (e) => {
        const target = e.target;
        if (!target || !target.matches || !target.matches(PHONE_INPUT_SELECTOR) || target.type === 'hidden') return;
        const pasted = (e.clipboardData || window.clipboardData)?.getData('text');
        if (typeof pasted !== 'string') return;
        const digitsOnly = pasted.replace(/\D/g, '');
        if (digitsOnly !== pasted) {
            e.preventDefault();
            const start = typeof target.selectionStart === 'number' ? target.selectionStart : target.value.length;
            const end = typeof target.selectionEnd === 'number' ? target.selectionEnd : target.value.length;
            target.value = target.value.slice(0, start) + digitsOnly + target.value.slice(end);
            sanitizeDigitsInInput(target);
        }
    }, true);

    // Auto-format to 08xx-xxxx-xxxx after finishing typing (blur) or submitting
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

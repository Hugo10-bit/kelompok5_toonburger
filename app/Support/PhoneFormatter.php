<?php

namespace App\Support;

class PhoneFormatter
{
    /**
     * Format local Indonesian mobile numbers (08xxxxxxxxxx -> 08xx-xxxx-xxxx)
     * while leaving international (+...) or non-standard phone formats untouched.
     */
    public static function format(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim($value);
        if ($trimmed === '') {
            return null;
        }

        // Preserve international numbers (starting with +) or numbers with letters/special syntax
        if (str_starts_with($trimmed, '+') || preg_match('/[^0-9\s\-]/', $trimmed)) {
            return $trimmed;
        }

        $digits = preg_replace('/\D+/', '', $trimmed) ?? '';

        // Format Indonesian mobile numbers starting with 08 (10-13 digits)
        if (str_starts_with($digits, '08') && strlen($digits) >= 10 && strlen($digits) <= 13) {
            return substr($digits, 0, 4) . '-' . substr($digits, 4, 4) . '-' . substr($digits, 8);
        }

        return $trimmed;
    }
}

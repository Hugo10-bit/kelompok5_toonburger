<?php

namespace App\Support;

class PhoneFormatter
{
    /**
     * Strip non-digits and format local Indonesian mobile numbers (08xxxxxxxxxx -> 08xx-xxxx-xxxx).
     */
    public static function format(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', trim($value)) ?? '';
        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '08') && strlen($digits) >= 10 && strlen($digits) <= 13) {
            return substr($digits, 0, 4) . '-' . substr($digits, 4, 4) . '-' . substr($digits, 8);
        }

        return $digits;
    }
}

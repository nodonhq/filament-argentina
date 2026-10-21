<?php

namespace NodonHq\FilamentArgentina\Support;

/**
 * Argentine phone numbers. Every number is 10 digits once the country code (54), the
 * mobile prefix (9) and the trunk prefix (0) are removed: area code (2 to 4 digits)
 * followed by the subscriber number.
 */
final class Phone
{
    /** The 10 national digits, or null when the input is not an Argentine number. */
    public static function national(mixed $value): ?string
    {
        $raw = is_scalar($value) ? trim((string) $value) : '';
        $digits = Digits::only($raw);
        $international = str_starts_with($raw, '+') || str_starts_with($digits, '00');

        if ($international) {
            $digits = ltrim($digits, '0');

            if (! str_starts_with($digits, '54')) {
                return null;
            }

            $digits = substr($digits, 2);

            if (strlen($digits) === 11 && str_starts_with($digits, '9')) {
                $digits = substr($digits, 1);
            }
        } elseif (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        return preg_match('/^[1-9]\d{9}$/', $digits) === 1 ? $digits : null;
    }

    public static function isValid(mixed $value): bool
    {
        return self::national($value) !== null;
    }

    /** E.164 form. Pass $mobile to add the 9 that mobile numbers need from abroad. */
    public static function e164(mixed $value, bool $mobile = false): ?string
    {
        $national = self::national($value);

        return $national === null ? null : '+54'.($mobile ? '9' : '').$national;
    }
}

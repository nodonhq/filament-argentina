<?php

namespace NodonHq\FilamentArgentina\Support;

/**
 * CUIT / CUIL: 2-digit type prefix, 8-digit number and a modulo 11 check digit.
 */
final class Cuit
{
    /** Prefixes for individuals (CUIL and CUIT of a person). */
    public const PERSON_PREFIXES = ['20', '23', '24', '25', '26', '27'];

    /** Prefixes for legal entities (companies, associations, the state). */
    public const COMPANY_PREFIXES = ['30', '33', '34'];

    private const WEIGHTS = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

    public static function normalize(mixed $value): string
    {
        return Digits::only($value);
    }

    /**
     * Check digit for the first 10 digits, or null when the remainder makes the number
     * unassignable (ARCA then issues the number with a 23/24/33/34 prefix instead).
     */
    public static function checkDigit(string $first10): ?int
    {
        $result = 11 - Digits::weightedSum($first10, self::WEIGHTS) % 11;

        return match ($result) {
            11 => 0,
            10 => null,
            default => $result,
        };
    }

    /**
     * @param  list<string>|null  $prefixes  accepted prefixes (all known ones by default)
     */
    public static function isValid(mixed $value, ?array $prefixes = null): bool
    {
        $digits = self::normalize($value);

        if (strlen($digits) !== 11) {
            return false;
        }

        $prefixes ??= [...self::PERSON_PREFIXES, ...self::COMPANY_PREFIXES];

        if (! in_array(substr($digits, 0, 2), $prefixes, true)) {
            return false;
        }

        return self::checkDigit(substr($digits, 0, 10)) === (int) $digits[10];
    }

    public static function isCompany(mixed $value): bool
    {
        return in_array(substr(self::normalize($value), 0, 2), self::COMPANY_PREFIXES, true);
    }

    /** 20123456786 → 20-12345678-6. Anything that is not 11 digits is returned as is. */
    public static function format(mixed $value): string
    {
        $digits = self::normalize($value);

        if (strlen($digits) !== 11) {
            return is_scalar($value) ? (string) $value : '';
        }

        return substr($digits, 0, 2).'-'.substr($digits, 2, 8).'-'.$digits[10];
    }
}

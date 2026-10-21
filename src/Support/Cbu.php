<?php

namespace CeiboDev\FilamentArgentina\Support;

/**
 * CBU (bank accounts) and CVU (virtual wallets): 22 digits in two blocks, each with a
 * modulo 10 check digit. A CVU is a CBU whose entity code starts with 000.
 */
final class Cbu
{
    private const FIRST_BLOCK_WEIGHTS = [7, 1, 3, 9, 7, 1, 3];

    private const SECOND_BLOCK_WEIGHTS = [3, 9, 7, 1, 3, 9, 7, 1, 3, 9, 7, 1, 3];

    public static function normalize(mixed $value): string
    {
        return Digits::only($value);
    }

    public static function checkDigit(string $digits, bool $firstBlock): int
    {
        $weights = $firstBlock ? self::FIRST_BLOCK_WEIGHTS : self::SECOND_BLOCK_WEIGHTS;

        return (10 - Digits::weightedSum($digits, $weights) % 10) % 10;
    }

    /** Valid CBU or CVU. */
    public static function isValid(mixed $value): bool
    {
        $digits = self::normalize($value);

        if (strlen($digits) !== 22) {
            return false;
        }

        return self::checkDigit(substr($digits, 0, 7), true) === (int) $digits[7]
            && self::checkDigit(substr($digits, 8, 13), false) === (int) $digits[21];
    }

    public static function isCvu(mixed $value): bool
    {
        return self::isValid($value) && str_starts_with(self::normalize($value), '000');
    }

    /** Valid and from a bank (not a virtual wallet). */
    public static function isBankCbu(mixed $value): bool
    {
        return self::isValid($value) && ! str_starts_with(self::normalize($value), '000');
    }

    /** Bank code (first 3 digits), e.g. 011 for Banco de la Nación Argentina. */
    public static function entityCode(mixed $value): ?string
    {
        $digits = self::normalize($value);

        return strlen($digits) === 22 ? substr($digits, 0, 3) : null;
    }

    /** 0110599540000000123457 → 01105995 40000000123457 (the two blocks). */
    public static function format(mixed $value): string
    {
        $digits = self::normalize($value);

        if (strlen($digits) !== 22) {
            return is_scalar($value) ? (string) $value : '';
        }

        return substr($digits, 0, 8).' '.substr($digits, 8);
    }
}

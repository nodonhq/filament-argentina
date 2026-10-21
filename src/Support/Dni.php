<?php

namespace CeiboDev\FilamentArgentina\Support;

/** DNI: 7 or 8 digits, shown with thousands separators (12.345.678). */
final class Dni
{
    public static function normalize(mixed $value): string
    {
        return ltrim(Digits::only($value), '0');
    }

    public static function isValid(mixed $value): bool
    {
        $length = strlen(self::normalize($value));

        return $length === 7 || $length === 8;
    }

    public static function format(mixed $value): string
    {
        if (! self::isValid($value)) {
            return is_scalar($value) ? (string) $value : '';
        }

        return number_format((int) self::normalize($value), 0, '', '.');
    }
}

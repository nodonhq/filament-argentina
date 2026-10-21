<?php

namespace CeiboDev\FilamentArgentina\Support;

/** Amounts in Argentine pesos: $ 1.234.567,89 */
final class Pesos
{
    public static function format(mixed $value, int $decimals = 2, bool $symbol = true): string
    {
        if (! is_numeric($value)) {
            return is_scalar($value) ? (string) $value : '';
        }

        $number = number_format((float) $value, $decimals, ',', '.');

        return $symbol ? '$ '.$number : $number;
    }

    /** "1.234,56" or "$ 1.234,56" → "1234.56". Returns null when it is not a number. */
    public static function parse(mixed $value): ?string
    {
        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        if (! is_string($value)) {
            return null;
        }

        $clean = str_replace(['$', ' ', "\u{a0}", '.'], '', $value);
        $clean = str_replace(',', '.', $clean);

        return is_numeric($clean) ? $clean : null;
    }
}

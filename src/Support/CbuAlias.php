<?php

namespace CeiboDev\FilamentArgentina\Support;

/** Alias of a CBU or CVU: 6 to 20 letters (no ñ or accents), digits, dots or hyphens. */
final class CbuAlias
{
    public static function isValid(mixed $value): bool
    {
        return is_string($value) && preg_match('/^[A-Za-z0-9.\-]{6,20}$/', $value) === 1;
    }
}

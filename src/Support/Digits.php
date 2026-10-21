<?php

namespace CeiboDev\FilamentArgentina\Support;

final class Digits
{
    public static function only(mixed $value): string
    {
        if (! is_scalar($value)) {
            return '';
        }

        return preg_replace('/\D+/', '', (string) $value) ?? '';
    }

    /**
     * Weighted sum of the digits, pairing each digit with the weight at the same position.
     *
     * @param  list<int>  $weights
     */
    public static function weightedSum(string $digits, array $weights): int
    {
        $sum = 0;

        foreach ($weights as $i => $weight) {
            $sum += (int) $digits[$i] * $weight;
        }

        return $sum;
    }
}

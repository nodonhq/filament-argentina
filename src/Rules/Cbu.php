<?php

namespace CeiboDev\FilamentArgentina\Rules;

use CeiboDev\FilamentArgentina\Support\Cbu as CbuNumber;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** Valid CBU or CVU (both check digits). Use cbuOnly() or cvuOnly() to restrict it. */
final class Cbu implements ValidationRule
{
    protected ?bool $cvu = null;

    public static function make(): static
    {
        return new self;
    }

    /** Only bank accounts. */
    public function cbuOnly(): static
    {
        $this->cvu = false;

        return $this;
    }

    /** Only virtual wallets (CVU). */
    public function cvuOnly(): static
    {
        $this->cvu = true;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $valid = match ($this->cvu) {
            null => CbuNumber::isValid($value),
            true => CbuNumber::isCvu($value),
            false => CbuNumber::isBankCbu($value),
        };

        if (! $valid) {
            $key = match ($this->cvu) {
                null => 'cbu_or_cvu',
                true => 'cvu',
                false => 'cbu',
            };
            $fail("filament-argentina::validation.{$key}")->translate();
        }
    }
}

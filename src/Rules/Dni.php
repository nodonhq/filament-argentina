<?php

namespace CeiboDev\FilamentArgentina\Rules;

use CeiboDev\FilamentArgentina\Support\Dni as DniNumber;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** DNI of 7 or 8 digits. Accepts dots and spaces. */
class Dni implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! DniNumber::isValid($value)) {
            $fail('filament-argentina::validation.dni')->translate();
        }
    }
}

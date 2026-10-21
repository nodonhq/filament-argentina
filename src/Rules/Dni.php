<?php

namespace NodonHq\FilamentArgentina\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NodonHq\FilamentArgentina\Support\Dni as DniNumber;

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

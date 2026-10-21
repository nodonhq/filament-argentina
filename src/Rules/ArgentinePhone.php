<?php

namespace NodonHq\FilamentArgentina\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NodonHq\FilamentArgentina\Support\Phone;

/** Argentine phone number with area code (national or +54 format). */
class ArgentinePhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Phone::isValid($value)) {
            $fail('filament-argentina::validation.phone')->translate();
        }
    }
}

<?php

namespace CeiboDev\FilamentArgentina\Rules;

use CeiboDev\FilamentArgentina\Support\Phone;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

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

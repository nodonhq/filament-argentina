<?php

namespace NodonHq\FilamentArgentina\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NodonHq\FilamentArgentina\Support\Pesos;

/** Amount written the Argentine way (1.234,56), with or without the $ sign. */
class PesosAmount implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Pesos::parse($value) === null) {
            $fail('filament-argentina::validation.pesos')->translate();
        }
    }
}

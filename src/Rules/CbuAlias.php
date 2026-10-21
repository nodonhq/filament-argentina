<?php

namespace NodonHq\FilamentArgentina\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use NodonHq\FilamentArgentina\Support\CbuAlias as Alias;

class CbuAlias implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Alias::isValid($value)) {
            $fail('filament-argentina::validation.cbu_alias')->translate();
        }
    }
}

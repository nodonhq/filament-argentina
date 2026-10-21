<?php

namespace CeiboDev\FilamentArgentina\Rules;

use CeiboDev\FilamentArgentina\Support\CbuAlias as Alias;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CbuAlias implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! Alias::isValid($value)) {
            $fail('filament-argentina::validation.cbu_alias')->translate();
        }
    }
}

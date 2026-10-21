<?php

namespace CeiboDev\FilamentArgentina\Rules;

use CeiboDev\FilamentArgentina\Support\Cuit as CuitNumber;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** Valid CUIT / CUIL (check digit and type prefix). Accepts hyphens, dots and spaces. */
final class Cuit implements ValidationRule
{
    /** @var list<string>|null */
    protected ?array $prefixes = null;

    public static function make(): static
    {
        return new self;
    }

    /** Only individuals (CUIL, or the CUIT of a person). */
    public function person(): static
    {
        $this->prefixes = CuitNumber::PERSON_PREFIXES;

        return $this;
    }

    /** Only legal entities. */
    public function company(): static
    {
        $this->prefixes = CuitNumber::COMPANY_PREFIXES;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! CuitNumber::isValid($value, $this->prefixes)) {
            $fail('filament-argentina::validation.cuit')->translate();
        }
    }
}

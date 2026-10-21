<?php

namespace NodonHq\FilamentArgentina\Forms\Concerns;

use Illuminate\Support\Str;

trait KeepsAcronymLabels
{
    /** Filament lowercases the first letter of the label ("cUIT"): keep acronyms as written. */
    public function getValidationAttribute(): string
    {
        $attribute = parent::getValidationAttribute();
        $label = $this->getLabel();

        if (is_string($label) && $attribute === Str::lcfirst($label) && preg_match('/^\p{Lu}{2}/u', $label) === 1) {
            return $label;
        }

        return $attribute;
    }
}

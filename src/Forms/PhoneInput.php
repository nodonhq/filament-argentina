<?php

namespace NodonHq\FilamentArgentina\Forms;

use Filament\Forms\Components\TextInput;
use NodonHq\FilamentArgentina\Rules\ArgentinePhone;
use NodonHq\FilamentArgentina\Support\Phone;

/**
 * Argentine phone number with area code. Stores the 10 national digits, or the E.164 form
 * with e164() (add mobile: true for the 9 that WhatsApp and SMS need).
 */
class PhoneInput extends TextInput
{
    protected ?bool $e164Mobile = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->type('tel');
        $this->autocomplete('tel');
        $this->placeholder('11 1234-5678');
        $this->prefix('+54');
        $this->rule(new ArgentinePhone);
        $this->formatStateUsing(static fn (mixed $state): mixed => Phone::national($state) ?? $state);
        $this->dehydrateStateUsing(static fn (mixed $state, PhoneInput $component): ?string => blank($state)
            ? null
            : ($component->e164Mobile === null ? Phone::national($state) : Phone::e164($state, $component->e164Mobile)));
    }

    public function e164(bool $mobile = false): static
    {
        $this->e164Mobile = $mobile;

        return $this;
    }
}

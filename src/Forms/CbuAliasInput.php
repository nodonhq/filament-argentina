<?php

namespace NodonHq\FilamentArgentina\Forms;

use Filament\Forms\Components\TextInput;
use NodonHq\FilamentArgentina\Rules\CbuAlias;

/** Alias of a CBU or CVU (for example mi.alias.mp). */
class CbuAliasInput extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->maxLength(20);
        $this->placeholder('mi.alias.banco');
        $this->autocomplete(false);
        $this->rule(new CbuAlias);
        $this->dehydrateStateUsing(static fn (mixed $state): ?string => is_string($state) && filled($state) ? trim($state) : null);
    }
}

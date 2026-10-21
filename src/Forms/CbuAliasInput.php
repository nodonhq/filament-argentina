<?php

namespace CeiboDev\FilamentArgentina\Forms;

use CeiboDev\FilamentArgentina\Rules\CbuAlias;
use Filament\Forms\Components\TextInput;

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

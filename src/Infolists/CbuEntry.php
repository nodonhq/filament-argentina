<?php

namespace CeiboDev\FilamentArgentina\Infolists;

use CeiboDev\FilamentArgentina\Support\Cbu;
use Filament\Infolists\Components\TextEntry;

/** Shows a CBU / CVU as two blocks. */
class CbuEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cbu::format($state));
    }
}

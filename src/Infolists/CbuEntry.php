<?php

namespace NodonHq\FilamentArgentina\Infolists;

use Filament\Infolists\Components\TextEntry;
use NodonHq\FilamentArgentina\Support\Cbu;

/** Shows a CBU / CVU as two blocks. */
class CbuEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cbu::format($state));
    }
}

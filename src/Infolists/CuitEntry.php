<?php

namespace NodonHq\FilamentArgentina\Infolists;

use Filament\Infolists\Components\TextEntry;
use NodonHq\FilamentArgentina\Support\Cuit;

/** Shows a CUIT / CUIL as 20-12345678-6. */
class CuitEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cuit::format($state));
    }
}

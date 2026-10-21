<?php

namespace CeiboDev\FilamentArgentina\Infolists;

use CeiboDev\FilamentArgentina\Support\Cuit;
use Filament\Infolists\Components\TextEntry;

/** Shows a CUIT / CUIL as 20-12345678-6. */
class CuitEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cuit::format($state));
    }
}

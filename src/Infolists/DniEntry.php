<?php

namespace NodonHq\FilamentArgentina\Infolists;

use Filament\Infolists\Components\TextEntry;
use NodonHq\FilamentArgentina\Support\Dni;

/** Shows a DNI as 12.345.678. */
class DniEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Dni::format($state));
    }
}

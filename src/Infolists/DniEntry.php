<?php

namespace CeiboDev\FilamentArgentina\Infolists;

use CeiboDev\FilamentArgentina\Support\Dni;
use Filament\Infolists\Components\TextEntry;

/** Shows a DNI as 12.345.678. */
class DniEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Dni::format($state));
    }
}

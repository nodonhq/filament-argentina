<?php

namespace NodonHq\FilamentArgentina\Infolists;

use Filament\Infolists\Components\TextEntry;
use NodonHq\FilamentArgentina\Support\Pesos;

/** Shows an amount as $ 1.234,56. */
class PesosEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Pesos::format($state));
    }
}

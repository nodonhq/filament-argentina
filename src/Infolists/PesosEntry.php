<?php

namespace CeiboDev\FilamentArgentina\Infolists;

use CeiboDev\FilamentArgentina\Support\Pesos;
use Filament\Infolists\Components\TextEntry;

/** Shows an amount as $ 1.234,56. */
class PesosEntry extends TextEntry
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Pesos::format($state));
    }
}

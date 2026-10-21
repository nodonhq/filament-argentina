<?php

namespace CeiboDev\FilamentArgentina\Tables;

use CeiboDev\FilamentArgentina\Support\Pesos;
use Filament\Tables\Columns\TextColumn;

/** Shows an amount as $ 1.234,56, right aligned. */
class PesosColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Pesos::format($state));
        $this->alignEnd();
    }
}

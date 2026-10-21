<?php

namespace NodonHq\FilamentArgentina\Tables;

use Filament\Tables\Columns\TextColumn;
use NodonHq\FilamentArgentina\Support\Cuit;

/** Shows a CUIT / CUIL as 20-12345678-6. */
class CuitColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cuit::format($state));
    }
}

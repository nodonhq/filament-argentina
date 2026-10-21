<?php

namespace NodonHq\FilamentArgentina\Tables;

use Filament\Tables\Columns\TextColumn;
use NodonHq\FilamentArgentina\Support\Cbu;

/** Shows a CBU / CVU as two blocks. */
class CbuColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cbu::format($state));
    }
}

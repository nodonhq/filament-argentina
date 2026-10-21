<?php

namespace NodonHq\FilamentArgentina\Tables;

use Filament\Tables\Columns\TextColumn;
use NodonHq\FilamentArgentina\Support\Dni;

/** Shows a DNI as 12.345.678. */
class DniColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Dni::format($state));
    }
}

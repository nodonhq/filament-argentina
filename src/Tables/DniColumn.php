<?php

namespace CeiboDev\FilamentArgentina\Tables;

use CeiboDev\FilamentArgentina\Support\Dni;
use Filament\Tables\Columns\TextColumn;

/** Shows a DNI as 12.345.678. */
class DniColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Dni::format($state));
    }
}

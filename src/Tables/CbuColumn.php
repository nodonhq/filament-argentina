<?php

namespace CeiboDev\FilamentArgentina\Tables;

use CeiboDev\FilamentArgentina\Support\Cbu;
use Filament\Tables\Columns\TextColumn;

/** Shows a CBU / CVU as two blocks. */
class CbuColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(static fn (mixed $state): string => Cbu::format($state));
    }
}

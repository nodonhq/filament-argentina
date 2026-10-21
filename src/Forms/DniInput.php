<?php

namespace CeiboDev\FilamentArgentina\Forms;

use CeiboDev\FilamentArgentina\Rules\Dni as DniRule;
use CeiboDev\FilamentArgentina\Support\Dni;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

/** DNI with thousands separators (12.345.678). Stores only the digits unless storeFormatted(). */
class DniInput extends TextInput
{
    use Concerns\CanStoreFormatted;
    use Concerns\KeepsAcronymLabels;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mask(RawJs::make(<<<'JS'
            $input.replace(/\D/g, '').length > 7 ? '99.999.999' : '9.999.999'
        JS));
        $this->placeholder('12.345.678');
        $this->inputMode('numeric');
        $this->rule(new DniRule);
        $this->formatStateUsing(static fn (mixed $state): mixed => blank($state) ? $state : Dni::format($state));
        $this->dehydrateStateUsing(static fn (mixed $state, DniInput $component): ?string => blank($state)
            ? null
            : ($component->shouldStoreFormatted() ? Dni::format($state) : Dni::normalize($state)));
    }
}

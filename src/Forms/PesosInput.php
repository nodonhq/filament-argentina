<?php

namespace NodonHq\FilamentArgentina\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use NodonHq\FilamentArgentina\Rules\PesosAmount;
use NodonHq\FilamentArgentina\Support\Pesos;

/** Amount in pesos typed as 1.234,56. Stores a plain decimal string ("1234.56"). */
class PesosInput extends TextInput
{
    protected int $decimals = 2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prefix('$');
        $this->inputMode('decimal');
        $this->mask(static fn (PesosInput $component): RawJs => RawJs::make(
            "\$money(\$input, ',', '.', {$component->decimals})"
        ));
        $this->rule(new PesosAmount);
        $this->formatStateUsing(static fn (mixed $state, PesosInput $component): mixed => is_numeric($state)
            ? Pesos::format($state, $component->decimals, symbol: false)
            : $state);
        $this->dehydrateStateUsing(static fn (mixed $state): ?string => blank($state) ? null : Pesos::parse($state));
    }

    public function decimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }
}

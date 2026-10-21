<?php

namespace NodonHq\FilamentArgentina\Forms;

use Filament\Forms\Components\TextInput;
use NodonHq\FilamentArgentina\Rules\Cbu as CbuRule;
use NodonHq\FilamentArgentina\Support\Cbu;

/** CBU or CVU (22 digits, shown as two blocks). Stores only the digits unless storeFormatted(). */
class CbuInput extends TextInput
{
    use Concerns\CanStoreFormatted;
    use Concerns\KeepsAcronymLabels;

    protected ?bool $cvu = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mask('99999999 99999999999999');
        $this->inputMode('numeric');
        $this->rule(static fn (CbuInput $component): CbuRule => match ($component->cvu) {
            true => CbuRule::make()->cvuOnly(),
            false => CbuRule::make()->cbuOnly(),
            null => CbuRule::make(),
        });
        $this->formatStateUsing(static fn (mixed $state): mixed => blank($state) ? $state : Cbu::format($state));
        $this->dehydrateStateUsing(static fn (mixed $state, CbuInput $component): ?string => blank($state)
            ? null
            : ($component->shouldStoreFormatted() ? Cbu::format($state) : Cbu::normalize($state)));
    }

    /** Only accept bank accounts. */
    public function cbuOnly(): static
    {
        $this->cvu = false;

        return $this;
    }

    /** Only accept virtual wallets. */
    public function cvuOnly(): static
    {
        $this->cvu = true;

        return $this;
    }
}

<?php

namespace CeiboDev\FilamentArgentina\Forms;

use CeiboDev\FilamentArgentina\Rules\Cuit as CuitRule;
use CeiboDev\FilamentArgentina\Support\Cuit;
use Filament\Forms\Components\TextInput;

/** CUIT / CUIL with a 99-99999999-9 mask. Stores only the 11 digits unless storeFormatted(). */
class CuitInput extends TextInput
{
    use Concerns\CanStoreFormatted;
    use Concerns\KeepsAcronymLabels;

    protected ?string $kind = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mask('99-99999999-9');
        $this->placeholder('20-12345678-6');
        $this->inputMode('numeric');
        $this->rule(static fn (CuitInput $component): CuitRule => match ($component->kind) {
            'person' => CuitRule::make()->person(),
            'company' => CuitRule::make()->company(),
            default => CuitRule::make(),
        });
        $this->formatStateUsing(static fn (mixed $state): mixed => blank($state) ? $state : Cuit::format($state));
        $this->dehydrateStateUsing(static fn (mixed $state, CuitInput $component): ?string => blank($state)
            ? null
            : ($component->shouldStoreFormatted() ? Cuit::format($state) : Cuit::normalize($state)));
    }

    /** Only accept individuals (CUIL, or the CUIT of a person). */
    public function person(): static
    {
        $this->kind = 'person';

        return $this;
    }

    /** Only accept legal entities. */
    public function company(): static
    {
        $this->kind = 'company';

        return $this;
    }
}

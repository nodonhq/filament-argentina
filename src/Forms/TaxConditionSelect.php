<?php

namespace NodonHq\FilamentArgentina\Forms;

use Filament\Forms\Components\Select;
use NodonHq\FilamentArgentina\Enums\TaxCondition;

/** VAT condition, stored with ARCA's id (1 = Responsable Inscripto, 5 = Consumidor Final, ...). */
class TaxConditionSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(TaxCondition::class);
    }
}

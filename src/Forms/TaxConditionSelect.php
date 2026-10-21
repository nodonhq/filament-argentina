<?php

namespace CeiboDev\FilamentArgentina\Forms;

use CeiboDev\FilamentArgentina\Enums\TaxCondition;
use Filament\Forms\Components\Select;

/** VAT condition, stored with ARCA's id (1 = Responsable Inscripto, 5 = Consumidor Final, ...). */
class TaxConditionSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(TaxCondition::class);
    }
}

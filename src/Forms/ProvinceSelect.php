<?php

namespace CeiboDev\FilamentArgentina\Forms;

use CeiboDev\FilamentArgentina\Enums\Province;
use Filament\Forms\Components\Select;

/** The 24 jurisdictions. Stores the ISO 3166-2 code (AR-C, AR-B, ...). */
class ProvinceSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->options(Province::class);
        $this->searchable();
    }
}

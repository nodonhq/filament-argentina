<?php

namespace NodonHq\FilamentArgentina\Tests\Feature;

use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Livewire\Component;
use Livewire\Livewire;
use NodonHq\FilamentArgentina\Enums\Province;
use NodonHq\FilamentArgentina\Enums\TaxCondition;
use NodonHq\FilamentArgentina\Forms\CbuInput;
use NodonHq\FilamentArgentina\Forms\CuitInput;
use NodonHq\FilamentArgentina\Forms\DniInput;
use NodonHq\FilamentArgentina\Forms\PesosInput;
use NodonHq\FilamentArgentina\Forms\PhoneInput;
use NodonHq\FilamentArgentina\Forms\ProvinceSelect;
use NodonHq\FilamentArgentina\Forms\TaxConditionSelect;
use NodonHq\FilamentArgentina\Tests\TestCase;

class FormTest extends TestCase
{
    public function test_fields_store_digits_and_validate(): void
    {
        Livewire::test(CustomerForm::class)
            ->fillForm([
                'cuit' => '20-12345678-6',
                'dni' => '12.345.678',
                'cbu' => '01105995 40000000123457',
                'phone' => '+54 9 11 2345-6789',
                'amount' => '1.234,56',
                'province' => 'AR-X',
                'tax' => 5,
            ])
            ->call('save')
            ->assertHasNoFormErrors()
            ->assertSet('saved', [
                'cuit' => '20123456786',
                'cuit_formatted' => null,
                'dni' => '12345678',
                'cbu' => '0110599540000000123457',
                'phone' => '1123456789',
                'amount' => '1234.56',
                'province' => Province::Cordoba,
                'tax' => TaxCondition::ConsumidorFinal,
            ]);
    }

    public function test_invalid_values_show_errors(): void
    {
        Livewire::test(CustomerForm::class)
            ->fillForm(['cuit' => '20-12345678-5', 'dni' => '123', 'cbu' => '1234', 'phone' => '12', 'amount' => 'x'])
            ->call('save')
            ->assertHasFormErrors(['cuit', 'dni', 'cbu', 'phone', 'amount']);
    }

    public function test_stored_values_are_shown_formatted(): void
    {
        Livewire::test(CustomerForm::class, ['record' => [
            'cuit' => '20123456786',
            'dni' => '12345678',
            'cbu' => '0110599540000000123457',
            'amount' => '1234.5',
        ]])
            ->assertSet('data.cuit', '20-12345678-6')
            ->assertSet('data.dni', '12.345.678')
            ->assertSet('data.cbu', '01105995 40000000123457')
            ->assertSet('data.amount', '1.234,50');
    }

    public function test_acronym_labels_keep_their_case_in_messages(): void
    {
        $this->app?->setLocale('es');

        Livewire::test(CustomerForm::class)
            ->fillForm(['cuit' => '1'])
            ->call('save')
            ->assertSee('El campo CUIT no es un CUIT/CUIL válido.');
    }

    public function test_store_formatted(): void
    {
        Livewire::test(CustomerForm::class)
            ->fillForm(['cuit_formatted' => '20123456786'])
            ->call('save')
            ->assertSet('saved.cuit_formatted', '20-12345678-6');
    }
}

class CustomerForm extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    /** @var array<string, mixed>|null */
    public ?array $data = [];

    /** @var array<string, mixed>|null */
    public ?array $saved = null;

    /** @param  array<string, mixed>  $record */
    public function mount(array $record = []): void
    {
        $this->form->fill($record);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                CuitInput::make('cuit')->label('CUIT'),
                CuitInput::make('cuit_formatted')->storeFormatted(),
                DniInput::make('dni'),
                CbuInput::make('cbu'),
                PhoneInput::make('phone'),
                PesosInput::make('amount'),
                ProvinceSelect::make('province'),
                TaxConditionSelect::make('tax'),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $this->saved = $this->form->getState();
    }

    public function render(): string
    {
        return '<div>{{ $this->form }}</div>';
    }
}

# Argentine fields for Filament

Form fields, table columns, infolist entries and validation rules for the data every Argentine app asks for: **CUIT/CUIL, DNI, CBU/CVU, alias, phone numbers, amounts in pesos, provinces and VAT condition**.

- Real validation: CUIT and CBU check digits, not just a regex.
- Typing masks (`20-12345678-6`, `12.345.678`, `$ 1.234,56`).
- Stores clean values (only digits, plain decimals) and shows them formatted.
- The validation rules also work in plain Laravel, without Filament.
- Messages in Spanish and English.

Requires PHP 8.3+ and Filament 5.

## Installation

```bash
composer require ceibo-dev/filament-argentina
```

## Form fields

```php
use CeiboDev\FilamentArgentina\Forms\CbuAliasInput;
use CeiboDev\FilamentArgentina\Forms\CbuInput;
use CeiboDev\FilamentArgentina\Forms\CuitInput;
use CeiboDev\FilamentArgentina\Forms\DniInput;
use CeiboDev\FilamentArgentina\Forms\PesosInput;
use CeiboDev\FilamentArgentina\Forms\PhoneInput;
use CeiboDev\FilamentArgentina\Forms\ProvinceSelect;
use CeiboDev\FilamentArgentina\Forms\TaxConditionSelect;

CuitInput::make('cuit')->label('CUIT'),            // stores 20123456786
CuitInput::make('cuit')->company(),                // only legal entities (30, 33, 34)
CuitInput::make('cuil')->person(),                 // only individuals
DniInput::make('dni'),                             // stores 12345678
CbuInput::make('cbu'),                             // CBU or CVU, stores the 22 digits
CbuInput::make('cvu')->cvuOnly(),                  // or ->cbuOnly()
CbuAliasInput::make('alias'),
PhoneInput::make('phone'),                         // stores 1123456789
PhoneInput::make('whatsapp')->e164(mobile: true),  // stores +5491123456789
PesosInput::make('price'),                         // typed 1.234,56, stores "1234.56"
ProvinceSelect::make('province'),                  // stores the ISO 3166-2 code (AR-X)
TaxConditionSelect::make('tax_condition'),         // stores ARCA's id (5 = Consumidor Final)
```

To keep the separators in the database, add `->storeFormatted()` to the CUIT, DNI or CBU fields.

| Field | Mask / input | Stored value | Validation |
|---|---|---|---|
| `CuitInput` | `99-99999999-9` | `20123456786` | prefix and modulo 11 check digit |
| `DniInput` | `9.999.999` / `99.999.999` | `12345678` | 7 or 8 digits |
| `CbuInput` | `99999999 99999999999999` | 22 digits | both check digits; CBU, CVU or either |
| `CbuAliasInput` | max. 20 chars | as typed | 6–20 letters, digits, `.` or `-` |
| `PhoneInput` | `+54` prefix | 10 national digits or E.164 | area code + number |
| `PesosInput` | `$ 1.234,56` | `"1234.56"` | amount |
| `ProvinceSelect` | 24 jurisdictions | `AR-C`, `AR-B`, ... | enum |
| `TaxConditionSelect` | ARCA list | `1`, `4`, `5`, `6`, ... | enum |

## Table columns and infolist entries

```php
use CeiboDev\FilamentArgentina\Tables\CbuColumn;
use CeiboDev\FilamentArgentina\Tables\CuitColumn;
use CeiboDev\FilamentArgentina\Tables\DniColumn;
use CeiboDev\FilamentArgentina\Tables\PesosColumn;

CuitColumn::make('cuit'),       // 20-12345678-6
DniColumn::make('dni'),         // 12.345.678
CbuColumn::make('cbu'),         // 01105995 40000000123457
PesosColumn::make('price'),     // $ 1.234,56 (right aligned)
```

The same exist for infolists in `CeiboDev\FilamentArgentina\Infolists`: `CuitEntry`, `DniEntry`, `CbuEntry` and `PesosEntry`.

For provinces and VAT condition, cast the attribute to the enum and use a regular `TextColumn`: it shows the label.

```php
protected function casts(): array
{
    return [
        'province' => \CeiboDev\FilamentArgentina\Enums\Province::class,
        'tax_condition' => \CeiboDev\FilamentArgentina\Enums\TaxCondition::class,
    ];
}
```

## Validation rules (Laravel, no Filament needed)

```php
use CeiboDev\FilamentArgentina\Rules\ArgentinePhone;
use CeiboDev\FilamentArgentina\Rules\Cbu;
use CeiboDev\FilamentArgentina\Rules\CbuAlias;
use CeiboDev\FilamentArgentina\Rules\Cuit;
use CeiboDev\FilamentArgentina\Rules\Dni;
use CeiboDev\FilamentArgentina\Rules\PesosAmount;

$request->validate([
    'cuit' => ['required', new Cuit],
    'company_cuit' => ['required', Cuit::make()->company()],
    'dni' => [new Dni],
    'cbu' => [new Cbu],
    'cvu' => [Cbu::make()->cvuOnly()],
    'alias' => [new CbuAlias],
    'phone' => [new ArgentinePhone],
    'amount' => [new PesosAmount],
]);
```

The checks behind them are available as plain helpers in `CeiboDev\FilamentArgentina\Support` (`Cuit::isValid()`, `Cuit::format()`, `Cbu::isCvu()`, `Phone::e164()`, `Pesos::parse()`, ...).

## Translations

Messages come in Spanish (`es`) and English (`en`) and follow the app locale. To change them:

```bash
php artisan vendor:publish --tag=filament-argentina-translations
```

## Notes and limits

- Phone numbers must include the area code. The old mobile format with `15` (`011 15 1234-5678`) is not accepted: use `11 1234-5678` or `+54 9 11 1234-5678`.
- The CUIT check is offline: it verifies the number is well formed, not that it is registered with ARCA.
- CUIT prefixes accepted by default: 20, 23, 24, 25, 26, 27 (individuals) and 30, 33, 34 (legal entities).

## Testing

```bash
composer test
composer analyse
```

## License

MIT. See [LICENSE.md](LICENSE.md).

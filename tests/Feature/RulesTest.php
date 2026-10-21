<?php

namespace NodonHq\FilamentArgentina\Tests\Feature;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;
use NodonHq\FilamentArgentina\Rules\ArgentinePhone;
use NodonHq\FilamentArgentina\Rules\Cbu;
use NodonHq\FilamentArgentina\Rules\CbuAlias;
use NodonHq\FilamentArgentina\Rules\Cuit;
use NodonHq\FilamentArgentina\Rules\Dni;
use NodonHq\FilamentArgentina\Tests\TestCase;

class RulesTest extends TestCase
{
    private function passes(ValidationRule $rule, mixed $value): bool
    {
        return Validator::make(['field' => $value], ['field' => [$rule]])->passes();
    }

    public function test_rules_work_in_plain_laravel_validation(): void
    {
        $this->assertTrue($this->passes(new Cuit, '20-12345678-6'));
        $this->assertFalse($this->passes(new Cuit, '20-12345678-5'));
        $this->assertFalse($this->passes(Cuit::make()->person(), '33-69345023-9'));
        $this->assertTrue($this->passes(Cuit::make()->company(), '33-69345023-9'));
        $this->assertTrue($this->passes(new Dni, '12.345.678'));
        $this->assertTrue($this->passes(new Cbu, '0000003110000000000014'));
        $this->assertFalse($this->passes(Cbu::make()->cbuOnly(), '0000003110000000000014'));
        $this->assertTrue($this->passes(Cbu::make()->cvuOnly(), '0000003110000000000014'));
        $this->assertTrue($this->passes(new CbuAlias, 'mi.alias.mp'));
        $this->assertTrue($this->passes(new ArgentinePhone, '+54 9 11 2345-6789'));
    }

    public function test_messages_are_translated(): void
    {
        $this->app->setLocale('es');
        $validator = Validator::make(['cuit' => '1'], ['cuit' => [new Cuit]]);
        $this->assertSame('El campo cuit no es un CUIT/CUIL válido.', $validator->errors()->first('cuit'));

        $this->app->setLocale('en');
        $validator = Validator::make(['cbu' => '1'], ['cbu' => [Cbu::make()->cvuOnly()]]);
        $this->assertSame('The cbu is not a valid CVU.', $validator->errors()->first('cbu'));
    }
}

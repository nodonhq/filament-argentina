<?php

namespace CeiboDev\FilamentArgentina\Tests\Unit;

use CeiboDev\FilamentArgentina\Enums\Province;
use CeiboDev\FilamentArgentina\Support\CbuAlias;
use CeiboDev\FilamentArgentina\Support\Dni;
use CeiboDev\FilamentArgentina\Support\Pesos;
use CeiboDev\FilamentArgentina\Support\Phone;
use PHPUnit\Framework\TestCase;

class OtherFieldsTest extends TestCase
{
    public function test_dni(): void
    {
        $this->assertTrue(Dni::isValid('12.345.678'));
        $this->assertTrue(Dni::isValid('1234567'));
        $this->assertFalse(Dni::isValid('123456'));
        $this->assertFalse(Dni::isValid('123456789'));
        $this->assertFalse(Dni::isValid('00123456'));
        $this->assertSame('12.345.678', Dni::format('12345678'));
        $this->assertSame('1.234.567', Dni::format('1234567'));
        $this->assertSame('12345678', Dni::normalize('12.345.678'));
    }

    public function test_alias(): void
    {
        $this->assertTrue(CbuAlias::isValid('mi.alias.mp'));
        $this->assertTrue(CbuAlias::isValid('CASA-PERRO-01'));
        $this->assertFalse(CbuAlias::isValid('corto'));
        $this->assertFalse(CbuAlias::isValid('un.alias.demasiado.largo'));
        $this->assertFalse(CbuAlias::isValid('año.nuevo.ok'));
        $this->assertFalse(CbuAlias::isValid('con espacio'));
    }

    public function test_phone(): void
    {
        $this->assertSame('1123456789', Phone::national('11 2345-6789'));
        $this->assertSame('1123456789', Phone::national('011 2345-6789'));
        $this->assertSame('1123456789', Phone::national('+54 9 11 2345-6789'));
        $this->assertSame('1123456789', Phone::national('+54 11 2345-6789'));
        $this->assertSame('2214567890', Phone::national('0054 221 456-7890'));
        $this->assertSame('2966123456', Phone::national('(02966) 12-3456'));
        $this->assertNull(Phone::national('+598 99 123 456'));
        $this->assertNull(Phone::national('1234'));
        $this->assertNull(Phone::national('0112345678'));
        $this->assertSame('+5491123456789', Phone::e164('11 2345-6789', mobile: true));
        $this->assertSame('+541123456789', Phone::e164('011 2345-6789'));
    }

    public function test_pesos(): void
    {
        $this->assertSame('$ 1.234.567,89', Pesos::format(1234567.891));
        $this->assertSame('1.234,50', Pesos::format('1234.5', symbol: false));
        $this->assertSame('$ -15,00', Pesos::format(-15));
        $this->assertSame('1234.56', Pesos::parse('$ 1.234,56'));
        $this->assertSame('1234', Pesos::parse('1.234'));
        $this->assertSame('0.5', Pesos::parse('0,5'));
        $this->assertNull(Pesos::parse('abc'));
        $this->assertNull(Pesos::parse(null));
    }

    public function test_provinces(): void
    {
        $this->assertCount(24, Province::cases());
        $this->assertSame('Córdoba', Province::from('AR-X')->getLabel());
        $this->assertCount(24, array_unique(array_map(fn (Province $p) => $p->getLabel(), Province::cases())));
    }
}

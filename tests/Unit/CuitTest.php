<?php

namespace NodonHq\FilamentArgentina\Tests\Unit;

use NodonHq\FilamentArgentina\Support\Cuit;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CuitTest extends TestCase
{
    /** @return array<string, array{string}> */
    public static function valid(): array
    {
        return [
            'ARCA (real)' => ['33-69345023-9'],
            'person' => ['20-12345678-6'],
            'without separators' => ['20123456786'],
            'with dots and spaces' => ['27.11111111.7'],
            'check digit 0' => ['20 10000000 9'],
            'female' => ['27-00000001-4'],
        ];
    }

    /** @return array<string, array{mixed}> */
    public static function invalid(): array
    {
        return [
            'wrong check digit' => ['20-12345678-5'],
            'unknown prefix' => ['11-12345678-6'],
            'too short' => ['2012345678'],
            'too long' => ['201234567861'],
            'letters' => ['20-1234567A-6'],
            'empty' => [''],
            'null' => [null],
            'array' => [['20123456786']],
        ];
    }

    #[DataProvider('valid')]
    public function test_accepts_valid_numbers(string $cuit): void
    {
        $this->assertTrue(Cuit::isValid($cuit));
    }

    #[DataProvider('invalid')]
    public function test_rejects_invalid_numbers(mixed $cuit): void
    {
        $this->assertFalse(Cuit::isValid($cuit));
    }

    public function test_remainder_10_has_no_check_digit(): void
    {
        // Find a 20-prefixed number whose remainder is 10: no check digit makes it valid.
        $found = null;
        for ($n = 0; $n < 100 && $found === null; $n++) {
            $base = '20'.str_pad((string) $n, 8, '0', STR_PAD_LEFT);
            if (Cuit::checkDigit($base) === null) {
                $found = $base;
            }
        }
        $this->assertNotNull($found);
        for ($d = 0; $d <= 9; $d++) {
            $this->assertFalse(Cuit::isValid($found.$d));
        }
    }

    public function test_restricts_by_kind(): void
    {
        $this->assertTrue(Cuit::isValid('33-69345023-9', Cuit::COMPANY_PREFIXES));
        $this->assertFalse(Cuit::isValid('33-69345023-9', Cuit::PERSON_PREFIXES));
        $this->assertTrue(Cuit::isCompany('33693450239'));
        $this->assertFalse(Cuit::isCompany('20123456786'));
    }

    public function test_formats(): void
    {
        $this->assertSame('20-12345678-6', Cuit::format('20123456786'));
        $this->assertSame('20-12345678-6', Cuit::format('20.12345678.6'));
        $this->assertSame('123', Cuit::format('123'));
    }
}

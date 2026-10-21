<?php

namespace CeiboDev\FilamentArgentina\Tests\Unit;

use CeiboDev\FilamentArgentina\Support\Cbu;
use PHPUnit\Framework\TestCase;

class CbuTest extends TestCase
{
    private const CBU = '0110599540000000123457';

    private const CVU = '0000003110000000000014';

    public function test_accepts_valid_cbu_and_cvu(): void
    {
        $this->assertTrue(Cbu::isValid(self::CBU));
        $this->assertTrue(Cbu::isValid('01105995 40000000123457'));
        $this->assertTrue(Cbu::isValid(self::CVU));
    }

    public function test_any_changed_digit_breaks_it(): void
    {
        for ($i = 0; $i < 22; $i++) {
            $changed = self::CBU;
            $changed[$i] = (string) (((int) $changed[$i] + 1) % 10);
            $this->assertFalse(Cbu::isValid($changed), "digit {$i}");
        }
    }

    public function test_rejects_wrong_length_or_type(): void
    {
        $this->assertFalse(Cbu::isValid(substr(self::CBU, 0, 21)));
        $this->assertFalse(Cbu::isValid(self::CBU.'0'));
        $this->assertFalse(Cbu::isValid(null));
        $this->assertFalse(Cbu::isValid(''));
    }

    public function test_tells_banks_from_wallets(): void
    {
        $this->assertTrue(Cbu::isBankCbu(self::CBU));
        $this->assertFalse(Cbu::isCvu(self::CBU));
        $this->assertTrue(Cbu::isCvu(self::CVU));
        $this->assertFalse(Cbu::isBankCbu(self::CVU));
        $this->assertSame('011', Cbu::entityCode(self::CBU));
    }

    public function test_formats_in_two_blocks(): void
    {
        $this->assertSame('01105995 40000000123457', Cbu::format(self::CBU));
    }
}

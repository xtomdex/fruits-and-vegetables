<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueObject;

use App\Domain\ValueObject\Quantity;
use App\Domain\ValueObject\Unit;
use PHPUnit\Framework\TestCase;

final class QuantityTest extends TestCase
{
    public function testCreateWithGrams(): void
    {
        $quantity = Quantity::create(500);

        $this->assertSame(500, $quantity->asGrams());
        $this->assertSame(0.5, $quantity->asValueInUnit(Unit::KILOGRAMS));
        $this->assertSame(500.0, $quantity->asValueInUnit(Unit::GRAMS));
    }

    public function testCreateWithKilograms(): void
    {
        $quantity = Quantity::create(2.5, Unit::KILOGRAMS);

        $this->assertSame(2500, $quantity->asGrams());
        $this->assertSame(2.5, $quantity->asValueInUnit(Unit::KILOGRAMS));
    }

    public function testCreateWithZero(): void
    {
        $quantity = Quantity::create(0);

        $this->assertSame(0, $quantity->asGrams());
        $this->assertSame(0.0, $quantity->asValueInUnit(Unit::KILOGRAMS));
    }

    public function testCreateWithFloatInput(): void
    {
        $quantity = Quantity::create(1.75, Unit::KILOGRAMS);

        $this->assertSame(1750, $quantity->asGrams());
        $this->assertSame(1.75, $quantity->asValueInUnit(Unit::KILOGRAMS));
    }

    public function testCreateWithLargeValues(): void
    {
        $quantity = Quantity::create(1000000, Unit::KILOGRAMS);

        $this->assertSame(1000000000, $quantity->asGrams());
        $this->assertSame(1000000.0, $quantity->asValueInUnit(Unit::KILOGRAMS));
    }

    public function testCreateWithUnitConversionForDifferentUnit(): void
    {
        $quantity = Quantity::create(500);

        $this->assertSame(0.5, $quantity->asValueInUnit(Unit::KILOGRAMS));
    }
}

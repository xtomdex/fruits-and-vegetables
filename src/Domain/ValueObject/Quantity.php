<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class Quantity
{
    private function __construct(
        private int $value
    ) {}

    public static function create(int|float $value, ?Unit $unit = null): self
    {
        $calculatedValue = (int) match ($unit) {
            Unit::KILOGRAMS => $value * 1000,
            default => $value
        };

        return new self($calculatedValue);
    }

    public function asGrams(): int
    {
        return $this->value;
    }

    public function asValueInUnit(Unit $unit): float
    {
        return (float) match ($unit) {
            Unit::KILOGRAMS => $this->value / 1000,
            default => $this->value
        };
    }
}

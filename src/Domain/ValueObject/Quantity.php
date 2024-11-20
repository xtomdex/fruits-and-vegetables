<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class Quantity
{
    private function __construct(
        private int $value
    ) {}

    public static function fromGrams(int $grams): self
    {
        return new self($grams);
    }

    public static function fromKilograms(float $kilograms): self
    {
        return new self((int) $kilograms * 1000);
    }

    public function asGrams(): int
    {
        return $this->value;
    }

    public function asKilograms(): float
    {
        return (float) $this->value / 1000;
    }
}

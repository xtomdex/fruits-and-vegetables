<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Entity\Product;
use App\Domain\ValueObject\Unit;

final readonly class ProductDTO
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $type,
        public float $quantity,
        public string $unit
    ) {}

    public static function fromProduct(Product $product, Unit $unit): self
    {
        return new self(
            id: $product->getId(),
            name: $product->getName(),
            type: $product->getType()->value,
            quantity: $product->getQuantity()->asValueInUnit($unit),
            unit: $unit->value
        );
    }
}

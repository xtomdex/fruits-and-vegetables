<?php

declare(strict_types=1);

namespace App\Tests\Builder;

use App\Domain\Entity\Product;
use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Quantity;

final class ProductBuilder
{
    private string $name;
    private ProductType $type;
    private Quantity $quantity;

    public function __construct()
    {
        $this->name = 'Mango';
        $this->type = ProductType::Fruit;
        $this->quantity = Quantity::create(80000);
    }

    public function withName(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    public function withType(ProductType $type): self
    {
        $clone = clone $this;
        $clone->type = $type;
        return $clone;
    }

    public function withQuantity(Quantity $quantity): self
    {
        $clone = clone $this;
        $clone->quantity = $quantity;
        return $clone;
    }

    public function build(): Product
    {
        return new Product(
            name: $this->name,
            type: $this->type,
            quantity: $this->quantity
        );
    }
}

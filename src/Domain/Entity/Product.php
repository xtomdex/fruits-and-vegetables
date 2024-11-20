<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Quantity;

class Product
{
    private ?int $id = null;
    private string $type;
    private int $quantity;

    public function __construct(
        private string $name,
        ProductType $type,
        Quantity $quantity
    ) {
        $this->type = $type->value;
        $this->quantity = $quantity->asGrams();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): ProductType
    {
        return ProductType::from($this->type);
    }

    public function getQuantity(): Quantity
    {
        return Quantity::fromGrams($this->quantity);
    }
}
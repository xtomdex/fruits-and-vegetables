<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Quantity;
use App\Tests\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class ProductTest extends TestCase
{
    public function testCreate(): void
    {
        $product = (new ProductBuilder())
            ->withName($name = 'Product name')
            ->withType(ProductType::Fruit)
            ->withQuantity(Quantity::create($quantity = 8000))
            ->build();

        self::assertNull($product->getId());
        self::assertEquals($name, $product->getName());
        self::assertEquals(ProductType::Fruit, $product->getType());
        self::assertEquals($quantity, $product->getQuantity()->asGrams());
    }
}

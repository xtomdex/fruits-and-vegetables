<?php

declare(strict_types=1);

namespace App\Tests\Unit\Collection;

use App\Domain\Collection\ProductCollection;
use App\Tests\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class ProductCollectionTest extends TestCase
{
    public function testCreateAndList(): void
    {
        $products = [
            (new ProductBuilder())->withName('Product 1')->build(),
            (new ProductBuilder())->withName('Product 2')->build(),
        ];

        $collection = new ProductCollection($products);

        self::assertEquals($products, $collection->list());
    }

    public function testCreateEmpty(): void
    {
        $collection = new ProductCollection();

        self::assertEquals([], $collection->list());
    }

    public function testInvalidType(): void
    {
        $products = [
            (new ProductBuilder())->withName('Product 1')->build(),
            new InvalidProduct()
        ];

        self::expectExceptionMessage('Element must be an instance of Product');
        new ProductCollection($products);
    }

    public function testAdd(): void
    {
        $collection = new ProductCollection();
        $collection->add((new ProductBuilder())->withName($name = 'Product')->build());
        $items = $collection->list();

        self::assertEquals($name, $items[0]->getName());
    }

    public function testRemove(): void
    {
        $products = [
            (new ProductBuilder())->withName('Product 1')->build(),
            $productToRemove = (new ProductBuilder())->withName('Product 2')->build(),
            (new ProductBuilder())->withName('Product 3')->build(),
        ];

        $collection = new ProductCollection($products);
        self::assertCount(3, $collection->list());
        self::assertCount(1, array_filter($collection->list(), fn ($item) => $item->getName() === $productToRemove->getName()));

        $collection->remove($productToRemove);
        self::assertCount(2, $collection->list());
        self::assertCount(0, array_filter($collection->list(), fn ($item) => $item->getName() === $productToRemove->getName()));
    }
}

class InvalidProduct {}
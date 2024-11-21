<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Application\DTO\ProductDTO;
use App\Application\Exception\ValidationException;
use App\Application\UseCase\Product\List\Command;
use App\Application\UseCase\Product\List\Handler;
use App\Domain\Collection\ProductCollection;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\Unit;
use App\Tests\Builder\ProductBuilder;
use PHPUnit\Framework\TestCase;

final class ProductListUseCaseTest extends TestCase
{
    private Handler $handler;
    private ProductRepositoryInterface $products;

    protected function setUp(): void
    {
        $this->products = $this->createMock(ProductRepositoryInterface::class);
        $this->handler = new Handler($this->products);
    }

    public function testListWithoutParams(): void
    {
        $command = new Command(null, null, null);
        $productCollection = new ProductCollection([
            (new ProductBuilder())->build(),
            (new ProductBuilder())->build(),
            (new ProductBuilder())->build(),
        ]);

        $this->products->method('find')->willReturn($productCollection);

        $expected = array_map(
            fn($product) => ProductDTO::fromProduct($product, Unit::GRAMS),
            $productCollection->list()
        );

        $result = ($this->handler)($command);
        self::assertEquals($expected, $result);
    }

    public function testInvalidType(): void
    {
        $command = new Command('invalid_type', null, null);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid type provided');

        ($this->handler)($command);
    }

    public function testInvalidUnit(): void
    {
        $command = new Command(null, 'invalid_unit', null);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid unit provided');

        ($this->handler)($command);
    }
}

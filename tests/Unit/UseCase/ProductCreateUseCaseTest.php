<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Application\DTO\ProductDTO;
use App\Application\Exception\ValidationException;
use App\Application\UseCase\Product\Create\Command;
use App\Application\UseCase\Product\Create\Handler;
use App\Domain\FlusherInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Unit;
use PHPUnit\Framework\TestCase;

final class ProductCreateUseCaseTest extends TestCase
{
    private Handler $handler;
    private ProductRepositoryInterface $products;
    private FlusherInterface $flusher;

    protected function setUp(): void
    {
        $this->products = $this->createMock(ProductRepositoryInterface::class);
        $this->flusher = $this->createMock(FlusherInterface::class);
        $this->handler = new Handler($this->products, $this->flusher);
    }

    public function testCreate(): void
    {
        $command = new Command($quantity = 8000, $name = 'Apple', 'fruit');

        $expected = new ProductDTO(
            id: null,
            name: $name,
            type: ProductType::Fruit->value,
            quantity: $quantity,
            unit: Unit::GRAMS->value
        );

        $result = ($this->handler)($command);
        self::assertEquals($expected, $result);
    }

    public function testMissingType(): void
    {
        $command = new Command(1000, 'Apple');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Type is required');

        ($this->handler)($command);
    }

    public function testInvalidType(): void
    {
        $command = new Command(1000, 'Apple', 'invalid_type');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid type provided');

        ($this->handler)($command);
    }

    public function testMissingName(): void
    {
        $command = new Command(1000, null, 'fruit');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Name is required');

        ($this->handler)($command);
    }

    public function testInvalidQuantity(): void
    {
        $command = new Command((float) null, 'Apple', 'fruit');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid quantity provided');

        ($this->handler)($command);
    }

    public function testInvokeWithInvalidUnit(): void
    {
        $command = new Command(1000, 'Apple', 'fruit', 'invalid_unit');

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid unit provided');

        ($this->handler)($command);
    }
}

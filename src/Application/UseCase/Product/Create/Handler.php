<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product\Create;

use App\Application\DTO\ProductDTO;
use App\Application\Exception\ValidationException;
use App\Domain\Entity\Product;
use App\Domain\FlusherInterface;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Quantity;
use App\Domain\ValueObject\Unit;

final class Handler
{
    public function __construct(
        private readonly ProductRepositoryInterface $products,
        private readonly FlusherInterface $flusher
    ) {}

    public function __invoke(Command $command): ProductDTO
    {
        if (!($type = $command->type)) {
            throw new ValidationException('Type is required');
        }

        if (!($type = ProductType::tryFrom($type))) {
            throw new ValidationException('Invalid type provided');
        }

        if (!($name = $command->name)) {
            throw new ValidationException('Name is required');
        }

        if ($command->quantity <= 0) {
            throw new ValidationException('Invalid quantity provided');
        }

        try {
            $unit = $command->unit ? Unit::from($command->unit) : Unit::GRAMS;
        } catch (\ValueError) {
            throw new ValidationException('Invalid unit provided');
        }

        $product = new Product($name, $type, Quantity::create($command->quantity, $unit));

        $this->products->add($product);

        $this->flusher->flush();

        return ProductDTO::fromProduct($product, $unit);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product\List;

use App\Application\DTO\ProductDTO;
use App\Application\Exception\ValidationException;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductFilter;
use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Unit;

final class Handler
{
    public function __construct(
        private readonly ProductRepositoryInterface $products
    ) {}

    /**
     * Returns product list with applied filters.
     *
     * @param Command $command
     * @return ProductDTO[]
     * @throws ValidationException
     */
    public function __invoke(Command $command): array
    {
        try {
            $type = $command->type ? ProductType::from($command->type) : null;
        } catch (\ValueError) {
            throw new ValidationException('Invalid type provided');
        }

        $unit = $command->unit ? Unit::tryFrom($command->unit) : Unit::GRAMS;

        if (null === $unit) {
            throw new ValidationException('Invalid unit provided');
        }

        $filter = new ProductFilter($type, $command->name);
        $products = $this->products->find($filter);

        return array_map(fn(Product $product) => ProductDTO::fromProduct($product, $unit), $products->list());
    }
}

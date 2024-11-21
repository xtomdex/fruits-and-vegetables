<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Collection\ProductCollection;
use App\Domain\Entity\Product;
use App\Domain\ValueObject\ProductFilter;

interface ProductRepositoryInterface
{
    /**
     * Persists product in database.
     *
     * @param Product $product
     */
    public function add(Product $product): void;
    /**
     * Removes product.
     *
     * @param Product $product
     */
    public function remove(Product $product): void;
    /**
     * Returns filtered product collection.
     *
     * @param ProductFilter $filter
     */
    public function find(ProductFilter $filter): ProductCollection;
}

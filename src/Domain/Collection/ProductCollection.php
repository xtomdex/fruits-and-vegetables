<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\Entity\Product;
use Doctrine\Common\Collections\ArrayCollection;

final readonly class ProductCollection
{
    private ArrayCollection $products;

    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->validate($product);
        }

        $this->products = new ArrayCollection($products);
    }

    public function add(Product $product): void
    {
        $this->products->add($product);
    }

    public function remove(Product $product): void
    {
        $this->products->removeElement($product);
    }

    public function list(): array
    {
        return $this->products->toArray();
    }

    private function validate(mixed $element): void
    {
        if (!$element instanceof Product) {
            throw new \InvalidArgumentException('Element must be an instance of Product');
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

final readonly class ProductFilter
{
    public function __construct(
        public ?ProductType $type,
        public ?string $name
    ) {}
}

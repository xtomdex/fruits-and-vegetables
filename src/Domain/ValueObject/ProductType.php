<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum ProductType: string
{
    case Fruit = 'fruit';
    case Vegetable = 'vegetable';
}

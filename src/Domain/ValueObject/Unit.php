<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

enum Unit: string
{
    case GRAMS = 'g';
    case KILOGRAMS = 'kg';
}

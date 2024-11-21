<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product\Create;

final class Command
{
    public function __construct(
        public float $quantity,
        public ?string $name = null,
        public ?string $type = null,
        public ?string $unit = null
    ) {}
}

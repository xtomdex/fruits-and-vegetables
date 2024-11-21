<?php

declare(strict_types=1);

namespace App\Application\UseCase\Product\List;

final readonly class Command
{
    public function __construct(
        public ?string $type,
        public ?string $unit,
        public ?string $name
    ) {}
}

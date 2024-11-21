<?php

declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\FlusherInterface;
use Doctrine\ORM\EntityManagerInterface;

final class Flusher implements FlusherInterface
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function flush(): void
    {
        $this->em->flush();
    }
}

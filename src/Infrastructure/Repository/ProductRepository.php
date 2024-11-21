<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Collection\ProductCollection;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Domain\ValueObject\ProductFilter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class ProductRepository implements ProductRepositoryInterface
{
    private readonly EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
        $this->repository = $em->getRepository(Product::class);
    }

    public function add(Product $product): void
    {
        $this->em->persist($product);
    }

    public function remove(Product $product): void
    {
        $this->em->remove($product);
    }

    public function find(ProductFilter $filter): ProductCollection
    {
        $qb = $this->repository->createQueryBuilder('p');

        if (null !== $filter->type) {
            $qb
                ->andWhere('p.type = :type')
                ->setParameter('type', $filter->type->value);
        }

        if (null !== $filter->name) {
            $qb
                ->andWhere('p.name LIKE :name')
                ->setParameter('name', '%' . $filter->name . '%');
        }

        return new ProductCollection($qb->getQuery()->getResult());
    }
}

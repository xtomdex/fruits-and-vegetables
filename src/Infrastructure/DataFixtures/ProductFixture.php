<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Entity\Product;
use App\Domain\Parser\ProductDataParserInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ProductFixture extends Fixture
{
    public function __construct(
        private readonly ProductDataParserInterface $dataParser,
        private readonly ParameterBagInterface $params
    ) {}

    public function load(ObjectManager $manager): void
    {
        $filePath = $this->params->get('kernel.project_dir') . '/request.json';
        $data = file_get_contents($filePath);
        $products = $this->dataParser->parse($data);

        /** @var Product $product */
        foreach ($products->list() as $product) {
            $manager->persist($product);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Parser;

use App\Domain\Collection\ProductCollection;
use App\Domain\Entity\Product;
use App\Domain\Parser\ProductDataParserInterface;
use App\Domain\ValueObject\ProductType;
use App\Domain\ValueObject\Quantity;
use App\Domain\ValueObject\Unit;

final class JsonToProductCollectionParser implements ProductDataParserInterface
{
    public function parse(string $data): ProductCollection
    {
        $decodedData = json_decode($data, true);
        
        if (!is_array($decodedData)) {
            throw new \InvalidArgumentException('Invalid JSON input');
        }

        $collection = new ProductCollection();

        foreach ($decodedData as $item) {
            if (empty($item['name']) || empty($item['type']) || empty($item['quantity']) || empty($item['unit'])) {
                throw new \InvalidArgumentException('Missing required fields in JSON');
            }

            if (!($type = ProductType::tryFrom($item['type']))) {
                throw new \InvalidArgumentException("Invalid type: {$item['type']}");
            }

            $quantity = $item['quantity'];
            if (!is_numeric($quantity) || $quantity <= 0) {
                throw new \InvalidArgumentException('Invalid quantity');
            }

            if (!($unit = Unit::tryFrom($item['unit']))) {
                throw new \InvalidArgumentException("Invalid unit: {$item['unit']}");
            }

            $item = new Product($item['name'], $type, Quantity::create($quantity, $unit));
            $collection->add($item);
        }

        return $collection;
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Unit\Parser;

use App\Domain\Collection\ProductCollection;
use App\Infrastructure\Parser\JsonToProductCollectionParser;
use PHPUnit\Framework\TestCase;

final class JsonToProductDataParserTest extends TestCase
{
    private JsonToProductCollectionParser $parser;

    protected function setUp(): void
    {
        $this->parser = new JsonToProductCollectionParser();
    }

    public function testParseWithValidData(): void
    {
        $json = json_encode([
            ['name' => $name = 'Apple', 'type' => $type = 'fruit', 'quantity' => $quantity = 1000, 'unit' => 'g'],
            ['name' => 'Tomato', 'type' => 'vegetable', 'quantity' => 2.5, 'unit' => 'kg']
        ]);

        $collection = $this->parser->parse($json);
        $products = $collection->list();

        $this->assertInstanceOf(ProductCollection::class, $collection);
        $this->assertCount(2, $products);

        $this->assertEquals($name, $products[0]->getName());
        $this->assertEquals($type, $products[0]->getType()->value);
        $this->assertEquals($quantity, $products[0]->getQuantity()->asGrams());
    }

    public function testInvalidJson(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid JSON input');

        $this->parser->parse('Invalid JSON String');
    }

    public function testMissingFields(): void
    {
        $json = json_encode([['name' => 'Apple', 'type' => 'fruit', 'quantity' => 100]]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required fields in JSON');

        $this->parser->parse($json);
    }

    public function testInvalidType(): void
    {
        $json = json_encode([['name' => 'Apple', 'type' => 'INVALID_TYPE', 'quantity' => 1000, 'unit' => 'g']]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type: INVALID_TYPE');

        $this->parser->parse($json);
    }

    public function testInvalidQuantity(): void
    {
        $json = json_encode([['name' => 'Apple', 'type' => 'fruit', 'quantity' => -5, 'unit' => 'g']]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid quantity');

        $this->parser->parse($json);
    }

    public function testInvalidUnit(): void
    {
        $json = json_encode([['name' => 'Apple', 'type' => 'fruit', 'quantity' => 1000, 'unit' => 'INVALID_UNIT']]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid unit: INVALID_UNIT');

        $this->parser->parse($json);
    }
}

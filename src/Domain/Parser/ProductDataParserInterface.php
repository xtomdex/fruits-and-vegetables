<?php

declare(strict_types=1);

namespace App\Domain\Parser;

use App\Domain\Collection\ProductCollection;

interface ProductDataParserInterface
{
    /**
     * Parses file raw data and returns product collection.
     *
     * @param string $data
     * @return ProductCollection
     */
    public function parse(string $data): ProductCollection;
}
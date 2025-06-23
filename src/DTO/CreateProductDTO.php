<?php

namespace App\DTO;

use App\Enum\Category;

class CreateProductDTO
{
    public function __construct(
        public readonly string $name,
        public readonly float $price,
        public readonly string $category,
        public readonly array $attributes,
    ) {}
}

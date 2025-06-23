<?php

namespace App\DTO;

use App\Attributes\Required;
use App\Attributes\MinLength;
use App\Attributes\IsNumeric;
use App\Enum\Category;

readonly class ProductDTO
{
    #[Required]
    #[MinLength(3)]
    public string $name;

    #[IsNumeric]
    public float $price;

    #[Required]
    public Category $category;

    #[Required]
    public array $attributes;

    public function __construct(string $name, float $price, Category $category, array $attributes)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }
}

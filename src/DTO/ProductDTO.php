<?php

namespace App\DTO;

use App\Attributes\Required;
use App\Attributes\MinLength;
use App\Attributes\IsNumeric;

readonly class ProductDTO
{
    #[Required]
    #[MinLength(3)]
    public string $name;

    #[IsNumeric]
    public float $price;

    #[Required]
    public string $category;

    #[Required]
    public array $attributes;

    public function __construct(string $name, float $price, string $category, array $attributes)
    {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }
}

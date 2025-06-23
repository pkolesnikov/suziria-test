<?php
declare(strict_types=1);

namespace App\Diagnostics;

use App\DTO\ProductDTO;
use App\Enum\Category;
use Stringable;

final readonly class ProductInspector
{
    public function __construct(
    ) {}

    public function inspect(ProductDTO $product): string
    {
        $summary = match ($product->category) {
            Category::Electronics => 'Electronics detected.',
            Category::Books => 'It is a book.',
            Category::Clothing => 'Some sort of clothing.',
            Category::Toys => 'This is a toy.',
            Category::Furniture => 'Furniture item.',
            Category::Computers => 'Computer-related product.',
            Category::Appliances => 'Appliance item.',
            Category::Cameras => 'Camera-related product.',
            Category::Drones => 'A flying drone.',
            Category::Monitors => 'Monitor screen.',
            default => 'Unknown category.',
        };

        return $summary;
    }

    public function unsupported(mixed $value): never
    {
        throw new \RuntimeException("Unsupported value: " . print_r($value, true));
    }
}
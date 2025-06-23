<?php
declare(strict_types=1);

namespace App\Diagnostics;

use App\Enum\Category;
use App\Model\Product;
use Stringable;
use Psr\Log\LoggerInterface;

final readonly class ProductInspector
{
    public function __construct(
        private LoggerInterface&Stringable $logger
    ) {}

    public function inspect(Product $product): string
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

        $this->logger->info("Inspected: {$product->name}");

        return $summary;
    }

    public function unsupported(mixed $value): never
    {
        throw new \RuntimeException("Unsupported value: " . print_r($value, true));
    }
}

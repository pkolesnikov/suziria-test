<?php

use App\Database;

require_once __DIR__ . '/../vendor/autoload.php';

$db = (new Database())->getConnection();

echo "Running DB migrations...\n";

$db->exec('CREATE EXTENSION IF NOT EXISTS "uuid-ossp"');
$db->exec("
    CREATE TABLE IF NOT EXISTS products (
        id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
        name TEXT NOT NULL,
        price NUMERIC(10,2) NOT NULL,
        category TEXT NOT NULL,
        attributes JSONB NOT NULL,
        created_at TIMESTAMP WITHOUT TIME ZONE DEFAULT NOW()
    )
");

echo "Migration complete\n";

$stmt = $db->query("SELECT COUNT(*) FROM products");
$count = (int) $stmt->fetchColumn();

if ($count > 0) {
    echo "ℹ️  Skipping seed — products already present ($count items)\n";
    exit(0);
}

echo "Seeding database...\n";

$products = [
    ['iPhone 15', 999.99, 'electronics', ['brand' => 'Apple', 'color' => 'black']],
    ['Galaxy S23', 899, 'electronics', ['brand' => 'Samsung', 'color' => 'gray']],
    ['MacBook Pro', 1799, 'computers', ['size' => '16', 'brand' => 'Apple']],
    ['Surface Laptop', 1299, 'computers', ['brand' => 'Microsoft', 'color' => 'silver']],
    ['Dyson Vacuum', 599, 'appliances', ['type' => 'wireless', 'brand' => 'Dyson']],
    ['Canon EOS R5', 3899, 'cameras', ['type' => 'mirrorless', 'brand' => 'Canon']],
    ['Razer Blade 15', 2199, 'computers', ['gpu' => 'RTX 4070', 'brand' => 'Razer']],
    ['Alienware Monitor', 1099, 'monitors', ['size' => '34', 'type' => 'Q-OLED', 'brand' => 'Dell']],
    ['DJI Mini 3', 759, 'drones', ['brand' => 'DJI', 'weight' => '249g']],
    ['LG OLED 55', 625.70, 'electronics', ['brand' => 'LG', 'resolution' => '4K']],
    ['Sony WH-1000XM5', 837.68, 'electronics', ['type' => 'Headphones', 'wireless' => true]],
    ['Harry Potter Box', 1830.53, 'books', ['volumes' => 7, 'language' => 'English']],
    ['The Pragmatic Programmer', 1705.90, 'books', ['pages' => 352, 'author' => 'Hunt & Thomas']],
    ['Modern Sofa', 878.55, 'furniture', ['color' => 'grey', 'material' => 'fabric']],
    ['Ergonomic Chair', 1396.55, 'furniture', ['material' => 'mesh', 'adjustable' => true]],
    ['Wooden Desk', 1734.81, 'furniture', ['drawers' => 3, 'material' => 'oak']],
    ['Basic T-Shirt', 857.44, 'clothing', ['size' => 'M', 'brand' => 'Uniqlo']],
    ['Winter Jacket', 1409.06, 'clothing', ['size' => 'L', 'brand' => 'North Face']],
    ['Running Shoes', 959.33, 'clothing', ['size' => 42, 'brand' => 'Adidas']],
    ['RC Car Turbo', 1751.38, 'toys', ['scale' => '1:16', 'battery' => 'Li-ion']],
];

$query = $db->prepare("
    INSERT INTO products (name, price, category, attributes)
    VALUES (:name, :price, :category, :attributes)
");

foreach ($products as [$name, $price, $category, $attributes]) {
    $query->execute([
        ':name' => $name,
        ':price' => $price,
        ':category' => $category,
        ':attributes' => json_encode($attributes),
    ]);
}

echo "Seed complete\n";

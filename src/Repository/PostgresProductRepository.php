<?php

namespace App\Repository;

use App\DTO\CreateProductDTO;
use App\Database;
use Ramsey\Uuid\Uuid;
use PDO;

class PostgresProductRepository
{
    public function create(CreateProductDTO $dto): string
    {
        $pdo = Database::getConnection();
        $id = Uuid::uuid4()->toString();

        $stmt = $pdo->prepare('
            INSERT INTO products (id, name, price, category, attributes)
            VALUES (:id, :name, :price, :category, :attributes)
        ');

        $stmt->execute([
            'id' => $id,
            'name' => $dto->name,
            'price' => $dto->price,
            'category' => $dto->category,
            'attributes' => json_encode($dto->attributes),
        ]);

        return $id;
    }

    public function findById(string $id): ?array
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->mapRow($row);
    }

    public function updatePartial(string $id, array $data): bool
    {
        $pdo = Database::getConnection();

        $existing = $this->findById($id);
        if (!$existing) {
            return false;
        }

        $fields = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params['name'] = $data['name'];
        }
        if (isset($data['price'])) {
            $fields[] = 'price = :price';
            $params['price'] = $data['price'];
        }
        if (isset($data['category'])) {
            $fields[] = 'category = :category';
            $params['category'] = $data['category'];
        }
        if (isset($data['attributes'])) {
            $fields[] = 'attributes = :attributes';
            $params['attributes'] = json_encode($data['attributes']);
        }

        if (empty($fields)) {
            return true;
        }

        $sql = 'UPDATE products SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return true;
    }

    public function delete(string $id): bool
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount() > 0;
    }

    public function findAll(?string $category, ?string $minPrice, ?string $maxPrice): array
    {
        $pdo = Database::getConnection();

        $query = 'SELECT * FROM products WHERE 1=1';
        $params = [];

        if ($category !== null) {
            $query .= ' AND category = :category';
            $params['category'] = $category;
        }

        if ($minPrice !== null) {
            $query .= ' AND price >= :minPrice';
            $params['minPrice'] = $minPrice;
        }

        if ($maxPrice !== null) {
            $query .= ' AND price <= :maxPrice';
            $params['maxPrice'] = $maxPrice;
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapRow'], $rows);
    }

    private function mapRow(array $row): array
    {
        return [
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => (float)$row['price'],
            'category' => $row['category'],
            'attributes' => json_decode($row['attributes'], true),
            'createdAt' => date(DATE_ATOM, strtotime($row['created_at']))
        ];
    }
}

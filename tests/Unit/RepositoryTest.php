<?php

use PHPUnit\Framework\TestCase;
use App\Repository\PostgresProductRepository;

final class RepositoryTest extends TestCase
{
    public function testMapRowReturnsCorrectStructure(): void
    {
        $repo = new PostgresProductRepository();

        $row = [
            'id' => 'test-id',
            'name' => 'Toy',
            'price' => 19.99,
            'category' => 'toys',
            'attributes' => json_encode(['color' => 'red']),
            'created_at' => '2025-06-23 18:00:00'
        ];

        $mapped = (new ReflectionClass($repo))
            ->getMethod('mapRow')
            ->invoke($repo, $row);

        $this->assertSame('Toy', $mapped['name']);
        $this->assertSame('toys', $mapped['category']);
        $this->assertEquals(['color' => 'red'], $mapped['attributes']);
    }
}

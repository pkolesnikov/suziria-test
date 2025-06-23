<?php

namespace App\Repository;

use App\DTO\CreateProductDTO;
use Ramsey\Uuid\Uuid;

class PostgresProductRepository
{
    public function create(CreateProductDTO $dto): string
    {
        return Uuid::uuid4()->toString();
    }
}

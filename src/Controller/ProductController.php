<?php

namespace App\Controller;

use App\DTO\CreateProductDTO;
use App\Repository\PostgresProductRepository;
use App\Validator\DTOValidator;

class ProductController
{
    public function create(): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        try {
            $dto = new CreateProductDTO(
                $input['name'] ?? '',
                $input['price'] ?? null,
                $input['category'] ?? '',
                $input['attributes'] ?? []
            );

            (new DTOValidator())->validate($dto);

            $repository = new PostgresProductRepository();
            $id = $repository->create($dto);

            http_response_code(201);
            echo json_encode(['id' => $id]);

        } catch (\Throwable $e) {
            http_response_code(422);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

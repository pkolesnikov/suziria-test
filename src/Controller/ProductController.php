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

    public function get(string $id): void
    {
        try {
            $repository = new PostgresProductRepository();
            $product = $repository->findById($id);

            if (!$product) {
                http_response_code(404);
                echo json_encode(['error' => 'Product not found']);
                return;
            }

            http_response_code(200);
            echo json_encode($product);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function update(string $id): void
    {
        $input = json_decode(file_get_contents('php://input'), true);

        try {
            $repository = new PostgresProductRepository();
            $updated = $repository->updatePartial($id, $input);

            if (!$updated) {
                http_response_code(404);
                echo json_encode(['error' => 'Product not found']);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => 'Product updated']);
        } catch (\Throwable $e) {
            http_response_code(422);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function delete(string $id): void
    {
        try {
            $repository = new PostgresProductRepository();
            $deleted = $repository->delete($id);

            if (!$deleted) {
                http_response_code(404);
                echo json_encode(['error' => 'Product not found']);
                return;
            }

            http_response_code(204); // No Content
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function list(): void
    {
        try {
            $category = $_GET['category'] ?? null;
            $minPrice = $_GET['minPrice'] ?? null;
            $maxPrice = $_GET['maxPrice'] ?? null;

            $repository = new PostgresProductRepository();
            $products = $repository->findAll($category, $minPrice, $maxPrice);

            http_response_code(200);
            echo json_encode($products);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

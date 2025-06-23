<?php

namespace App\Validator;

use App\DTO\CreateProductDTO;

class DTOValidator
{
    public function validate(CreateProductDTO $dto): void
    {
        if (empty($dto->name)) {
            throw new \InvalidArgumentException('Name is required');
        }

        if (!is_numeric($dto->price) || $dto->price <= 0) {
            throw new \InvalidArgumentException('Price must be positive number');
        }

        if (empty($dto->category)) {
            throw new \InvalidArgumentException('Category is required');
        }

        if (!is_array($dto->attributes)) {
            throw new \InvalidArgumentException('Attributes must be an array');
        }
    }
}

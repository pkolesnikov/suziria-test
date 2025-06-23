<?php

use PHPUnit\Framework\TestCase;
use App\DTO\CreateProductDTO;
use App\Validator\DTOValidator;

final class DTOValidatorTest extends TestCase
{
    public function testValidProductPasses(): void
    {
        $dto = new CreateProductDTO('Book', 19.99, 'books', ['author' => 'John']);
        $validator = new DTOValidator();

        $this->expectNotToPerformAssertions();
        $validator->validate($dto);
    }

    public function testInvalidProductFails(): void
    {
        $dto = new CreateProductDTO('', -5, '', []);
        $validator = new DTOValidator();

        $this->expectException(InvalidArgumentException::class);
        $validator->validate($dto);
    }
}

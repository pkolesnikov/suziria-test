<?php

use PHPUnit\Framework\TestCase;
use App\DTO\ProductDTO;
use App\Validator\DTOValidator;
use App\Enum\Category;

final class DTOValidatorTest extends TestCase
{
    public function testValidProductPasses(): void
    {
        $dto = new ProductDTO('Book', 19.99, Category::Books, ['author' => 'John']);
        $validator = new DTOValidator();

        $this->expectNotToPerformAssertions();
        $validator->validate($dto);
    }

    public function testInvalidProductFails(): void
    {
        $dto = new ProductDTO('', -5, Category::Books, []);
        $validator = new DTOValidator();

        $this->expectException(InvalidArgumentException::class);
        $validator->validate($dto);
    }
}

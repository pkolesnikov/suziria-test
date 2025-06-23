<?php

namespace App\Validator;

use App\Attributes\Required;
use App\Attributes\MinLength;
use App\Attributes\IsNumeric;
use ReflectionClass;
use ReflectionProperty;
use InvalidArgumentException;

class DTOValidator
{
    public static function validate(object $dto): void
    {
        $reflection = new ReflectionClass($dto);

        foreach ($reflection->getProperties() as $property) {
            $value = $property->getValue($dto);

            foreach ($property->getAttributes() as $attribute) {
                $instance = $attribute->newInstance();

                if ($instance instanceof Required && empty($value)) {
                    throw new InvalidArgumentException("{$property->getName()} is required.");
                }

                if ($instance instanceof MinLength && strlen($value) < $instance->length) {
                    throw new InvalidArgumentException("{$property->getName()} must be at least {$instance->length} characters.");
                }

                if ($instance instanceof IsNumeric && !is_numeric($value)) {
                    throw new InvalidArgumentException("{$property->getName()} must be numeric.");
                }
            }
        }
    }
}

<?php
namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class MinLength {
    public function __construct(public int $length) {}
}

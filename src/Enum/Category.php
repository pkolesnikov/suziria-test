<?php

declare(strict_types=1);

namespace App\Enum;

enum Category: string
{
    case Electronics = 'electronics';
    case Computers   = 'computers';
    case Furniture   = 'furniture';
    case Clothing    = 'clothing';
    case Books       = 'books';
    case Toys        = 'toys';
    case Appliances  = 'appliances';
    case Cameras     = 'cameras';
    case Drones      = 'drones';
    case Monitors    = 'monitors';
}

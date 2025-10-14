<?php

declare(strict_types=1);

namespace App\Enums;

enum CustomerType: string
{
    case B2B = 'B2B';
    case B2C = 'B2C';
}

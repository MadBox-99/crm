<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\QuoteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Quote extends Model
{
    /** @use HasFactory<QuoteFactory> */
    use HasFactory;
}

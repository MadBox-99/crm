<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\InteractionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Interaction extends Model
{
    /** @use HasFactory<InteractionFactory> */
    use HasFactory;
}

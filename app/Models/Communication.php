<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CommunicationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Communication extends Model
{
    /** @use HasFactory<CommunicationFactory> */
    use HasFactory;
}

<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\OpportunityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Opportunity extends Model
{
    /** @use HasFactory<OpportunityFactory> */
    use HasFactory;
}

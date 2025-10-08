<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CampaignFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Campaign extends Model
{
    /** @use HasFactory<CampaignFactory> */
    use HasFactory;
}

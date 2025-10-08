<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ComplaintFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Complaint extends Model
{
    /** @use HasFactory<ComplaintFactory> */
    use HasFactory;
}

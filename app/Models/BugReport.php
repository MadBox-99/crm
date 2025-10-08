<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\BugReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class BugReport extends Model
{
    /** @use HasFactory<BugReportFactory> */
    use HasFactory;
}

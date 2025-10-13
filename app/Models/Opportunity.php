<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\OpportunityStage;
use Database\Factories\OpportunityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Opportunity extends Model
{
    /** @use HasFactory<OpportunityFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'title',
        'description',
        'value',
        'probability',
        'stage',
        'expected_close_date',
        'assigned_to',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'probability' => 'integer',
            'expected_close_date' => 'date',
            'stage' => OpportunityStage::class,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\Opportunities\Pages;

use App\Filament\Resources\Opportunities\OpportunityResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateOpportunity extends CreateRecord
{
    protected static string $resource = OpportunityResource::class;
}

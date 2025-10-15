<?php

declare(strict_types=1);

namespace App\Filament\Resources\LostOpportunities\Pages;

use App\Filament\Resources\LostOpportunities\LostOpportunitiesResource;
use Filament\Resources\Pages\ListRecords;

final class ManageLostOpportunities extends ListRecords
{
    protected static string $resource = LostOpportunitiesResource::class;
}

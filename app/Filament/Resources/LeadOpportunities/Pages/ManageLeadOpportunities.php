<?php

declare(strict_types=1);

namespace App\Filament\Resources\LeadOpportunities\Pages;

use App\Filament\Resources\LeadOpportunities\LeadOpportunitiesResource;
use Filament\Resources\Pages\ListRecords;

final class ManageLeadOpportunities extends ListRecords
{
    protected static string $resource = LeadOpportunitiesResource::class;
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\WonOpportunities\Pages;

use App\Filament\Resources\WonOpportunities\WonOpportunitiesResource;
use Filament\Resources\Pages\ListRecords;

final class ManageWonOpportunities extends ListRecords
{
    protected static string $resource = WonOpportunitiesResource::class;
}

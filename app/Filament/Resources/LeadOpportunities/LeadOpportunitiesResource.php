<?php

declare(strict_types=1);

namespace App\Filament\Resources\LeadOpportunities;

use App\Enums\NavigationGroup;
use App\Filament\Resources\LeadOpportunities\Pages\ManageLeadOpportunities;
use App\Filament\Resources\LeadOpportunities\Tables\LeadOpportunitiesTable;
use App\Models\Opportunity;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

final class LeadOpportunitiesResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Customers;

    protected static ?string $navigationLabel = 'Leads';

    protected static ?string $modelLabel = 'Lead Opportunity';

    protected static ?string $pluralModelLabel = 'Lead Opportunities';

    protected static ?int $navigationSort = 10;

    public static function table(Table $table): Table
    {
        return LeadOpportunitiesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLeadOpportunities::route('/'),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Filament\Resources\WonOpportunities;

use App\Enums\NavigationGroup;
use App\Filament\Resources\WonOpportunities\Pages\ManageWonOpportunities;
use App\Filament\Resources\WonOpportunities\Tables\WonOpportunitiesTable;
use App\Models\Opportunity;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

final class WonOpportunitiesResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Customers;

    protected static ?string $navigationLabel = 'Won';

    protected static ?string $modelLabel = 'Won Opportunity';

    protected static ?string $pluralModelLabel = 'Won Opportunities';

    protected static ?int $navigationSort = 14;

    public static function table(Table $table): Table
    {
        return WonOpportunitiesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageWonOpportunities::route('/'),
        ];
    }
}

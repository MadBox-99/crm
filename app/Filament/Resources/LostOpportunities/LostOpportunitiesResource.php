<?php

declare(strict_types=1);

namespace App\Filament\Resources\LostOpportunities;

use App\Enums\NavigationGroup;
use App\Filament\Resources\LostOpportunities\Pages\ManageLostOpportunities;
use App\Filament\Resources\LostOpportunities\Tables\LostOpportunitiesTable;
use App\Models\Opportunity;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

final class LostOpportunitiesResource extends Resource
{
    protected static ?string $model = Opportunity::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Customers;

    protected static ?string $navigationLabel = 'Lost';

    protected static ?string $modelLabel = 'Lost Opportunity';

    protected static ?string $pluralModelLabel = 'Lost Opportunities';

    protected static ?int $navigationSort = 15;

    public static function table(Table $table): Table
    {
        return LostOpportunitiesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageLostOpportunities::route('/'),
        ];
    }
}

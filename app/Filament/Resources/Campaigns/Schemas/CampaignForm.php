<?php

declare(strict_types=1);

namespace App\Filament\Resources\Campaigns\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class CampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Textarea::make('target_audience_criteria')
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->numeric(),
            ]);
    }
}

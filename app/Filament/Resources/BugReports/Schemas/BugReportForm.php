<?php

declare(strict_types=1);

namespace App\Filament\Resources\BugReports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class BugReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('severity')
                    ->required()
                    ->default('medium'),
                TextInput::make('status')
                    ->required()
                    ->default('open'),
                TextInput::make('assigned_to')
                    ->numeric(),
                DateTimePicker::make('resolved_at'),
            ]);
    }
}

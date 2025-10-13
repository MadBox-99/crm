<?php

declare(strict_types=1);

namespace App\Filament\Resources\Complaints\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class ComplaintForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Select::make('order_id')
                    ->relationship('order', 'id'),
                TextInput::make('reported_by')
                    ->required()
                    ->numeric(),
                TextInput::make('assigned_to')
                    ->numeric(),
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
                Textarea::make('resolution')
                    ->columnSpanFull(),
                DateTimePicker::make('reported_at')
                    ->required(),
                DateTimePicker::make('resolved_at'),
            ]);
    }
}

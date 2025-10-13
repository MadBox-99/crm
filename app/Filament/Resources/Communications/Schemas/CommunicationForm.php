<?php

declare(strict_types=1);

namespace App\Filament\Resources\Communications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class CommunicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name'),
                TextInput::make('channel')
                    ->required()
                    ->default('email'),
                TextInput::make('direction')
                    ->required()
                    ->default('outbound'),
                TextInput::make('subject'),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('sent_at'),
                DateTimePicker::make('delivered_at'),
                DateTimePicker::make('read_at'),
            ]);
    }
}

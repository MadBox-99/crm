<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChatSessions\Schemas;

use App\Enums\ChatSessionStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

final class ChatSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('customer_id')
                    ->relationship('customer', 'name'),
                Select::make('user_id')
                    ->relationship('user', 'name'),
                DateTimePicker::make('started_at')
                    ->required(),
                DateTimePicker::make('ended_at'),
                Select::make('status')
                    ->options(ChatSessionStatus::class)
                    ->default('active')
                    ->required(),
            ]);
    }
}

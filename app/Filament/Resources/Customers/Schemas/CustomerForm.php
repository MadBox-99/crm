<?php

declare(strict_types=1);

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

final class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('unique_identifier')
                    ->default(uniqid())
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->required()
                    ->options([
                        'B2C' => 'B2C',
                        'B2B' => 'B2B',
                    ])
                    ->default('B2C'),
                TextInput::make('tax_number'),
                TextInput::make('registration_number'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

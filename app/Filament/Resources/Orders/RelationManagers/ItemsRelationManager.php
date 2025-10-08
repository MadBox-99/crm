<?php

declare(strict_types=1);

namespace App\Filament\Resources\Orders\RelationManagers;

use Filament\Actions;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

final class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $product = \App\Models\Product::find($state);
                            if ($product) {
                                $set('description', $product->name);
                                $set('unit_price', $product->unit_price);
                            }
                        }
                    }),

                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->minValue(0.01)
                    ->step(0.01)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::calculateTotal($set, $get)),

                Forms\Components\TextInput::make('unit_price')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->step(0.01)
                    ->required()
                    ->prefix('Ft')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::calculateTotal($set, $get)),

                Forms\Components\TextInput::make('discount_amount')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('Ft')
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::calculateTotal($set, $get)),

                Forms\Components\TextInput::make('tax_rate')
                    ->numeric()
                    ->default(27)
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->suffix('%')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => self::calculateTotal($set, $get)),

                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->disabled()
                    ->dehydrated()
                    ->prefix('Ft')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Product')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(decimalPlaces: 2)
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->money('HUF')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('discount_amount')
                    ->money('HUF')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('tax_rate')
                    ->suffix('%')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('total')
                    ->money('HUF')
                    ->alignEnd()
                    ->weight('bold'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function calculateTotal(callable $set, callable $get): void
    {
        $quantity = (float) ($get('quantity') ?? 0);
        $unitPrice = (float) ($get('unit_price') ?? 0);
        $discountAmount = (float) ($get('discount_amount') ?? 0);
        $taxRate = (float) ($get('tax_rate') ?? 0);

        $subtotal = ($quantity * $unitPrice) - $discountAmount;
        $tax = $subtotal * ($taxRate / 100);
        $total = $subtotal + $tax;

        $set('total', number_format($total, 2, '.', ''));
    }
}

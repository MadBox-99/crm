<?php

declare(strict_types=1);

namespace App\Filament\Resources\Customers\RelationManagers;

use App\Enums\OpportunityStage;
use App\Enums\QuoteStatus;
use App\Models\Opportunity;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\Slider\Enums\PipsMode;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

final class OpportunitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'opportunities';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->string()
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('value')
                    ->numeric(),
                Slider::make('probability')
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->range(minValue: 0, maxValue: 100)
                    ->tooltips()
                    ->step(5)
                    ->default(0)
                    ->fillTrack()
                    ->pips(PipsMode::Steps, 5),

                Select::make('stage')
                    ->options(OpportunityStage::class)
                    ->default(OpportunityStage::Lead)
                    ->required(),
                DatePicker::make('expected_close_date'),
                Select::make('assigned_to')
                    ->relationship('assignedUser', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->default(Auth::id())
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('value')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('probability')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('stage')
                    ->badge()
                    ->searchable(),
                TextColumn::make('expected_close_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('assignedUser.name')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                Action::make('generate_quote')
                    ->label('Generate Quote')
                    ->icon('heroicon-o-document-text')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Generate Quote from Opportunity')
                    ->modalDescription('This will create a new quote based on this opportunity data.')
                    ->modalSubmitActionLabel('Generate Quote')
                    ->action(function (Opportunity $record): void {
                        // Generate unique quote number
                        $lastQuote = Quote::query()
                            ->whereYear('created_at', now()->year)
                            ->orderBy('id', 'desc')
                            ->first();

                        $nextNumber = $lastQuote ? ((int) mb_substr((string) $lastQuote->quote_number, -4)) + 1 : 1;
                        $quoteNumber = 'QUO-'.now()->year.'-'.mb_str_pad(
                            (string) $nextNumber,
                            4,
                            '0',
                            STR_PAD_LEFT
                        );

                        // Calculate totals from opportunity value
                        $subtotal = $record->value ?? 0;
                        $taxAmount = $subtotal * 0.27; // 27% tax
                        $total = $subtotal + $taxAmount;

                        // Create quote from opportunity data
                        $quote = Quote::query()->create([
                            'customer_id' => $record->customer_id,
                            'opportunity_id' => $record->id,
                            'quote_number' => $quoteNumber,
                            'issue_date' => now(),
                            'valid_until' => now()->addDays(30),
                            'status' => QuoteStatus::Draft,
                            'subtotal' => $subtotal,
                            'discount_amount' => 0,
                            'tax_amount' => $taxAmount,
                            'total' => $total,
                            'notes' => 'Generated from Opportunity: '.$record->title.($record->description ? '

'.$record->description : ''),
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Quote Generated Successfully')
                            ->body(sprintf('Quote #%s has been created with a value of ', $quote->quote_number).number_format($total, 2).' HUF.')
                            ->send();
                    }),
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}

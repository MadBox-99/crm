<?php

declare(strict_types=1);

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Services\ChatService;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;

final class ViewChatSession extends ViewRecord
{
    protected static string $resource = ChatSessionResource::class;

    public function getView(): string
    {
        return 'filament.resources.chat-sessions.pages.view-chat-session';
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('assign')
                ->label('Assign to Me')
                ->icon('heroicon-o-user-plus')
                ->color(Color::Blue)
                ->visible(fn () => $this->record->user_id === null)
                ->requiresConfirmation()
                ->action(function () {
                    $chatService = app(ChatService::class);
                    $chatService->assignSession($this->record, auth()->user());

                    Notification::make()
                        ->title('Session Assigned')
                        ->success()
                        ->send();

                    $this->refreshFormData(['user_id']);
                }),
            Action::make('transfer')
                ->label('Transfer')
                ->icon('heroicon-o-arrow-path')
                ->color(Color::Orange)
                ->visible(fn () => $this->record->user_id !== null && $this->record->status->value === 'active')
                ->form([
                    Select::make('new_user_id')
                        ->label('Transfer to Agent')
                        ->options(\App\Models\User::query()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $chatService = app(ChatService::class);
                    $newUser = \App\Models\User::query()->find($data['new_user_id']);
                    $chatService->transferSession($this->record, $newUser);

                    Notification::make()
                        ->title('Session Transferred')
                        ->success()
                        ->send();

                    $this->refreshFormData(['user_id']);
                }),
            Action::make('close')
                ->label('Close Session')
                ->icon('heroicon-o-x-circle')
                ->color(Color::Red)
                ->visible(fn () => $this->record->status->value === 'active')
                ->requiresConfirmation()
                ->modalDescription('Are you sure you want to close this chat session?')
                ->action(function () {
                    $chatService = app(ChatService::class);
                    $chatService->closeSession($this->record);

                    Notification::make()
                        ->title('Session Closed')
                        ->success()
                        ->send();

                    $this->refreshFormData(['status', 'ended_at']);
                }),
        ];
    }
}

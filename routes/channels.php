<?php

declare(strict_types=1);

use App\Models\ChatSession;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Chat session private channel - csak a session résztvevQi férhetnek hozzá
Broadcast::channel('chat.session.{sessionId}', function (User $user, int $sessionId): bool {
    $session = ChatSession::query()->find($sessionId);

    if (! $session) {
        return false;
    }

    // User az admin aki hozzá van rendelve a session-höz
    return $session->user_id === $user->id;
});

// Online users presence channel - minden bejelentkezett admin láthatja
Broadcast::channel('chat.online-users', fn (User $user): array => [
    'id' => $user->id,
    'name' => $user->name,
]);

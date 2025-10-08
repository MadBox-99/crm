<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ChatMessageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class ChatMessage extends Model
{
    /** @use HasFactory<ChatMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'sender_type',
        'sender_id',
        'message',
    ];

    public function chatSession(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class);
    }

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            //
        ];
    }
}

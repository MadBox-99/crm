<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ChatSessionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ChatSession extends Model
{
    /** @use HasFactory<ChatSessionFactory> */
    use HasFactory;
}

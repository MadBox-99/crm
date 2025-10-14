<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table): void {
            $table->boolean('is_read')->default(false)->after('message');
            $table->timestamp('read_at')->nullable()->after('is_read');
            $table->unsignedBigInteger('parent_message_id')->nullable()->after('chat_session_id');
            $table->timestamp('edited_at')->nullable()->after('read_at');
            $table->softDeletes();

            $table->foreign('parent_message_id')
                ->references('id')
                ->on('chat_messages')
                ->nullOnDelete();
        });

        Schema::table('chat_sessions', function (Blueprint $table): void {
            $table->timestamp('last_message_at')->nullable()->after('ended_at');
            $table->unsignedInteger('unread_count')->default(0)->after('last_message_at');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal')->after('status');
            $table->tinyInteger('rating')->nullable()->after('priority');
            $table->text('notes')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table): void {
            $table->dropForeign(['parent_message_id']);
            $table->dropColumn([
                'is_read',
                'read_at',
                'parent_message_id',
                'edited_at',
                'deleted_at',
            ]);
        });

        Schema::table('chat_sessions', function (Blueprint $table): void {
            $table->dropColumn([
                'last_message_at',
                'unread_count',
                'priority',
                'rating',
                'notes',
            ]);
        });
    }
};

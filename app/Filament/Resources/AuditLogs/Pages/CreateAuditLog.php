<?php

declare(strict_types=1);

namespace App\Filament\Resources\AuditLogs\Pages;

use App\Filament\Resources\AuditLogs\AuditLogResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateAuditLog extends CreateRecord
{
    protected static string $resource = AuditLogResource::class;
}

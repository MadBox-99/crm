<?php

namespace App\Filament\Imports;

use App\Models\CampaignResponse;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class CampaignResponseImporter extends Importer
{
    protected static ?string $model = CampaignResponse::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('campaign')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('customer')
                ->requiredMapping()
                ->relationship()
                ->rules(['required']),
            ImportColumn::make('response_type')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('notes'),
            ImportColumn::make('responded_at')
                ->rules(['datetime']),
        ];
    }

    public function resolveRecord(): CampaignResponse
    {
        return CampaignResponse::firstOrNew([
            'id' => $this->data['id'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your campaign response import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

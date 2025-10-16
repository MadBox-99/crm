<?php

namespace App\Filament\Imports;

use App\Models\Customer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class CustomerImporter extends Importer
{
    protected static ?string $model = Customer::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('unique_identifier')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('type')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('tax_number'),
            ImportColumn::make('registration_number'),
            ImportColumn::make('email')
                ->rules(['email']),
            ImportColumn::make('phone'),
            ImportColumn::make('notes'),
            ImportColumn::make('is_active')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): Customer
    {
        return Customer::firstOrNew([
            'name' => $this->data['name'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your customer import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}

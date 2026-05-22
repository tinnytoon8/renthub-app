<?php

namespace App\Filament\Exports;

use App\Models\Expense;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ExpenseExporter extends Exporter
{
    protected static ?string $model = Expense::class;

    protected static int $no = 0;

    public static function getColumns(): array
    {
        self::$no = 0;

        return [
            ExportColumn::make('no')
                ->label('No')
                ->state(function () {
                    return ++self::$no;
                }),
            ExportColumn::make('title')
                ->label('Nama Pengeluaran'),
            ExportColumn::make('amount')
                ->label('Total Biaya'),
            ExportColumn::make('expense_date')
                ->label('Tanggal Pengeluaran'),
            ExportColumn::make('notes')
                ->label('Keterangan'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your expense export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

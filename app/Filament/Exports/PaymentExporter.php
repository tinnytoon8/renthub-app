<?php

namespace App\Filament\Exports;

use App\Models\Payment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class PaymentExporter extends Exporter
{
    protected static ?string $model = Payment::class;

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
            ExportColumn::make('invoice_number')
                ->label('No. Invoice'),
            ExportColumn::make('lease.room.room_number')
                ->label('No. Kontrakan'),
            ExportColumn::make('lease.tenant.name')
                ->label('Nama Penyewa'),
            ExportColumn::make('amount')
                ->label('Total Pembayaran'),
            ExportColumn::make('payment_date')
                ->label('Tanggal Bayar'),
            ExportColumn::make('payment_method')
                ->label('Metode Pembayaran'),
            ExportColumn::make('status')
                ->label('Status'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your payment export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}

<?php

namespace App\Filament\Resources\Payments\Tables;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->label('No. Invoice'),
                TextColumn::make('lease.room.room_number')
                    ->label('No. Kontrakan'),
                TextColumn::make('lease.tenant.name')
                    ->searchable()
                    ->label('Nama Penghuni'),
                TextColumn::make('amount_paid')
                    ->money('IDR')
                    ->sortable()
                    ->label('Jumlah Bayar'),
                TextColumn::make('payment_date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Bayar'),
                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'danger',
                        'partial' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'pending' => 'Pending',
                        'partial' => 'Dicicil',
                    })
                    ->label('Status'),          
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Belum Lunas',
                    ])
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('pdf')
                    ->label('Cetak')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn ($record) => response()->streamDownload(
                        function () use ($record) {
                            $pdf = Pdf::loadView('pdf.Kuitansi', ['payment' => $record]);
                            echo $pdf->stream();
                        },
                        "Kuitansi-{$record->invoice_number}.pdf"
                    ))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

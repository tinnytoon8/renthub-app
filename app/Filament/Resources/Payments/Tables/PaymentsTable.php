<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
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
                    ->money('d M Y')
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
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

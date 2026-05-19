<?php

namespace App\Filament\Resources\Leases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LeasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room.room_number')
                    ->label('No. Kamar'),
                TextColumn::make('tenant.name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->label('Mulai Menyewa'),
                TextColumn::make('end_date')
                    ->label('Selesai Menyewa')
                    ->default('-'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'gray'),
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

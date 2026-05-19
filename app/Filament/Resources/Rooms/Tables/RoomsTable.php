<?php

namespace App\Filament\Resources\Rooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('room_number')
                    ->label('No. Kontrakan')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->searchable(),
                // ImageColumn::make('photo')
                //     ->label('Foto'),
                TextColumn::make('address')
                    ->label('Alamat'),
                TextColumn::make('price')
                    ->money('IDR')
                    ->label('Harga Sewa'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'occupied' => 'danger',
                        'maintenance' => 'warning',
                        default => 'gray',
                    })
                    ->label('status'),
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

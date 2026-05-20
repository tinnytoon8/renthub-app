<?php

namespace App\Filament\Resources\Rooms\Tables;

use App\Models\Room;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->searchable()
                    ->sortable(),
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
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options(function () {
                        return Room::query()
                            ->whereNotNull('type')
                            ->distinct()
                            ->pluck('type', 'type')
                            ->toArray();
                    })
                    ->preload()
                    ->indicator('Tipe'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

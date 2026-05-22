<?php

namespace App\Filament\Resources\Leases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class LeasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) =>
                $query->with(['tenant', 'room'])
            )
            ->columns([
                TextColumn::make('room.room_number')
                    ->label('No. Kamar'),
                TextColumn::make('tenant.name')
                    ->label('Nama Penyewa')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date('d M Y')
                    ->label('Mulai Menyewa'),
                TextColumn::make('end_date')
                    ->date('d M Y')
                    ->label('Selesai Menyewa')
                    ->placeholder('-'),
                TextColumn::make('remaining_days')
                    ->label('Sisa Sewa')
                    ->state(function ($record) {
                        if(!$record->end_date) return 'Tanpa Batas';

                        $days = ceil(now()->diffInDays($record->end_date, false));
                        // return $days > 0 ? "$days Hari Lagi" : "Expired";
                        if ($days <= 0){
                            return 'Expired';
                        }

                        return $days . ' Hari Lagi';
                    })
                    ->color(function ($state) {
                        if (str_contains($state, 'Expired')) {
                            return 'danger';
                        }

                        $days = (int) filter_var($state, FILTER_SANITIZE_NUMBER_INT);
                        if ($days <= 3) {
                            return 'warning';
                        }
                        return 'success';
                    })
                    ->badge(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'gray'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'closed' => 'Tidak Aktif',
                    ])
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

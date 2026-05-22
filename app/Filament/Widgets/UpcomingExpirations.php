<?php

namespace App\Filament\Widgets;

use App\Models\Lease;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingExpirations extends TableWidget
{
    protected int | string | array $columnSpan = 2;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Penyewa Segera Berakhir')
            ->description('Daftar penyewa yang masa kontraknya habis dalam 7 hari.')
            ->query(
                fn (): Builder => Lease::query()
                ->where('end_date', '<=', now()->addDays(7))
                ->where('status', 'active')
            )
                
            ->columns([
                TextColumn::make('tenant.name')
                    ->label('nama')
                    ->weight('bold'),
                TextColumn::make('room.room_number')
                    ->label('No. Kamar')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('end_date')
                    ->label('Jatuh Tempo')
                    ->dateTime('d M Y')
                    ->description(fn ($record) => now()->diffForHumans($record->end_date))
                    ->color('danger'),
            ])
            ->emptyStateHeading('Semua Aman')
            ->emptyStateDescription('Tidak ada kontrak yang akan berakhir dalam waktu dekat')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}

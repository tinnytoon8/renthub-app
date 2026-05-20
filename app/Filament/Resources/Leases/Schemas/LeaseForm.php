<?php

namespace App\Filament\Resources\Leases\Schemas;

use App\Models\Room;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class LeaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('room_id')
                    ->relationship(
                        name: 'room',
                        titleAttribute: 'room_number',
                        modifyQueryUsing: fn (Builder $query, $record) => $query
                            ->where('status', 'available')
                            ->orWhere('id', $record?->room_id)
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->room_number} - {$record->type}")
                    ->hint(fn () => 'Sisa kontrakan tersedia: ' . Room::where('status', 'available')->count())
                    ->hintColor('primary')
                    ->label('Pilih Kontrakan')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->placeholder('Cari kamar yang tersedia...'),
                Select::make('tenant_id')
                    ->label('Pilih Penyewa')
                    ->relationship('tenant', 'name')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Tanggal Mulai')
                    ->required(),
                DatePicker::make('end_date')
                    ->label('Tanggal Selesai'),
                TextInput::make('deposit_amount')
                    ->label('Uang Jaminam/Deposit')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),
                Select::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'closed' => 'Selesai / Keluar'
                    ])
                    ->required(),
            ]);
    }
}

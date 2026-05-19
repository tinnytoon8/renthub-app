<?php

namespace App\Filament\Resources\Leases\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('room_id')
                    ->label('Pilih Kontrakan')
                    ->relationship('room', 'room_number')
                    ->required(),
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

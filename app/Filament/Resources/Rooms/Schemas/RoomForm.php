<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('room_number')
                    ->label('Nomor Kontrakan')
                    ->required(),
                TextInput::make('type')
                    ->label('Tipe Kontrakan'),
                Textarea::make('address')
                    ->label('Alamat'),
                TextInput::make('price')
                    ->label('Harga Sewa')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
                FileUpload::make('photo')
                    ->label('Foto')
                    ->image()
                    ->directory('rooms')
                    ->imagePreviewHeight(200)
                    ->nullable(),
                Select::make('status')
                    ->options([
                        'available' => 'tersedia',
                        'occupied'  => 'Terisi',
                        'maintenance' => 'Perbaikan',
                    ])
                    ->required(),
            ]);
    }
}

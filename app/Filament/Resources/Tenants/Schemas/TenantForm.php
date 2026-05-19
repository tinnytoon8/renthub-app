<?php

namespace App\Filament\Resources\Tenants\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tenant_number')
                    ->label('No. Penyewa')
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Penyewa')
                    ->required(),
                TextInput::make('no_identity')
                    ->label('Nomor Indentitas (NIK)')
                    ->length(16)
                    ->required(),
                TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required(),
                TextInput::make('emergency_phone')
                    ->label('Kontak Darurat')
                    ->tel(),
                FileUpload::make('photo_identity')
                    ->label('Foto Identitas')
                    ->image()
                    ->directory('identity-photos'),
            ]);
    }
}

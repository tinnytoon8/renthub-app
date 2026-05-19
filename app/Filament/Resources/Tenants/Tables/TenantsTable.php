<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tenant_number')
                    ->label('No. Penyewa')
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama Penyewa')
                    ->searchable(),
                TextColumn::make('no_identity')
                    ->label('Nomor Identitas (NIK)'),
                TextColumn::make('phone')
                    ->label('No. Telepon'),
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

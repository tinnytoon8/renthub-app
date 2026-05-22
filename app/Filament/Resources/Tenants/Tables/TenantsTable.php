<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
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
                ViewAction::make(),
                EditAction::make(),
                Action::make('chat')
                    ->label('Hubungi')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn ($record) => "https://wa.me/{$record->phone}?text=Halo%20{$record->name},%20ini%20dari%20manajemen%20RentHub...")
                    ->openUrlInNewTab(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

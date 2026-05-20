<?php

namespace App\Filament\Resources\Users\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->email),
                TextColumn::make('roles.name')
                    ->label('Hak Akses')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'panel_user' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->date('d M Y')
                    ->sortable()
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(function (DeleteAction $action, $record) {
                        if ($record->id === Auth::id()) {
                            Notification::make()
                                ->danger()
                                ->title('Gagal!')
                                ->body('Anda tidak bisa menghapus akun anda sendiri.')
                                ->send();
                            
                            $action->halt();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

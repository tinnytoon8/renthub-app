<?php

namespace App\Filament\Resources\Expenses\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Pengeluaran'),
                TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable()
                    ->label('Total Biaya')
                    ->summarize(Sum::make()->money('IDR')->label('Total Pengeluaran')),
                TextColumn::make('expense_date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal'),
            ])
            ->filters([
                //
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

<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->placeholder('Contoh : Bayar tagihan listrik')
                    ->label('Nama Pengeluaran'),
                TextInput::make('amount')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->label('Total Biaya'),
                DatePicker::make('expense_date')
                    ->default(now())
                    ->required()
                    ->label('Tanggal Pengeluaran'),
                FileUpload::make('proof_of_expense')
                    ->label('Foto Bukti Pembayaran (Jika Ada)')
                    ->image()
                    ->directory('proof_of_expenses')
                    ->imagePreviewHeight(200)
                    ->nullable(),
                Textarea::make('notes')
                    ->label('Catatan')
                    ->placeholder('Tulis info tambahan jika diperlukan (misal: Toko Material Abadi, nota terselip)')
                    ->nullable()


            ]);
    }
}

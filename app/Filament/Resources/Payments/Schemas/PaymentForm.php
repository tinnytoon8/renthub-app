<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lease_id')
                    ->relationship('lease', 'id', function ($query) {
                        return $query->where('status', 'active');
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => "Kontrakan: {$record->room->room_number} - {$record->tenant->name}")
                    ->required()
                    ->label('Kontrak Sewa Aktif'),
                TextInput::make('invoice_number')
                    ->disabled()
                    ->placeholder('Otomatis Oleh Sistem')
                    ->label('No. Invoice'),
                TextInput::make('amount_paid')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->label('Jumlah Bayar'),
                DatePicker::make('payment_date')
                    ->default(now())
                    ->required()
                    ->label('Tanggal Bayar'),
                Select::make('payment_method')
                    ->options([
                        'Transfer Bank' => 'Transfer Bank',
                        'Tunai' => 'Tunai',
                    ])
                    ->required()
                    ->label('Metode Pembayaran'),
                Select::make('status')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Pending / Belum Lunas',
                    ])
                    ->default('pending')
                    ->required(),
                FileUpload::make('proof_of_payment')
                    ->label('Foto Bukti Pembayaran (Jika Ada)')
                    ->image()
                    ->directory('proof_of_payments')
                    ->imagePreviewHeight(200)
                    ->nullable(),
                Textarea::make('notes')
                    ->label('Catatan')
            ]);
    }
}

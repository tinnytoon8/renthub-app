<?php

namespace App\Filament\Resources\Payments\Tables;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ExportBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => 
                $query->with([
                    'lease.room',
                    'lease.tenant',
                ])
            )
            ->columns([
                TextColumn::make('invoice_number')
                    ->searchable()
                    ->sortable()
                    ->label('No. Invoice'),
                TextColumn::make('lease.room.room_number')
                    ->label('No. Kontrakan'),
                TextColumn::make('lease.tenant.name')
                    ->searchable()
                    ->label('Nama Penghuni'),
                TextColumn::make('amount_paid')
                    ->money('IDR')
                    ->sortable()
                    ->label('Jumlah Bayar'),
                TextColumn::make('payment_date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Bayar'),
                TextColumn::make('payment_method')
                    ->label('Metode Pembayaran'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'danger',
                        'partial' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'pending' => 'Pending',
                        'partial' => 'Dicicil',
                    })
                    ->label('Status'),          
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Belum Lunas',
                    ]),
                Filter::make('payment_date')
                    ->form([
                        DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query  
                            ->when(
                                $data['dari_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('payment_date', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn (Builder $query, $date): Builder => $query->whereDate('payment_date', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['dari_tanggal'] ?? null) {
                            $indicators[] = 'Mulai: ' . \Carbon\Carbon::parse($data['dari_tanggal'])->format('d M Y');
                        }
                        if ($data['sampai_tanggal'] ?? null) {
                            $indicators[] = 'Hingga: ' . \Carbon\Carbon::parse($data['sampai_tanggal'])->format('d M Y');
                        }

                        return $indicators;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('pdf')
                    ->label('Cetak')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn ($record) => response()->streamDownload(
                        function () use ($record) {
                            $pdf = Pdf::loadView('pdf.Kuitansi', ['payment' => $record]);
                            echo $pdf->stream();
                        },
                        "Kuitansi-{$record->invoice_number}.pdf"
                    ))
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

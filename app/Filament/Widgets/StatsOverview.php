<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Payment;
use App\Models\Room;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // menghitung kamar yang tersedia
        $kamarKosong = Room::where('status', 'available')->count();

        // menghitung total pemasukan bulan ini (status lunas)
        $pemasukanBulanIni = Payment::where('status', 'paid')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount_paid');
        
        // menghitung total pengeluaran bulan ini
        $pengeluaranBulanIni = Expense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');
        
        // menghitung keuntungan bersih bulan ini
        $keuntunganBersih = $pemasukanBulanIni - $pengeluaranBulanIni;
            
        // Tampilan data di dashboard admin
        return [
            // menampilkan data kontrakan yang tersedia
            Stat::make('Kontrakan Tersedia', $kamarKosong . ' Kontrakan')
                ->description('Jumlah kontrakan siap huni')
                ->descriptionIcon('heroicon-m-home')
                ->color('success'),
            
            // menampilkan data dari total pemasukan tiap bulan
            Stat::make('Pemasukan Bulan Ini', 'Rp' . number_format($pemasukanBulanIni, 0, ',', '.'))
                ->description('Total kuitansi lunas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            
            // menampilkan data total keuntungan bersih
            Stat::make('Keuntungan Bersih', 'Rp' . number_format($keuntunganBersih, 0, ',', '.'))
                ->description('Pemasukan dikurangi pengeluaran')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($keuntunganBersih >= 0 ? 'success' : 'danger'),
        ];
    }
}

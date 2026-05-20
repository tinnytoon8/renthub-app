<?php

namespace App\Filament\Widgets;

use App\Models\Room;
use Filament\Widgets\ChartWidget;

class RoomStatusChart extends ChartWidget
{
    protected static ?int $sort = 2;
    
    protected ?string $heading = 'Komposisi Status Chart';

    protected function getData(): array
    {
        $available = Room::where('status', 'available')->count();

        $occupied = Room::where('status', 'occupied')->count();

        $maintenance = Room::where('status', 'maintenance')->count();
        return [
            'datasets' => [
                [
                    'label' => 'Status Kontrakan',
                    'data' => [$available, $occupied, $maintenance],
                    'backgroundColor' => [
                        '#10b981', // Hijau (Available)
                        '#3b82f6', // Biru (Occupied)
                        '#f59e0b', // Oranye (Maintenance)
                    ],
                ],
            ],
            'labels' => ['Tersedia', 'Terisi', 'Perbaikan'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}

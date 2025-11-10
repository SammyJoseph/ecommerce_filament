<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TotalCustomersChart extends ChartWidget
{
    protected static ?string $heading = 'Total customers';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 1;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        
        // Get cumulative customer count per month
        $labels = [];
        $data = [];
        
        // Fixed demo data for consistent display
        $demoData = [4500, 5800, 6200, 7500, 8200, 9100, 10500, 10800, 12100, 13500, 14800, 17200];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create(null, $month, 1)->format('M');
            $labels[] = $monthName;
            
            // Get total customers up to this month
            $count = User::whereYear('created_at', '<=', $currentYear)
                ->where(function($query) use ($currentYear, $month) {
                    $query->whereYear('created_at', '<', $currentYear)
                        ->orWhere(function($q) use ($currentYear, $month) {
                            $q->whereYear('created_at', $currentYear)
                              ->whereMonth('created_at', '<=', $month);
                        });
                })
                ->count();
            
            // Use real data if available, otherwise use fixed demo data
            $data[] = $count > 0 ? $count : $demoData[$month - 1];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0,
                    'pointBackgroundColor' => 'rgb(59, 130, 246)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'boxWidth' => 6,
                        'padding' => 15,
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'display' => true,
                        'color' => 'rgba(0, 0, 0, 0.05)',
                    ],
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
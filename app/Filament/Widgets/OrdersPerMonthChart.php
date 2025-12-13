<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class OrdersPerMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Orders per month';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 1;

    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        
        $monthlyOrders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');

        $labels = [];
        $data = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create(null, $month, 1)->format('M');
            $labels[] = $monthName;
            
            $data[] = $monthlyOrders->get($month, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
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
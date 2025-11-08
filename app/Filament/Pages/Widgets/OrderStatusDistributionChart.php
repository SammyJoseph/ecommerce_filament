<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class OrderStatusDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status Distribution';

    protected int | string | array $columnSpan = 6;

    protected function getData(): array
    {
        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $labels = $statusCounts->pluck('status')->map(function ($status) {
            return ucfirst($status);
        })->toArray();

        $data = $statusCounts->pluck('count')->toArray();

        $colors = [
            'completed' => ['rgba(34, 197, 94, 0.9)', 'rgb(34, 197, 94)'],
            'pending' => ['rgba(251, 191, 36, 0.9)', 'rgb(251, 191, 36)'],
            'cancelled' => ['rgba(239, 68, 68, 0.9)', 'rgb(239, 68, 68)'],
            'processing' => ['rgba(59, 130, 246, 0.9)', 'rgb(59, 130, 246)'],
            'shipped' => ['rgba(139, 92, 246, 0.9)', 'rgb(139, 92, 246)'],
        ];

        $backgroundColors = [];
        $borderColors = [];

        foreach ($statusCounts as $statusData) {
            $status = $statusData->status;
            $backgroundColors[] = $colors[$status][0] ?? 'rgba(156, 163, 175, 0.9)';
            $borderColors[] = $colors[$status][1] ?? 'rgb(156, 163, 175)';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => '#fff',
                    'borderWidth' => 3,
                    'hoverOffset' => 12,
                    'hoverBorderWidth' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
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
                        'padding' => 15,
                        'font' => [
                            'size' => 12,
                            'weight' => '500',
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'padding' => 12,
                    'titleFont' => [
                        'size' => 14,
                        'weight' => 'bold',
                    ],
                    'bodyFont' => [
                        'size' => 13,
                    ],
                    'borderColor' => 'rgba(255, 255, 255, 0.3)',
                    'borderWidth' => 1,
                    'displayColors' => true,
                ],
            ],
        ];
    }
}
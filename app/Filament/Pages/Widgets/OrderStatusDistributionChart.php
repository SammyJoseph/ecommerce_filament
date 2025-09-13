<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class OrderStatusDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status Distribution';

    protected int | string | array $columnSpan = 1;

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
            'completed' => ['rgba(34, 197, 94, 0.8)', 'rgb(34, 197, 94)'],
            'pending' => ['rgba(251, 191, 36, 0.8)', 'rgb(251, 191, 36)'],
            'cancelled' => ['rgba(239, 68, 68, 0.8)', 'rgb(239, 68, 68)'],
        ];

        $backgroundColors = [];
        $borderColors = [];

        foreach ($statusCounts as $statusData) {
            $status = $statusData->status;
            $backgroundColors[] = $colors[$status][0] ?? 'rgba(156, 163, 175, 0.8)';
            $borderColors[] = $colors[$status][1] ?? 'rgb(156, 163, 175)';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data,
                    'backgroundColor' => $backgroundColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
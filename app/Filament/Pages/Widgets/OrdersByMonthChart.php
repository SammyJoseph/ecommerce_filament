<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrdersByMonthChart extends ChartWidget
{
    protected static ?string $heading = 'Orders by Month';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $monthlyOrders = Order::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', 2025)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            $labels[] = $monthName;

            $orderData = $monthlyOrders->firstWhere('month', $month);
            $data[] = $orderData ? $orderData->count : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.8)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
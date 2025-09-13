<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Over Time';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        $salesData = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = $salesData->pluck('date')->map(fn ($date) => Carbon::parse($date)->format('M d'))->toArray();
        $data = $salesData->pluck('total')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data,
                    'backgroundColor' => 'rgb(59, 130, 246)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'tension' => 0.1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
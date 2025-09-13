<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use Illuminate\Support\Carbon;

class OrderStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->pluck('total_amount', 'created_at')
            ->mapWithKeys(fn ($amount, $date) => [$date instanceof Carbon ? $date->format('Y-m-d') : $date => $amount])
            ->all();

        return [
            Stat::make('Orders', Order::count())
                ->description('Total orders')
                ->chart(array_values($monthlyOrders)),
            Stat::make('Open Orders', Order::where('status', 'pending')->count())
                ->description('Orders awaiting processing'),
            Stat::make('Average Price', number_format(Order::avg('total_amount'), 2))
                ->description('Average order value'),
        ];
    }
}
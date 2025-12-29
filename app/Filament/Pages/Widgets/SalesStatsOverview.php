<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;

class SalesStatsOverview extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalSales = Order::where('status', 'completed')->sum('grand_total');
        $totalOrders = Order::where('status', 'completed')->count();
        $totalItems = OrderItem::count();
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;

        return [
            Stat::make('Total Sales', 'S/. ' . number_format($totalSales, 2))
                ->description('All time')
                ->color('success'),
            Stat::make('Total Orders', $totalOrders)
                ->description('Completed orders')
                ->color('primary'),
            Stat::make('Total Items Sold', $totalItems)
                ->description('All order items')
                ->color('warning'),
            Stat::make('Average Order Value', 'S/. ' . number_format($avgOrderValue, 2))
                ->description('Per completed order')
                ->color('info'),
        ];
    }
}
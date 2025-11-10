<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Get current month data
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        // Get previous month data for comparison
        $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth();

        // Revenue calculations
        $currentRevenue = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');
        $previousRevenue = Order::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
            ->sum('total_amount');
        $revenueChange = $previousRevenue > 0 
            ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : 0;
        
        // New customers calculations
        $currentCustomers = User::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        $previousCustomers = User::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
            ->count();
        $customersChange = $previousCustomers > 0 
            ? round((($currentCustomers - $previousCustomers) / $previousCustomers) * 100, 1)
            : 0;

        // New orders calculations
        $currentOrders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
        $previousOrders = Order::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
            ->count();
        $ordersChange = $previousOrders > 0 
            ? round((($currentOrders - $previousOrders) / $previousOrders) * 100, 1)
            : 0;

        // Get chart data for last 7 days
        $revenueChart = $this->getChartData('revenue');
        $customersChart = $this->getChartData('customers');
        $ordersChart = $this->getChartData('orders');

        return [
            Stat::make('Revenue', '$' . number_format($currentRevenue / 1000, 2) . 'k')
                ->description(abs($revenueChange) . '% ' . ($revenueChange >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($revenueChart)
                ->color($revenueChange >= 0 ? 'success' : 'danger'),
            
            Stat::make('New customers', number_format($currentCustomers / 1000, 2) . 'k')
                ->description(abs($customersChange) . '% ' . ($customersChange >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($customersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($customersChart)
                ->color($customersChange >= 0 ? 'success' : 'danger'),
            
            Stat::make('New orders', number_format($currentOrders / 1000, 2) . 'k')
                ->description(abs($ordersChange) . '% ' . ($ordersChange >= 0 ? 'increase' : 'decrease'))
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($ordersChart)
                ->color($ordersChange >= 0 ? 'success' : 'danger'),
        ];
    }

    private function getChartData(string $type): array
    {
        $data = [];
        $startDate = Carbon::now()->subDays(6);

        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            
            switch ($type) {
                case 'revenue':
                    $value = Order::whereDate('created_at', $date->format('Y-m-d'))
                        ->sum('total_amount');
                    $data[] = round($value / 100, 2);
                    break;
                case 'customers':
                    $value = User::whereDate('created_at', $date->format('Y-m-d'))
                        ->count();
                    $data[] = $value * 10; // Scale for better visualization
                    break;
                case 'orders':
                    $value = Order::whereDate('created_at', $date->format('Y-m-d'))
                        ->count();
                    $data[] = $value * 10; // Scale for better visualization
                    break;
            }
        }

        return $data;
    }
}
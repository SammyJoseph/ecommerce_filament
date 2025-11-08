<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TopSellingProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Top Selling Products';

    protected int | string | array $columnSpan = 4;

    protected function getData(): array
    {
        $topProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(quantity * price) as total_revenue')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(8)
            ->get();

        $products = Product::whereIn('id', $topProducts->pluck('product_id'))->get();
        $topProducts = $topProducts->map(function ($item) use ($products) {
            $product = $products->find($item->product_id);
            $item->name = $product ? $product->name : 'Unknown';
            return $item;
        });

        $labels = $topProducts->pluck('name')->toArray();
        $data = $topProducts->pluck('total_revenue')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (S/.)',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.9)',
                        'rgba(16, 185, 129, 0.9)',
                        'rgba(245, 158, 11, 0.9)',
                        'rgba(239, 68, 68, 0.9)',
                        'rgba(139, 92, 246, 0.9)',
                        'rgba(236, 72, 153, 0.9)',
                        'rgba(14, 165, 233, 0.9)',
                        'rgba(248, 113, 113, 0.9)',
                    ],
                    'borderColor' => '#fff',
                    'borderWidth' => 3,
                    'hoverOffset' => 15,
                    'hoverBorderWidth' => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'cutout' => '65%',
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 12,
                        'font' => [
                            'size' => 11,
                            'weight' => '500',
                        ],
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'padding' => 12,
                    'titleFont' => [
                        'size' => 13,
                        'weight' => 'bold',
                    ],
                    'bodyFont' => [
                        'size' => 12,
                    ],
                    'borderColor' => 'rgba(255, 255, 255, 0.3)',
                    'borderWidth' => 1,
                    'displayColors' => true,
                ],
            ],
        ];
    }
}
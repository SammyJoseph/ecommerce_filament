<?php

namespace App\Filament\Pages\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class TopSellingProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Top Selling Products';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $topProducts = OrderItem::select(
                'product_id',
                DB::raw('SUM(quantity) as total_quantity'),
                DB::raw('SUM(quantity * price) as total_revenue')
            )
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(10)
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
                    'label' => 'Revenue',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(199, 199, 199, 0.8)',
                        'rgba(83, 102, 255, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Widgets;
use App\Models\Order;
use App\Filament\Pages\Widgets\SalesOverTimeChart;
use App\Filament\Pages\Widgets\TopSellingProductsChart;
use App\Filament\Pages\Widgets\SalesStatsOverview;
use App\Filament\Pages\Widgets\OrdersByMonthChart;
use App\Filament\Pages\Widgets\OrderStatusDistributionChart;
use Illuminate\Support\Carbon;

class SalesReports extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.sales-reports';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false;

    public static function getSlug(): string
    {
        return 'sales-reports';
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(Carbon::now()->subDays(30)),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->default(Carbon::now()),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'all' => 'All',
                                'completed' => 'Completed',
                                'pending' => 'Pending',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('completed'),
                    ])
                    ->columnSpan(1),
            ])
            ->statePath('data');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SalesStatsOverview::class,
            SalesOverTimeChart::class,
            TopSellingProductsChart::class,
            OrdersByMonthChart::class,
            OrderStatusDistributionChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            // Add any header actions if needed
        ];
    }
    
    public function getColumns(): int | string | array
    {
        return 12;
    }
}
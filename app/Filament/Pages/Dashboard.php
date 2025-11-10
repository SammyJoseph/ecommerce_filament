<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    public function getColumns(): int | string | array
    {
        return [
            'default' => 1,
            'sm' => 1,
            'md' => 2,
            'lg' => 2,
            'xl' => 2,
            '2xl' => 2,
        ];
    }

    public function filtersForm(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Grid::make(3)
                    ->schema([
                        \Filament\Forms\Components\Select::make('business_customers_only')
                            ->label('Business customers only')
                            ->options([
                                '' => '-',
                                'yes' => 'Yes',
                                'no' => 'No',
                            ])
                            ->default(''),
                        
                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->label('Start date')
                            ->placeholder('dd/mm/aaaa')
                            ->displayFormat('d/m/Y')
                            ->default(null),
                        
                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label('End date')
                            ->placeholder('dd/11/2025')
                            ->displayFormat('d/m/Y')
                            ->default(now()),
                    ]),
            ]);
    }
}
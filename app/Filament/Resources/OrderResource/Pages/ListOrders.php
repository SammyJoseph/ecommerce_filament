<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Request;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('filter_by_date')
                ->label('Filtrar por Fecha')
                ->icon('heroicon-o-calendar')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('created_from')
                        ->label('Desde'),
                    \Filament\Forms\Components\DatePicker::make('created_until')
                        ->label('Hasta'),
                ])
                ->action(function (array $data) {
                    $url = request()->fullUrlWithQuery([
                        'created_from' => $data['created_from'],
                        'created_until' => $data['created_until'],
                    ]);
                    return redirect($url);
                }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStatsOverview::class,
        ];
    }

    public function getTabs(): array
    {
        $createdFrom = Request::get('created_from');
        $createdUntil = Request::get('created_until');

        $queryModifier = function (Builder $query) use ($createdFrom, $createdUntil) {
            if ($createdFrom) {
                $query->whereDate('created_at', '>=', $createdFrom);
            }
            if ($createdUntil) {
                $query->whereDate('created_at', '<=', $createdUntil);
            }
            return $query;
        };

        return [
            'all' => Tab::make('All')
                ->modifyQueryUsing($queryModifier),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending_payment')->when($createdFrom, fn ($q) => $q->whereDate('created_at', '>=', $createdFrom))->when($createdUntil, fn ($q) => $q->whereDate('created_at', '<=', $createdUntil))),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'delivered')->when($createdFrom, fn ($q) => $q->whereDate('created_at', '>=', $createdFrom))->when($createdUntil, fn ($q) => $q->whereDate('created_at', '<=', $createdUntil))),
            'cancelled' => Tab::make('Cancelled')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'cancelled')->when($createdFrom, fn ($q) => $q->whereDate('created_at', '>=', $createdFrom))->when($createdUntil, fn ($q) => $q->whereDate('created_at', '<=', $createdUntil))),
        ];
    }
}

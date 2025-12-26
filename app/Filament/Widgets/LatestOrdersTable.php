<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class LatestOrdersTable extends BaseWidget
{
    protected static ?int $sort = 5;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->latest()->limit(5)
            )
            ->heading('Latest Orders')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order date')
                    ->date('M d, Y')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('number')
                    ->label('Number')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state ?? 'OR-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT)),
                
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable()
                    ->default('Guest Customer'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'gray' => 'pending_payment',
                        'info' => 'payment_confirmed',
                        'warning' => 'processing',
                        'primary' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-m-banknotes' => 'pending_payment',
                        'heroicon-m-check-circle' => 'payment_confirmed',
                        'heroicon-m-arrow-path' => 'processing',
                        'heroicon-m-truck' => 'shipped',
                        'heroicon-m-check-badge' => 'delivered',
                        'heroicon-m-x-circle' => 'cancelled',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'pending_payment' => 'Pendiente de Pago',
                        'payment_confirmed' => 'Pago Confirmado',
                        'processing' => 'En Preparación',
                        'shipped' => 'En Camino',
                        'delivered' => 'Completado',
                        'cancelled' => 'Cancelado',
                        default => ucfirst($state),
                    }),
                
                Tables\Columns\TextColumn::make('currency')
                    ->label('Currency')
                    ->default('Mexican Peso')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total price')
                    ->money('usd')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('shipping_cost')
                    ->label('Shipping price')
                    ->money('usd')
                    ->default(0)
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Open')
                    ->url(fn (Order $record): string => route('filament.admin.resources.orders.edit', $record))
                    ->openUrlInNewTab()
                    ->color('primary'),
            ])
            ->paginated([5, 10, 25, 50]);
    }
}
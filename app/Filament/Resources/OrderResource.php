<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 1;

    /* public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    } */

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('number')
                                    ->label('Order Number')
                                    ->content(fn (?Order $record): ?string => $record?->number),

                                Forms\Components\ToggleButtons::make('status')
                                    ->inline()
                                    ->options([
                                        'pending_payment' => 'Pendiente de Pago',
                                        'payment_confirmed' => 'Pago Confirmado',
                                        'processing' => 'En Preparación',
                                        'shipped' => 'En Camino',
                                        'delivered' => 'Completado',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->colors([
                                        'pending_payment' => 'gray',
                                        'payment_confirmed' => 'info',
                                        'processing' => 'warning',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ])
                                    ->icons([
                                        'pending_payment' => 'heroicon-m-banknotes',
                                        'payment_confirmed' => 'heroicon-m-check-circle',
                                        'processing' => 'heroicon-m-arrow-path',
                                        'shipped' => 'heroicon-m-truck',
                                        'delivered' => 'heroicon-m-check-badge',
                                        'cancelled' => 'heroicon-m-x-circle',
                                    ])
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\Placeholder::make('currency')
                                    ->label('Currency')
                                    ->content(fn (?Order $record): ?string => strtoupper($record?->currency ?? '')),

                                Forms\Components\Placeholder::make('notes')
                                    ->label('Notes')
                                    ->columnSpanFull()
                                    ->content(fn (?Order $record): ?string => $record?->notes),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Shipping Details')
                            ->schema([
                                Forms\Components\Placeholder::make('customer_name')
                                    ->label('Customer Name')
                                    ->content(fn (Order $record): ?string => $record->user?->name . ' ' . $record->user?->last_name),

                                Forms\Components\Placeholder::make('customer_email')
                                    ->label('Customer Email')
                                    ->content(fn (Order $record): ?string => $record->user?->email),

                                Forms\Components\Placeholder::make('customer_phone')
                                    ->label('Phone')
                                    ->content(fn (Order $record): ?string => $record->user?->phone_number),

                                Forms\Components\Placeholder::make('shipping_address')
                                    ->label('Address')
                                    ->content(fn (Order $record): ?string => $record->shippingAddress?->address),

                                Forms\Components\Placeholder::make('location')
                                    ->label('Location')
                                    ->content(fn (Order $record): ?string => implode(', ', array_filter([
                                        $record->shippingAddress?->district,
                                        $record->shippingAddress?->province,
                                        $record->shippingAddress?->department
                                    ]))),

                                Forms\Components\Placeholder::make('reference')
                                    ->label('Reference')
                                    ->content(fn (Order $record): ?string => $record->shippingAddress?->reference),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Placeholder::make('created_at')
                                    ->label('Created at')
                                    ->content(fn (Order $record): ?string => $record->created_at?->diffForHumans()),

                                Forms\Components\Placeholder::make('updated_at')
                                    ->label('Last modified at')
                                    ->content(fn (Order $record): ?string => $record->updated_at?->diffForHumans()),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->recordUrl(null) // para que la fila no sea clickeable (edit)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->formatStateUsing(fn ($state, $record) => $record->user->name . ' ' . $record->user->last_name)
                    ->searchable(['name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Total')
                    ->money('S/.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('S/.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label('Discount')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('shipping_price')
                    ->label('Shipping')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending_payment' => 'gray',
                        'payment_confirmed' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending_payment' => 'Pendiente de Pago',
                        'payment_confirmed' => 'Pago Confirmado',
                        'processing' => 'En Preparación',
                        'shipped' => 'En Camino',
                        'delivered' => 'Completado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sale Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending_payment' => 'Pendiente de Pago',
                        'payment_confirmed' => 'Pago Confirmado',
                        'processing' => 'En Preparación',
                        'shipped' => 'En Camino',
                        'delivered' => 'Completado',
                        'cancelled' => 'Cancelado',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Desde'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}


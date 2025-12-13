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
                                Forms\Components\TextInput::make('number')
                                    ->default('OR-' . random_int(100000, 999999))
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(32)
                                    ->unique(Order::class, 'number', ignoreRecord: true),

                                Forms\Components\Select::make('user_id')
                                    ->label('Customer')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),

                                Forms\Components\ToggleButtons::make('status')
                                    ->inline()
                                    ->options([
                                        'pending' => 'New',
                                        'processing' => 'Processing',
                                        'shipped' => 'Shipped',
                                        'delivered' => 'Delivered',
                                        'cancelled' => 'Cancelled',
                                    ])
                                    ->colors([
                                        'pending' => 'info',
                                        'processing' => 'warning',
                                        'shipped' => 'success',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger',
                                    ])
                                    ->icons([
                                        'pending' => 'heroicon-m-sparkles',
                                        'processing' => 'heroicon-m-arrow-path',
                                        'shipped' => 'heroicon-m-truck',
                                        'delivered' => 'heroicon-m-check-badge',
                                        'cancelled' => 'heroicon-m-x-circle',
                                    ])
                                    ->required(),

                                Forms\Components\Select::make('currency')
                                    ->options([
                                        'usd' => 'USD',
                                        'eur' => 'EUR',
                                        'gmd' => 'GMD',
                                    ])
                                    ->default('usd')
                                    ->required()
                                    ->native(false),

                                Forms\Components\MarkdownEditor::make('notes')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Address')
                            ->schema([
                                Forms\Components\TextInput::make('shipping_street')
                                    ->label('Street address')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('shipping_city')
                                    ->label('City'),

                                Forms\Components\TextInput::make('shipping_state')
                                    ->label('State / Province'),

                                Forms\Components\TextInput::make('shipping_zip')
                                    ->label('Zip / Postal code'),

                                Forms\Components\TextInput::make('shipping_country')
                                    ->label('Country'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Order items')
                            ->headerActions([
                                Forms\Components\Actions\Action::make('reset')
                                    ->modalHeading('Are you sure?')
                                    ->modalDescription('All existing items will be removed from the order.')
                                    ->requiresConfirmation()
                                    ->color('danger')
                                    ->action(fn (Forms\Set $set) => $set('orderItems', [])),
                            ])
                            ->schema([
                                Forms\Components\Repeater::make('orderItems')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Product')
                                            ->options(\App\Models\Product::query()->pluck('name', 'id'))
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('price', \App\Models\Product::find($state)?->price ?? 0))
                                            ->distinct()
                                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                            ->columnSpan([
                                                'md' => 5,
                                            ])
                                            ->searchable(),

                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Quantity')
                                            ->numeric()
                                            ->default(1)
                                            ->columnSpan([
                                                'md' => 2,
                                            ])
                                            ->required(),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Unit Price')
                                            ->disabled()
                                            ->dehydrated()
                                            ->numeric()
                                            ->required()
                                            ->columnSpan([
                                                'md' => 3,
                                            ]),
                                    ])
                                    ->extraItemActions([
                                        Forms\Components\Actions\Action::make('openProduct')
                                            ->tooltip('Open product')
                                            ->icon('heroicon-m-arrow-top-right-on-square')
                                            ->url(fn ($record): ?string => $record?->product_id ? route('filament.admin.resources.products.edit', $record->product_id) : null)
                                            ->openUrlInNewTab()
                                            ->visible(fn ($record): bool => $record !== null),
                                    ])
                                    ->reorderable()
                                    ->defaultItems(1)
                                    ->hiddenLabel()
                                    ->columns([
                                        'md' => 10,
                                    ])
                                    ->required(),
                            ]),
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
            ->recordUrl(null)
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
                Tables\Columns\TextColumn::make('total_with_shipping')
                    ->label('Paid')
                    ->state(fn (Order $record): string => 'S/.' . number_format($record->total_amount + $record->shipping_amount, 2))
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Subtotal')
                    ->money('S/.')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_amount')
                    ->label('Discount')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('shipping_amount')
                    ->label('Shipping')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'warning',
                        'shipped' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Sale Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
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


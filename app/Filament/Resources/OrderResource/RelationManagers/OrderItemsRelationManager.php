<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('S/.')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                Tables\Columns\ImageColumn::make('variant_image') // Nombre único virtual
                    ->label('Imagen')
                    ->state(function ($record) {
                        $options = $record->options;
                        if (is_string($options)) {
                            $options = json_decode($options, true);
                        }
                        return $options['image'] ?? $record->product->image;
                    })
                    ->circular()
                    ->checkFileExistence(false) // Evita chequeos de disco si la url es http
                    ->action(
                        Tables\Actions\Action::make('view_large_image')
                            ->label('Imagen')
                            ->icon('heroicon-m-eye')
                            ->modalContent(function ($record) {
                                $options = $record->options;
                                if (is_string($options)) {
                                    $options = json_decode($options, true);
                                }
                                $image = $options['image'] ?? $record->product->image;
                                $url = filter_var($image, FILTER_VALIDATE_URL) ? $image : asset('storage/' . $image);
                                return view('filament.components.image-preview', ['url' => $url]);
                            })
                            ->modalSubmitAction(false)
                            ->modalCancelAction(false)
                    ),
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('options')
                    ->label('Variant')
                    ->formatStateUsing(function ($state, $record) {
                        $options = $record->options;
                        
                        if (empty($options)) {
                             return empty($state) ? '-' : 'State: ' . substr(json_encode($state), 0, 20);
                        }

                        if (is_string($options)) {
                            $options = json_decode($options, true);
                        }

                        if (!is_array($options)) return 'Not Array';

                        $parts = [];
                        if (isset($options['color'])) $parts[] = 'Color: ' . $options['color'];
                        if (isset($options['size'])) $parts[] = 'Talla: ' . $options['size'];
                        
                        return empty($parts) ? '-' : implode(', ', $parts);
                    }),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(),
                Tables\Columns\TextColumn::make('price')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('total')
                    ->state(fn ($record) => $record->quantity * $record->price)
                    ->money('S/.'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // No create action
            ])
            ->actions([
                // No edit/delete actions
            ])
            ->bulkActions([
                // No bulk actions
            ]);
    }
}

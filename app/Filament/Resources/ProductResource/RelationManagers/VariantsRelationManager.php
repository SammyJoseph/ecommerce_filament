<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use App\Models\ProductOption;
use App\Models\VariantSize;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Color Information')
                    ->schema([
                        Forms\Components\Select::make('color_id')
                            ->label('Color')
                            ->options(function (RelationManager $livewire) {
                                // Get color option for this product
                                $colorOption = $livewire->ownerRecord->options()
                                    ->where('type', 'color')
                                    ->first();

                                if ($colorOption) {
                                    return $colorOption->values()
                                        ->pluck('value', 'id');
                                }

                                return [];
                            })
                            ->required()
                            ->reactive()
                            ->helperText('Select the color for this variant'),

                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible')
                            ->default(true),

                        SpatieMediaLibraryFileUpload::make('variant_images')
                            ->label('Variant Image (Color Image)')
                            ->collection('variant_images')
                            ->image()
                            ->imageEditor()
                            ->conversion('preview')
                            ->helperText('Upload an image representing this color')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Sizes & Stock')
                    ->schema([
                        Forms\Components\Repeater::make('sizes')
                            ->relationship('sizes')
                            ->schema([
                                Forms\Components\Select::make('product_option_value_id')
                                    ->label('Size')
                                    ->options(function (RelationManager $livewire) {
                                        // Get size option for this product
                                        $sizeOption = $livewire->ownerRecord->options()
                                            ->where('type', 'size')
                                            ->first();

                                        if ($sizeOption) {
                                            return $sizeOption->values()
                                                ->pluck('value', 'id');
                                        }

                                        return [];
                                    })
                                    ->required()
                                    ->disableOptionWhen(function ($value, $state, Forms\Get $get) {
                                        // Disable already selected sizes in other rows
                                        $selectedSizes = collect($get('../../sizes'))
                                            ->pluck('product_option_value_id')
                                            ->filter()
                                            ->all();
                                        
                                        return in_array($value, $selectedSizes) && $value != $state;
                                    }),

                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix('S/.')
                                    ->required(),

                                Forms\Components\TextInput::make('sale_price')
                                    ->numeric()
                                    ->prefix('S/.'),

                                Forms\Components\TextInput::make('stock')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ])
                            ->columns(4)
                            ->defaultItems(1)
                            ->addActionLabel('Add Size')
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                $state['product_option_value_id'] 
                                    ? \App\Models\ProductOptionValue::find($state['product_option_value_id'])?->value 
                                    : null
                            ),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('color.value')
            ->columns([
                SpatieMediaLibraryImageColumn::make('variant_images')
                    ->label('Image')
                    ->collection('variant_images')
                    ->conversion('thumb'),

                Tables\Columns\TextColumn::make('color.value')
                    ->label('Color')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return $record->color ? $record->color->value : 'N/A';
                    }),

                Tables\Columns\TextColumn::make('sizes_list')
                    ->label('Available Sizes')
                    ->getStateUsing(function ($record) {
                        return $record->sizes->pluck('size.value')->implode(', ') ?: 'No sizes';
                    }),

                Tables\Columns\TextColumn::make('price_range')
                    ->label('Price Range')
                    ->getStateUsing(function ($record) {
                        $sizes = $record->sizes;
                        if ($sizes->isEmpty()) {
                            return 'N/A';
                        }
                        
                        $minPrice = $sizes->min('price');
                        $maxPrice = $sizes->max('price');
                        
                        if ($minPrice == $maxPrice) {
                            return 'S/. ' . number_format($minPrice, 2);
                        }
                        
                        return 'S/. ' . number_format($minPrice, 2) . ' - S/. ' . number_format($maxPrice, 2);
                    }),

                Tables\Columns\TextColumn::make('total_stock')
                    ->label('Total Stock')
                    ->getStateUsing(function ($record) {
                        return $record->sizes->sum('stock');
                    }),

                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Remove sizes from main data as it's handled by relationship
                        unset($data['sizes']);
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

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

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema(function (RelationManager $livewire) {
                        return collect($livewire->ownerRecord->options)
                            ->map(function ($option) {
                                return Forms\Components\Select::make('options.' . $option->id)
                                    ->label($option->name)
                                    ->options(
                                        $option
                                            ->values()
                                            ->pluck('value', 'id')
                                    )
                                    ->required();
                            })->toArray();
                    }),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('S/.'),
                Forms\Components\TextInput::make('sale_price')
                    ->numeric()
                    ->prefix('S/.'),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_visible')
                    ->label('Visible')
                    ->default(true),
                SpatieMediaLibraryFileUpload::make('variant_images')
                    ->label('Variant Image')
                    ->collection('variant_images')
                    ->image()
                    ->imageEditor()
                    ->conversion('preview')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                SpatieMediaLibraryImageColumn::make('variant_images')
                    ->label('Image')
                    ->collection('variant_images')
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->options->map(function ($option) {
                            if ($option->option) {
                                return $option->option->name . ': ' . $option->value;
                            }
                            return '';
                        })->implode(' - ');
                    }),

                Tables\Columns\TextColumn::make('price')
                    ->money('S/.'),
                Tables\Columns\TextColumn::make('sale_price')
                    ->money('S/.')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function (RelationManager $livewire, array $data) {
                        $variantData = collect($data)->except('options')->toArray();
                        $variant = $livewire->ownerRecord->variants()->create($variantData);
                        $variant->options()->sync(collect($data['options'])->values());
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, $record) {
                        $record->update(collect($data)->except('options')->toArray());
                        $record->options()->sync(collect($data['options'])->values());

                        return $data;
                    })
                    ->fillForm(function ($record) {
                        $data = $record->toArray();
                        foreach ($record->options as $option) {
                            $data['options'][$option->option->id] = $option->id;
                        }

                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

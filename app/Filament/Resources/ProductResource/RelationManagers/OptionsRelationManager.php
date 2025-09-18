<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'options';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->options([
                        'text' => 'Text',
                        'color' => 'Color',
                        'size' => 'Size',
                        'select' => 'Select'
                    ])
                    ->default('text')
                    ->required()
                    ->live(),
                Forms\Components\Repeater::make('values')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make('value')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\ColorPicker::make('color_code')
                            ->label('Color Code')
                            ->visible(fn (Forms\Get $get) => $get('../../type') === 'color')
                            ->required(fn (Forms\Get $get) => $get('../../type') === 'color')
                            ->default('#000000'),
                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'color' => 'success',
                        'size' => 'warning',
                        'select' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('values_count')
                    ->label('Values')
                    ->counts('values'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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

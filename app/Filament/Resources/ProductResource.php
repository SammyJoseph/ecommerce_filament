<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Product::class, 'slug', ignoreRecord: true),
                    Forms\Components\RichEditor::make('description') // Un editor enriquecido
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('S/.'), // O tu moneda
                    Forms\Components\TextInput::make('stock')
                        ->required()
                        ->numeric()
                        ->default(0),
                ])->columns(2)->columnSpan(2), // Ocupa 2/3 del ancho

            Forms\Components\Group::make()
                ->schema([
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\Toggle::make('is_visible')
                        ->label('Visible')
                        ->default(true),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured')
                        ->default(false),
                    SpatieMediaLibraryFileUpload::make('product_images') // 'product_image' es el nombre de la colección que usarás
                        ->label('Main Image')
                        ->collection('product_images') // DEBE coincidir con lo que esperas en el modelo
                        // ->multiple() // Si quieres permitir múltiples imágenes
                        ->image() // Para que valide que es una imagen y muestre previsualización
                        ->imageEditor() // Habilita un editor básico de imágenes
                        ->conversion('preview')
                        ->reorderable() // Si son múltiples
                        // ->responsiveImages() // Genera imágenes responsivas (necesita configuración de conversiones)
                        ->columnSpanFull(),
                ])->columns(1)->columnSpan(1), // Ocupa 1/3 del ancho

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->sortable()
                ->label('ID'),
            SpatieMediaLibraryImageColumn::make('product_images')
            ->label('Main Image')
            ->collection('product_images')
            ->conversion('thumb')
            ->columnSpanFull(),
            
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('category.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('price')
                ->money('S/.') // Formatear como moneda
                ->sortable(),
            Tables\Columns\TextColumn::make('stock')
                ->numeric()
                ->sortable(),
            Tables\Columns\IconColumn::make('is_visible')
                ->label('Visible')
                ->boolean(),
            Tables\Columns\IconColumn::make('is_featured')
                ->label('Featured')
                ->boolean(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('category_id')
                ->relationship('category', 'name')
                ->label('Category'),
            Tables\Filters\TernaryFilter::make('is_visible'),
            Tables\Filters\TernaryFilter::make('is_featured'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductReviewResource\Pages;
use App\Filament\Resources\ProductReviewResource\RelationManagers;
use App\Models\ProductReview;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductReviewResource extends Resource
{
    protected static ?string $model = ProductReview::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Products';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Reviews';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->has('reviews')
            ->withCount('reviews')
            ->withMax('reviews', 'created_at')
            ->orderByDesc('reviews_max_created_at');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(12)
                    ->schema([
                        Forms\Components\Placeholder::make('image')
                            ->hiddenLabel()
                            ->content(fn($record): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString(
                                '<div x-data="{ open: false }">
                                    <img 
                                        src="' . $record?->getFirstMediaUrl('product_images', 'thumb') . '" 
                                        class="w-16 h-16 object-cover rounded-lg cursor-pointer"
                                        @click="open = true"
                                    >
                                    <template x-teleport="body">
                                        <div 
                                            x-show="open" 
                                            class="fixed inset-0 z-[99999] flex items-center justify-center bg-black/50"
                                            @click="open = false"
                                            style="display: none;"
                                        >
                                            <img 
                                                src="' . $record?->getFirstMediaUrl('product_images') . '" 
                                                class="max-w-screen max-h-screen p-4 object-contain"
                                            >
                                        </div>
                                    </template>
                                </div>'
                            ))
                            ->columnSpan(1),

                        Forms\Components\Placeholder::make('name')
                            ->label('Product')
                            ->content(fn($record) => $record?->name)
                            ->columnSpan(11),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviews_count')
                    ->label('Comments Count')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviews_max_created_at')
                    ->label('Latest Review')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductReviews::route('/'),
            'edit' => Pages\EditProductReview::route('/{record}/edit'),
        ];
    }
}

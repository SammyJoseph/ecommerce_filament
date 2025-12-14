<?php

namespace App\Filament\Pages;

use App\Settings\HomePageSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageHomePage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Home Page';
    protected static ?string $navigationLabel = 'Static Content';

    protected static string $settings = HomePageSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Home Page')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('About Us')
                            ->schema([
                                Forms\Components\TextInput::make('about_us_title')
                                    ->label('Title')
                                    ->rules(['required'])
                                    ->validationAttribute('title'),
                                Forms\Components\Textarea::make('about_us_text')
                                    ->label('Content')
                                    ->rows(5)
                                    ->rules(['required'])
                                    ->validationAttribute('content'),
                                Forms\Components\FileUpload::make('about_us_image')
                                    ->label('Image')
                                    ->image()
                                    ->directory('about-us'),
                                Forms\Components\TextInput::make('about_us_author')
                                    ->label('Author Signature')
                                    ->rules(['required'])
                                    ->validationAttribute('author signature'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Banners')
                            ->schema([
                                Forms\Components\Repeater::make('banners')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->rules(['required'])
                                            ->validationAttribute('banner title'),
                                        Forms\Components\Textarea::make('description')
                                            ->rows(2),
                                        Forms\Components\TextInput::make('link')
                                            ->rules(['nullable', 'url'])
                                            ->validationAttribute('banner link'),
                                        Forms\Components\TextInput::make('text_color')
                                            ->label('Text Color (Optional)')
                                            ->placeholder('#000000'),
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('banners')
                                            ->rules(['required'])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->maxItems(2)
                            ]),
                        Forms\Components\Tabs\Tab::make('Instagram')
                            ->schema([
                                Forms\Components\TextInput::make('instagram_title')
                                    ->label('Title')
                                    ->default('Our Instagram')
                                    ->rules(['required'])
                                    ->validationAttribute('title'),
                                Forms\Components\TextInput::make('instagram_hashtag')
                                    ->label('Hashtag')
                                    ->default('#monkeylover')
                                    ->rules(['required'])
                                    ->validationAttribute('hashtag'),
                                Forms\Components\Repeater::make('instagram_items')
                                    ->label('Images (Max 5)')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('instagram')
                                            ->rules(['required'])
                                            ->validationAttribute('image'),
                                        Forms\Components\TextInput::make('link')
                                            ->label('Link')
                                            ->rules(['nullable', 'url']),
                                    ])
                                    ->grid(5)
                                    ->maxItems(5)
                            ]),
                        Forms\Components\Tabs\Tab::make('Brands')
                            ->schema([
                                Forms\Components\Repeater::make('brand_logos')
                                    ->label('Brand Logos')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->image()
                                            ->directory('brands')
                                            ->rules(['required'])
                                            ->validationAttribute('image'),
                                    ])
                                    ->grid(5)
                            ]),
                    ])->columnSpanFull()
            ]);
    }
}

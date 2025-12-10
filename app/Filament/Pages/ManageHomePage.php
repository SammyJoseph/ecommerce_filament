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
                    ])->columnSpanFull()
            ]);
    }
}

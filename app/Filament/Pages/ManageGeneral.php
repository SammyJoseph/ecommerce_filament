<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\SettingsPage;

class ManageGeneral extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';
    protected static ?string $navigationGroup = 'Site Settings';
    protected static ?string $navigationLabel = 'General';
    protected static ?int $navigationSort = 0;

    protected static string $settings = GeneralSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('General Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Styling')
                            ->schema([
                                Forms\Components\Section::make('Colors')
                                    ->schema([
                                        Forms\Components\ColorPicker::make('main_background_color')
                                            ->label('Main Background Color')
                                            ->placeholder('#f0f4f6 or rgba(...)')
                                            ->helperText('Select visually or type manually (Hex, RGB, RGBA)')
                                            ->required(),
                                        Forms\Components\ColorPicker::make('secondary_color')
                                            ->label('Secondary Background Color')
                                            ->placeholder('#ffffff')
                                            ->helperText('Select visually or type manually')
                                            ->required(),
                                    ])->columns(2),
                                
                                Forms\Components\Section::make('Fonts')
                                    ->schema([
                                        Forms\Components\Select::make('h1_font_family')
                                            ->label('H1 Font Family')
                                            ->options(function (Get $get) {
                                                $fonts = $get('fonts') ?? [];
                                                $options = [];
                                                foreach ($fonts as $font) {
                                                    if (!empty($font['name'])) {
                                                        $options[$font['name']] = $font['name'];
                                                    }
                                                }
                                                return $options;
                                            })
                                            ->live()
                                            ->required(),
                                        Forms\Components\Repeater::make('fonts')
                                            ->label('Google Fonts Library')
                                            ->schema([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('Font Family Name')
                                                    ->placeholder('e.g., Heebo')
                                                    ->required(),
                                                Forms\Components\Textarea::make('embed_code')
                                                    ->label('Embed Code (link or style block)')
                                                    ->placeholder('<link href="https://fonts.googleapis.com..." rel="stylesheet">')
                                                    ->rows(3)
                                                    ->required(),
                                            ])
                                            ->columns(2)
                                            ->defaultItems(1),                                                                            
                                    ]),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Identity & SEO')
                            ->schema([
                                Forms\Components\TextInput::make('site_name')
                                    ->label('Site Name')
                                    ->required(),
                                Forms\Components\Textarea::make('meta_description')
                                    ->label('Meta Description')
                                    ->rows(3),
                                Forms\Components\FileUpload::make('site_logo')
                                    ->label('Site Logo')
                                    ->image()
                                    ->directory('site'),
                                Forms\Components\FileUpload::make('site_favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->directory('site'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contact & Footer')
                            ->schema([
                                Forms\Components\TextInput::make('contact_phone')
                                    ->label('Contact Phone')
                                    ->required(),
                                Forms\Components\TextInput::make('contact_address')
                                    ->label('Contact Address')
                                    ->required(),
                                Forms\Components\TextInput::make('copyright_text')
                                    ->label('Copyright Text')
                                    ->required(),
                            ]),
                    ])->columnSpanFull()
            ]);
    }
}

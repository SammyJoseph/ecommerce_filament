<?php

namespace App\Filament\Pages;

use App\Settings\HeaderSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageHeader extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Site Settings';

    protected static ?string $navigationLabel = 'Header';

    protected static string $settings = HeaderSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Header Settings')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Top Bar')
                            ->schema([
                                Forms\Components\TextInput::make('top_message_text')
                                    ->label('Promotion Text')
                                    ->default('FREE SHIPPING world wide for all orders over')
                                    ->required(),
                                Forms\Components\TextInput::make('top_message_amount')
                                    ->label('Promotion Amount')
                                    ->default('$199')
                                    ->required(),
                                Forms\Components\TextInput::make('track_order_text')
                                    ->label('Track Order Label')
                                    ->default('Track Your Order')
                                    ->required(),
                                Forms\Components\TextInput::make('track_order_url')
                                    ->label('Track Order URL')
                                    ->default('order-tracking.html')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Languages & Currencies')
                            ->schema([
                                Forms\Components\Repeater::make('languages')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('url')->required(),
                                    ])
                                    ->columns(2)
                                    ->label('Languages'),
                                Forms\Components\Repeater::make('currencies')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')->required(),
                                        Forms\Components\TextInput::make('url')->required(),
                                    ])
                                    ->columns(2)
                                    ->label('Currencies'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Social Media')
                            ->schema([
                                Forms\Components\Repeater::make('social_links')
                                    ->schema([
                                        Forms\Components\TextInput::make('icon')
                                            ->label('Icon Class (e.g., icon-social-twitter)')
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label('URL')
                                            ->url()
                                            ->required(),
                                    ])
                                    ->columns(2)
                                    ->label('Social Links'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}

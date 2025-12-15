<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('preview')
                ->label('Preview Changes')
                ->color('info')
                ->action(function ($record, $livewire) {
                    $data = $livewire->form->getState();
                    $token = \Illuminate\Support\Str::random(32);
                    \Illuminate\Support\Facades\Cache::put('blog_preview_' . $token, $data, 300);
                    
                    $url = route('blog.preview', ['token' => $token]);
                    
                    $livewire->js("window.open('{$url}', '_blank');");
                }),
            Actions\DeleteAction::make(),
        ];
    }
}

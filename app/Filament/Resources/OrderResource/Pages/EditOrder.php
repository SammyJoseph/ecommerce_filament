<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Guardar cambios')
                ->action('save'),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $originalStatus = $record->status;
        
        $record->update($data);
        
        if ($record->status !== $originalStatus && $record->user) {
            try {
                \Illuminate\Support\Facades\Mail::to($record->user)->send(new \App\Mail\OrderStatusChanged($record));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Illuminate\Support\Facades\Log::error('Error sending order status update email: ' . $e->getMessage());
                
                \Filament\Notifications\Notification::make()
                    ->title('Error sending email')
                    ->body('Could not send status update email.')
                    ->danger()
                    ->send();
            }
        }
        
        return $record;
    }
}

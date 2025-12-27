<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\User;

class SubscribeUser extends Component
{
    public $email = '';
    public $subscribed = false;
    public $message = '';

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email',
        ]);

        $apiKey = config('services.brevo.key');
        $listId = config('services.brevo.list_id');

        if (! $apiKey || ! $listId) {
            $this->addError('email', 'Service configuration is missing.');
            Log::error('Brevo credentials missing in config/services.php');
            return;
        }

        try {
            $response = Http::withHeaders([
                'api-key' => $apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.brevo.com/v3/contacts', [
                'email' => $this->email,
                'listIds' => [(int) $listId],
                'updateEnabled' => false,
            ]);

            if ($response->successful() || $response->status() === 201 || $response->status() === 204) {
                $this->subscribed = true;
                $this->message = 'Tu suscripción se ha realizado correctamente.';
                
                $user = User::where('email', $this->email)->first();
                if ($user) {
                    $user->update(['is_subscribed' => true]);
                }

                $this->reset('email');
            } elseif ($response->status() === 400 && str_contains(strtolower($response->body()), 'duplicate')) {
                $this->subscribed = true;
                $this->message = 'Ya estás suscrito a nuestro boletín por correo.';
                
                $user = User::where('email', $this->email)->first();
                if ($user) {
                    $user->update(['is_subscribed' => true]);
                }

                $this->reset('email'); 
            } else {
                Log::error('Brevo subscription failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $this->addError('email', 'Unable to subscribe at this time. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Brevo subscription exception: ' . $e->getMessage());
            $this->addError('email', 'An error occurred. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.subscribe-user');
    }
}

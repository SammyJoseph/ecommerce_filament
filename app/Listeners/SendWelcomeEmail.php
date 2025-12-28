<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\WelcomeEmail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        try {
            Mail::to($event->user)->send(new WelcomeEmail($event->user));
        } catch (\Exception $e) {
            Log::error('[SendWelcomeEmail] Error al enviar email de bienvenida', [
                'user_id' => $event->user->id ?? 'N/A',
                'user_email' => $event->user->email ?? 'N/A',
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
            ]);
        }
    }
}

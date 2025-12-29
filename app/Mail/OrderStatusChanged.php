<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $status = $this->order->status;
        
        $subjects = [
            'pending_payment' => 'Hemos recibido tu pedido #' . $this->order->number,
            'payment_confirmed' => 'Pago confirmado para el pedido #' . $this->order->number,
            'processing' => 'Tu pedido #' . $this->order->number . ' está en preparación',
            'shipped' => 'Tu pedido #' . $this->order->number . ' está en camino',
            'delivered' => 'Tu pedido #' . $this->order->number . ' ha sido entregado',
            'cancelled' => 'Actualización sobre tu pedido #' . $this->order->number,
        ];

        return new Envelope(
            subject: $subjects[$status] ?? 'Actualización de tu pedido #' . $this->order->number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

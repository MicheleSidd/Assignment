<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiscountCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param string $discountCode
     */
    public function __construct(string $discountCode)
    {
        $this->discountCode = $discountCode;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->view('emails.discount_code') // Specifica la vista dell'email
                    ->with(['discountCode' => $this->discountCode]); // Passa i dati alla vista
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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

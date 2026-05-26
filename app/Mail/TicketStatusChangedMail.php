<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public string $oldStatus;

    public function __construct(Ticket $ticket, string $oldStatus)
    {
        $this->ticket = $ticket;
        $this->oldStatus = $oldStatus;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jūsų problemos būsena pasikeitė: ' . $this->ticket->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-status-changed',
        );
    }
}
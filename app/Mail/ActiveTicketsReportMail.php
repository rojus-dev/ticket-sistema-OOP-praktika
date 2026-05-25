<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActiveTicketsReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;

    public function __construct($pdfContent)
    {
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Aktyvių problemų PDF ataskaita',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.active-tickets-report',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                'aktyviu-problemu-ataskaita.pdf'
            )->withMime('application/pdf'),
        ];
    }
}
<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCommentAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Ticket $ticket;
    public Comment $comment;

    public function __construct(Ticket $ticket, Comment $comment)
    {
        $this->ticket = $ticket;
        $this->comment = $comment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Naujas komentaras prie jūsų problemos: ' . $this->ticket->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-comment-added',
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use App\Mail\TicketCommentAddedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment' => 'required|max:2000',
        ]);

        $comment = Comment::create([
            'ticket_id' => $ticket->id,
            'user_id'   => Auth::id(),
            'comment'   => $request->comment,
        ]);

        if ($ticket->user_id !== Auth::id()) {
            try {
                $comment->load('user');
                Mail::to($ticket->user->email)
                    ->send(new TicketCommentAddedMail($ticket->load(['user', 'category']), $comment));
            } catch (\Exception $e) {
                logger()->error('Nepavyko išsiųsti komentaro pranešimo: ' . $e->getMessage());
            }
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Komentaras pridėtas.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ActiveTicketsReportMail;
use App\Mail\TicketStatusChangedMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['user', 'category'])->latest()->get();

        $newCount        = $tickets->where('status', 'Naujas')->count();
        $inProgressCount = $tickets->where('status', 'Vykdomas')->count();
        $doneCount       = $tickets->where('status', 'Užbaigtas')->count();

        return view('tickets.index', compact('tickets', 'newCount', 'inProgressCount', 'doneCount'));
    }
    public function create()
    {
        $categories = Category::all();
        $statuses   = Ticket::STATUSES;

        return view('tickets.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'description' => 'required',
        ]);

        Ticket::create([
            'user_id'     => Auth::id(),
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => Ticket::STATUSES[0],
        ]);

        return redirect()->route('tickets.index')->with('success', 'Problema sėkmingai užregistruota.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'comments.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        $statuses   = Ticket::STATUSES;

        return view('tickets.edit', compact('ticket', 'categories', 'statuses'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin() && !Auth::user()->isSupport()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|max:255',
            'description' => 'required',
        ]);

        $oldStatus    = $ticket->status;
        $statusChanged = false;

        $updateData = [
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
        ];

        if (Auth::user()->isAdmin() || Auth::user()->isSupport()) {
            $newStatus = $request->status;
            if ($newStatus && in_array($newStatus, Ticket::STATUSES) && $newStatus !== $oldStatus) {
                $updateData['status'] = $newStatus;
                $statusChanged = true;
            }
        }

        $ticket->update($updateData);

        if ($statusChanged) {
            try {
                Mail::to($ticket->user->email)
                    ->send(new TicketStatusChangedMail($ticket->fresh(['user', 'category']), $oldStatus));
            } catch (\Exception $e) {
                logger()->error('Nepavyko išsiųsti statuso pranešimo: ' . $e->getMessage());
            }
        }

        return redirect()->route('tickets.index')->with('success', 'Problema sėkmingai atnaujinta.');
    }

    public function activeReportPdf()
    {
        $tickets = Ticket::with(['user', 'category'])
            ->whereIn('status', array_filter(Ticket::STATUSES, fn($s) => $s !== 'Užbaigtas'))
            ->latest()
            ->get();

        $pdf = Pdf::loadView('tickets.active-report-pdf', compact('tickets'));

        return $pdf->download('aktyviu-problemu-ataskaita.pdf');
    }

    public function sendActiveReportPdf()
    {
        $tickets = Ticket::with(['user', 'category'])
            ->whereIn('status', array_filter(Ticket::STATUSES, fn($s) => $s !== 'Užbaigtas'))
            ->latest()
            ->get();

        $pdf   = Pdf::loadView('tickets.active-report-pdf', compact('tickets'));
        $email = Setting::where('key', 'report_email')->value('value');

        if (!$email) {
            return redirect()->route('tickets.index')->with('error', 'Ataskaitos el. paštas nenurodytas nustatymuose.');
        }

        Mail::to($email)->send(new ActiveTicketsReportMail($pdf->output()));

        return redirect()->route('tickets.index')->with('success', 'PDF ataskaita išsiųsta el. paštu: ' . $email);
    }

    public function destroy(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Problema pašalinta.');
    }
}
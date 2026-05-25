<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ActiveTicketsReportMail;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['user', 'category'])
            ->latest()
            ->get();

        $newCount = Ticket::where('status', 'Naujas')->count();
        $inProgressCount = Ticket::where('status', 'Vykdomas')->count();
        $doneCount = Ticket::where('status', 'Užbaigtas')->count();

        return view('tickets.index', compact(
            'tickets',
            'newCount',
            'inProgressCount',
            'doneCount'
        ));
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        Ticket::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Naujas',
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Problema sėkmingai užregistruota.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'comments.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Neturite teisės redaguoti šios problemos.');
        }

        $categories = Category::all();

        return view('tickets.edit', compact('ticket', 'categories'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (
            Auth::id() !== $ticket->user_id &&
            !Auth::user()->isAdmin() &&
            !Auth::user()->isSupport()
        ) {
            abort(403, 'Neturite teisės atnaujinti šios problemos.');
        }

        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        $ticket->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tickets.index')
            ->with('success', 'Problema sėkmingai atnaujinta.');
    }

    public function activeReportPdf()
    {
    $tickets = Ticket::with(['user', 'category'])
        ->where('status', '!=', 'Užbaigtas')
        ->latest()
        ->get();

        $pdf = Pdf::loadView('tickets.active-report-pdf', compact('tickets'));

        return $pdf->download('aktyviu-problemu-ataskaita.pdf');
    }

    public function sendActiveReportPdf()
    {
        $tickets = Ticket::with(['user', 'category'])
            ->where('status', '!=', 'Užbaigtas')
            ->latest()
            ->get();

        $pdf = Pdf::loadView('tickets.active-report-pdf', compact('tickets'));

        $email = Setting::where('key', 'report_email')->value('value');

        Mail::to($email)->send(new ActiveTicketsReportMail($pdf->output()));

        return redirect()->route('tickets.index')->with('success', 'PDF ataskaita išsiųsta el. paštu: ' . $email);
    }

    public function destroy(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Neturite teisės pašalinti šios problemos.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Problema pašalinta.');
    }
}
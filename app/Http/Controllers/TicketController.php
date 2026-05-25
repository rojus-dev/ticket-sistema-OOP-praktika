<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['user', 'category'])
            ->latest()
            ->get();

        return view('tickets.index', compact('tickets'));
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
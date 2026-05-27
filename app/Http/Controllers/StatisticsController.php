<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        $statusCounts = collect(Ticket::STATUSES)->mapWithKeys(
            fn($status) => [$status => Ticket::where('status', $status)->count()]
        );

        $categoryCounts = Category::withCount('tickets')
            ->having('tickets_count', '>', 0)
            ->get()
            ->pluck('tickets_count', 'name');

        $dailyCounts = Ticket::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $dates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[$date] = $dailyCounts[$date] ?? 0;
        }

        return view('statistics.index', compact('statusCounts', 'categoryCounts', 'dates'));
    }
}
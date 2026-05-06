<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $upcomingEvents = Agenda::withCount('registrations')
                                ->where('status', 'upcoming')
                                ->where('event_date', '>=', now())
                                ->orderBy('event_date', 'asc')
                                ->paginate(5, ['*'], 'upcoming_page');
                                
        $pastEvents = Agenda::where(function($query) {
                                $query->where('status', 'completed')
                                      ->orWhere('event_date', '<', now());
                            })
                            ->where('status', '!=', 'cancelled')
                            ->orderBy('event_date', 'desc')
                            ->paginate(9, ['*'], 'past_page');

        return view('pages.event', compact('upcomingEvents', 'pastEvents'));
    }

    public function show($slug)
    {
        $event = Agenda::where('slug', $slug)
                       ->withCount('registrations')
                       ->firstOrFail();
        return view('pages.event-detail', compact('event'));
    }
}

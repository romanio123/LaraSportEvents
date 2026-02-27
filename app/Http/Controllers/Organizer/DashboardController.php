<?php

namespace App\Http\Controllers\Organizer;

use App\Models\Event;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $totalEvents = $events->count();
        $upcomingEvents = Event::where('user_id', auth()->id())
            ->where('date', '>', now())
            ->count();
        $totalParticipants = $events->sum('current_participants');

        return view('organizer.dashboard', compact(
            'events',
            'totalEvents',
            'upcomingEvents',
            'totalParticipants'
        ));
    }
}

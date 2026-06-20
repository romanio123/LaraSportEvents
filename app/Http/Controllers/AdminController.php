<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\SupportTicket;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $eventsCount = Event::count();
        $adminsCount = User::where('role', 'admin')->count();
        $organizersCount = User::where('is_organizer', true)->count();
        $newTicketsCount = SupportTicket::where('status', 'open')->count();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.index', compact(
            'usersCount',
            'eventsCount',
            'adminsCount',
            'organizersCount',
            'recentUsers',
            'newTicketsCount'
        ));
    }

    public function events()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function allEvents()
    {
        try {
            $events = \App\Models\Event::with('user')->latest()->paginate(15);
            return view('admin.events.all', compact('events'));
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error');
        }
    }
}



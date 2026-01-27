<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $eventsCount = Event::count();
        $adminsCount = User::where('role', 'admin')->count();
        $organizersCount = User::where('is_organizer', true)->count();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.index', compact(
            'usersCount',
            'eventsCount',
            'adminsCount',
            'organizersCount',
            'recentUsers'
        ));
    }

    public function events()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }
}

<?php
// app/Http/Controllers/OrganizerController.php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizerController extends Controller
{
    /**
     * Панель организатора
     */
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('user_id', $user->id);

        return view('organizer.index', compact('user', 'events'));
    }


}

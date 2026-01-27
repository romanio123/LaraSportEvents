<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::with('user')
            ->where('date', '>', now())
            ->orderBy('date')
            ->take(6)
            ->get();

        return view('home', ['events' => $events]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $totalEvents = Event::count();
    $totalUsers = User::count();
    $totalCities = Event::distinct('city')->count('city');
    $totalCategories = Event::distinct('category')->count('category');
    $upcomingEvents = Event::where('date', '>=', now())
        ->orderBy('date', 'asc')
        ->take(5)
        ->get();
    
    return view('home', compact('totalEvents', 'totalUsers', 'totalCities', 'totalCategories', 'upcomingEvents'));
}
}

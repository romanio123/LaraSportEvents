<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $adminsCount = User::where('role', 'admin')->count();

            return view('profile.index', [
                'user' => $user,
                'adminsCount' => $adminsCount
            ]);
        }
        return view('profile.index', compact('user'));
    }
}

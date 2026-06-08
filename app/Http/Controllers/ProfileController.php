<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему');
        }
        
        $user = Auth::user();
        
        // Мероприятия, на которые зарегистрирован пользователь
        $registeredEvents = Event::whereHas('registrations', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->paginate(6);
        
        // Пройденные мероприятия
        $completedEvents = Event::whereHas('registrations', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('date', '<', now())->count();
        
        // Созданные мероприятия
        $myEvents = collect();
        $myEventsCount = 0;
        
        if ($user->is_organizer) {
            $myEvents = Event::where('user_id', $user->id)->latest()->paginate(6);
            $myEventsCount = Event::where('user_id', $user->id)->count();
        }
        
        return view('profile', compact(
            'user', 
            'registeredEvents', 
            'completedEvents', 
            'myEvents', 
            'myEventsCount'
        ));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Обновляем имя
        if ($request->has('name') && $request->name) {
            $user->name = $request->name;
        }
        
        // Обновляем email
        if ($request->has('email') && $request->email) {
            $user->email = $request->email;
        }
        
        // Обработка аватарки
        if ($request->hasFile('avatar')) {
            // Удаляем старую аватарку если есть
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        
        $user->save();
        
        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен!');
    }
    
    // Новый метод для удаления аватарки
    public function deleteAvatar()
    {
        $user = Auth::user();
        
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
            $user->save();
            
            return redirect()->route('profile')->with('success', 'Аватарка успешно удалена!');
        }
        
        return redirect()->route('profile')->with('error', 'Аватарка не найдена');
    }
}
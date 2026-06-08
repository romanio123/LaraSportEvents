<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    
    // Страница поддержки (форма)
    public function index()
    {
        $userTickets = SupportTicket::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('support.index', compact('userTickets'));
    }
    
    // Создание обращения
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10'
        ]);
        
        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'open',
            'priority' => 'medium'
        ]);
        
        return redirect()->route('support.show', $ticket)
            ->with('success', 'Обращение создано! Мы ответим в ближайшее время.');
    }
    
    // Просмотр обращения
    public function show(SupportTicket $ticket)
    {
        if (Auth::user()->role !== 'admin' && $ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        $ticket->load('messages.user');
        
        return view('support.show', compact('ticket'));
    }
    
    // Отправка сообщения
    public function message(Request $request, SupportTicket $ticket)
    {
        if (Auth::user()->role !== 'admin' && $ticket->user_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'message' => 'required|string|min:1'
        ]);
        
        SupportMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => Auth::user()->role === 'admin'
        ]);
        
        // Обновляем статус тикета
        if (Auth::user()->role === 'admin') {
            $ticket->update(['status' => 'in_progress']);
        } else {
            $ticket->update(['status' => 'open']);
        }
        
        return back()->with('success', 'Сообщение отправлено');
    }
    
    // Закрытие обращения (админ)
    public function close(SupportTicket $ticket)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $ticket->update(['status' => 'closed']);
        
        return redirect()->route('admin.support')->with('success', 'Обращение закрыто');
    }
    
    // Админ-панель поддержки
    public function adminIndex()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $tickets = SupportTicket::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $tickets = $tickets->sortBy(function ($ticket) {
            $order = [
                'open' => 1,
                'in_progress' => 2,
                'closed' => 3
            ];
            return $order[$ticket->status] ?? 4;
        });
        
        $stats = [
            'open' => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'closed' => SupportTicket::where('status', 'closed')->count(),
            'total' => SupportTicket::count()
        ];
            
        return view('admin.support', compact('tickets', 'stats'));
    }
}
@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="font-size: 2rem; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0;">
                Панель организатора
            </h1>
            <a href="{{ route('organizer.events.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease; border: none; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                <i class="fas fa-plus"></i> Создать мероприятие
            </a>
        </div>
 
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-alt" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: 600;">{{ $totalEvents ?? 0 }}</div>
                        <div style="color: #6c757d;">Всего мероприятий</div>
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-arrow-up" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: 600;">{{ $upcomingEvents ?? 0 }}</div>
                        <div style="color: #6c757d;">Предстоящих</div>
                    </div>
                </div>
            </div>

            <div style="background: white; padding: 1.5rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-users" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 2rem; font-weight: 600;">{{ $totalParticipants ?? 0 }}</div>
                        <div style="color: #6c757d;">Всего участников</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #333; margin: 0;">Последние мероприятия</h2>
            <div style="display: flex; gap: 1rem; align-items: center;">
                <a href="{{ route('organizer.events.index') }}" style="color: #667eea; text-decoration: none; display: flex; align-items: center; gap: 0.3rem;">
                    Все мероприятия <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Сообщения об успехе --}}
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid #28a745;">
                {{ session('success') }}
                <button type="button" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #155724;" onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        @endif

        {{-- Таблица с последними 5 мероприятиями --}}
        @if($events->count() > 0)
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr style="border-bottom: 2px solid #e9ecef;">
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Название</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Дата</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Город</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Цена</th>
                            <th style="padding: 1rem; text-align: left; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Участники</th>
                            <th style="padding: 1rem; text-align: right; font-weight: 600; color: #495057; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events->take(5) as $event)
                            <tr style="border-bottom: 1px solid #e9ecef; transition: background-color 0.3s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                <td style="padding: 1rem; font-weight: 500; color: #212529;">{{ $event->title }}</td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $event->date->format('d.m.Y H:i') }}</td>
                                <td style="padding: 1rem; color: #6c757d;">{{ $event->city }}</td>
                                <td style="padding: 1rem; font-weight: 500; color: #28a745;">{{ number_format($event->price, 0, ',', ' ') }} ₽</td>
                                <td style="padding: 1rem;">
                                    <span style="font-weight: 500;">{{ $event->current_participants }}/{{ $event->max_participants }}</span>
                                </td>
                                <td style="padding: 1rem; text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <a href="{{ route('events.show', $event->id) }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 6px; font-size: 0.85rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(102, 126, 234, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('organizer.events.edit', $event->id) }}" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #ffc107; color: #212529; text-decoration: none; border-radius: 6px; font-size: 0.85rem; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(255, 193, 7, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('organizer.events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Удалить мероприятие?')" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background: #dc3545; color: white; border: none; border-radius: 6px; font-size: 0.85rem; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(220, 53, 69, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div style="background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center;">
                <div style="margin-bottom: 1.5rem;">
                    <i class="fas fa-calendar-alt" style="font-size: 4rem; color: #dee2e6;"></i>
                </div>
                <h3 style="color: #6c757d; margin-bottom: 1rem; font-weight: 500;">У вас пока нет мероприятий</h3>
                <p style="color: #adb5bd; margin-bottom: 2rem;">Создайте свое первое мероприятие и привлекайте участников</p>
                <a href="{{ route('organizer.events.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 500; transition: all 0.3s ease; border: none; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(102, 126, 234, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.3)';">
                    <i class="fas fa-plus"></i> Создать первое мероприятие
                </a>
            </div>
        @endif
    </div>
@endsection

<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Показать профиль пользователя
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Проверка прав доступа через Gate
        if (!Gate::allows('view', $user)) {
            abort(403, 'У вас нет прав для просмотра этого профиля');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Показать форму редактирования профиля
     */
    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    /**
     * Обновить профиль пользователя
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        // Проверка текущего пароля при смене пароля
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Текущий пароль неверен']);
            }

            $validated['password'] = Hash::make($request->password);
            unset($validated['current_password']);
        } else {
            unset($validated['password']);
            unset($validated['current_password']);
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Профиль успешно обновлен!');
    }

    /**
     * Удалить аккаунт пользователя
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect('/')->with('success', 'Ваш аккаунт был удален.');
    }

    /**
     * Показать список пользователей (для админа)
     */
    public function index()
    {
        // Проверка через Gate
        if (!Gate::allows('viewAny', User::class)) {
            abort(403, 'У вас нет прав для просмотра списка пользователей');
        }

        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Изменить роль пользователя (для админа)
     */
    public function updateRole(Request $request, User $user)
    {
        // Проверка через Gate
        if (!Gate::allows('updateRole', $user)) {
            abort(403, 'У вас нет прав для изменения роли пользователя');
        }

        $request->validate([
            'role' => ['required', 'in:user,admin'],
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Роль пользователя обновлена');
    }

    /**
     * Изменить статус организатора (для админа)
     */
    public function toggleOrganizer(Request $request, User $user)
    {
        // Проверка через Gate
        if (!Gate::allows('update', $user)) {
            abort(403, 'У вас нет прав для изменения статуса пользователя');
        }

        $user->update(['is_organizer' => !$user->is_organizer]);

        return back()->with('success', 'Статус организатора изменен');
    }

    /**
     * Удалить пользователя (для админа)
     */
    public function adminDestroy(User $user)
    {
        // Проверка через Gate
        if (!Gate::allows('delete', $user)) {
            abort(403, 'У вас нет прав для удаления пользователя');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Вы не можете удалить свой собственный аккаунт');
        }

        $user->delete();

        return back()->with('success', 'Пользователь удален');
    }
}

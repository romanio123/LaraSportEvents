<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Определить, может ли пользователь просматривать список пользователей.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Определить, может ли пользователь просматривать профиль.
     */
    public function view(User $authenticatedUser, User $targetUser): bool
    {
        return $authenticatedUser->id === $targetUser->id || $authenticatedUser->isAdmin();
    }

    /**
     * Определить, может ли пользователь создавать записи.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Определить, может ли пользователь обновить профиль.
     */
    public function update(User $authenticatedUser, User $targetUser): bool
    {
        return $authenticatedUser->id === $targetUser->id || $authenticatedUser->isAdmin();
    }

    /**
     * Определить, может ли пользователь изменить роль.
     */
    public function updateRole(User $authenticatedUser, User $targetUser): bool
    {
        return $authenticatedUser->isAdmin() && $authenticatedUser->id !== $targetUser->id;
    }

    /**
     * Определить, может ли пользователь удалить аккаунт.
     */
    public function delete(User $authenticatedUser, User $targetUser): bool
    {
        return $authenticatedUser->isAdmin() && $authenticatedUser->id !== $targetUser->id;
    }

    /**
     * Определить, может ли пользователь восстановить запись.
     */
    public function restore(User $user, User $targetUser): bool
    {
        return $user->isAdmin();
    }

    /**
     * Определить, может ли пользователь окончательно удалить запись.
     */
    public function forceDelete(User $user, User $targetUser): bool
    {
        return $user->isAdmin();
    }
}

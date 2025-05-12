<?php
namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        // Seuls les Admins ou Managers peuvent voir la liste des utilisateurs
        return in_array($user->role->name, ['Admin', 'Manager']);
    }

    public function view(User $user, User $model): bool
    {
        // Un utilisateur peut voir son propre profil ou si c’est un Admin/Manager
        return $user->id === $model->id || in_array($user->role->name, ['Admin', 'Manager']);
    }

    public function create(User $user): bool
    {
        // Seuls les Admins ou RH peuvent créer un nouvel utilisateur
        return in_array($user->role->name, ['Admin', 'HR']);
    }

    public function update(User $user, User $model): bool
    {
        // Admins, RH ou soi-même
        return $user->id === $model->id || in_array($user->role->name, ['Admin', 'HR']);
    }

    public function delete(User $user, User $model): bool
    {
        // Seuls les Admins peuvent supprimer
        return $user->role->name === 'Admin';
    }

    public function restore(User $user, User $model): bool
    {
        // Seuls les Admins peuvent restaurer un utilisateur soft-deleted
        return $user->role->name === 'Admin';
    }

    public function forceDelete(User $user, User $model): bool
    {
        // Seuls les Admins peuvent forcer la suppression
        return $user->role->name === 'Admin';
    }
}


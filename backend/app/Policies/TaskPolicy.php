<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function update(User $user, Task $task): bool
    {
        // return $user->id === $task->creator_id; // adapte à ta logique
        return true;
    }

    public function viewUsers(User $user, Task $task): bool
    {
        return true; // ou selon le rôle sur le projet parent
    }

    public function assign(User $user, Task $task): bool
    {
        return $user->id === $task->creator_id;
    }
}


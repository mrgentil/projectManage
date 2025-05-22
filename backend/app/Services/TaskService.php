<?php
namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function store(array $data): Task
    {
        $task = Task::create($data);
        if (!empty($data['user_ids'])) {
            $task->users()->sync($data['user_ids']);
        }
        return $task->load('users');
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task;
    }

    public function assignUsers(Task $task, array $userIds): void
    {
        $task->users()->sync($userIds);
    }

    public function removeUser(Task $task, int $userId): void
    {
        $task->users()->detach($userId);
    }

    public function getUsers(Task $task)
    {
        return $task->users;
    }
}

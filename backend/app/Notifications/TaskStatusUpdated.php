<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public $oldStatus, public $newStatus) {}

    public function via($notifiable): array
    {
        return ['database']; // Ou mail, etc.
    }

    public function toArray($notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_name' => $this->task->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => "Le statut de la tâche '{$this->task->name}' a été modifié de '{$this->oldStatus}' à '{$this->newStatus}'.",
        ];
    }
}

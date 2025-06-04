<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Services\TaskService;
use App\Models\TaskStatusHistory;
use App\Http\Controllers\Controller;
use App\Notifications\TaskStatusUpdated;
use App\Http\Requests\Task\StoreTaskRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Task\UpdateTaskStatusRequest;
use App\Http\Requests\Task\AssignUsersToTaskRequest;
use App\Http\Requests\Task\RemoveUserFromTaskRequest;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service) {}

    public function index()
    {
        return response()->json(Task::with('users')->get());
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['creator_id'] = auth()->id(); // ✅ ajout de l'utilisateur connecté

        $task = Task::create($validated);

        return response()->json([
            'message' => 'Tâche créée avec succès.',
            'task' => $task
        ], 201);
    }


    public function show(Task $task)
    {
        return response()->json($task->load('users'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task = $this->service->update($task, $request->validated());
        return response()->json(['message' => 'Tâche mise à jour', 'task' => $task]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('update', $task);
        $task->delete();
        return response()->json(['message' => 'Tâche supprimée']);
    }

    public function assignUsers(AssignUsersToTaskRequest $request, Task $task)
    {
        $this->authorize('assign', $task);
        $this->service->assignUsers($task, $request->validated()['user_ids']);
        return response()->json(['message' => 'Utilisateurs assignés']);
    }

    public function removeUser(RemoveUserFromTaskRequest $request, Task $task)
    {
        $this->authorize('assign', $task);
        $this->service->removeUser($task, $request->validated()['user_id']);
        return response()->json(['message' => 'Utilisateur retiré de la tâche']);
    }

    public function users(Task $task)
    {
        $this->authorize('viewUsers', $task);
        return response()->json($this->service->getUsers($task));
    }

    public function updateStatus(UpdateTaskStatusRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $oldStatus = $task->status;
        $newStatus = $request->status;

        $task->update(['status' => $newStatus]);

        // Historique
        TaskStatusHistory::create([
            'task_id' => $task->id,
            'changed_by' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        // Notification
        Notification::send($task->users, new TaskStatusUpdated($task, $oldStatus, $newStatus));

        return response()->json([
            'message' => 'Statut mis à jour avec succès.',
            'task' => $task,
        ]);
    }

    public function statusHistory(Task $task)
    {
       // $this->authorize('view', $task);

        return response()->json($task->statusHistories()->with('user')->latest()->get());
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Models\Project;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Requests\Project\AddUserToProjectRequest;
use App\Http\Requests\Project\RemoveUserFromProjectRequest;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->service->store($request->validated());
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return response()->json($this->service->get($project->id));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $updated = $this->service->update($project, $request->validated());
        return response()->json($updated);
    }

    public function destroy(Project $project)
    {
        $this->service->destroy($project);
        return response()->json(null, 204);
    }

    public function addUser(AddUserToProjectRequest $request, Project $project)
    {
        $this->authorize('addUser', $project); // 👈 vérifie si l'utilisateur connecté est autorisé
        $this->authorize('update', $project); // ou 'manageMembers', selon ta policy
        $this->service->addUserToProject($project, $request->user_id, $request->role_in_project);
        return response()->json(['message' => 'Utilisateur ajouté au projet']);
    }

    public function removeUser(RemoveUserFromProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $this->service->removeUserFromProject($project, $request->user_id);
        return response()->json(['message' => 'Utilisateur retiré du projet']);
    }

    public function members(Project $project)
    {
        $this->authorize('view', $project); // facultatif si nécessaire

        $members = $this->service->getProjectMembers($project);

        return response()->json($members);
    }
}

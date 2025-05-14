<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Services\ProjectService;

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
}


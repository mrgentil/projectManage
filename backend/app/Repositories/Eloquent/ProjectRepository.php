<?php
namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function all() {
        return Project::with('manager')->latest()->get();
    }

    public function find(int $id) {
        return Project::with(['manager', 'users'])->findOrFail($id);
    }

    public function create(array $data) {
        return Project::create($data);
    }

    public function update(Project $project, array $data) {
        $project->update($data);
        return $project;
    }

    public function delete(Project $project) {
        return $project->delete();
    }
}

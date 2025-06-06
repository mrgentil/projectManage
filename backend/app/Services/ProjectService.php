<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectService
{
    public function __construct(protected ProjectRepositoryInterface $repo) {}

    public function list()
    {
        return $this->repo->all();
    }

    public function get(int $id)
    {
        return $this->repo->find($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(Project $project, array $data)
    {
        return $this->repo->update($project, $data);
    }

    public function destroy(Project $project)
    {
        return $this->repo->delete($project);
    }

    public function addUserToProject(Project $project, int $userId, string $role)
    {
        return $project->users()->syncWithoutDetaching([
            $userId => ['role_in_project' => $role]
        ]);
    }

    public function removeUserFromProject(Project $project, int $userId)
    {
        return $project->users()->detach($userId);
    }

    public function getProjectMembers(Project $project)
    {
        return $project->members()->withPivot('role_in_project')->get();
    }
}

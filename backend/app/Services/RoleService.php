<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleService
{
    public function __construct(protected RoleRepositoryInterface $repo) {}

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

    public function update(Role $role, array $data)
    {
        return $this->repo->update($role, $data);
    }

    public function destroy(Role $role)
    {
        return $this->repo->delete($role);
    }
}

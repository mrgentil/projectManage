<?php

namespace App\Services;

use App\Models\Department;
use App\Repositories\Contracts\DepartmentRepositoryInterface;

class DepartmentService
{
    public function __construct(protected DepartmentRepositoryInterface $repo) {}

    public function list() {
        return $this->repo->all();
    }

    public function get(int $id) {
        return $this->repo->find($id);
    }

    public function store(array $data) {
        return $this->repo->create($data);
    }

    public function update(Department $department, array $data) {
        return $this->repo->update($department, $data);
    }

    public function destroy(Department $department) {
        return $this->repo->delete($department);
    }
}

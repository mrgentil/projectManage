<?php
namespace App\Repositories\Contracts;

use App\Models\Role;

interface RoleRepositoryInterface
{
    public function all();
    public function find(int $id): ?Role;
    public function create(array $data): Role;
    public function update(Role $role, array $data): Role;
    public function delete(Role $role): bool;
}

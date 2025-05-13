<?php
namespace App\Repositories\Eloquent;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function all() { return Role::all(); }

    public function find(int $id): ?Role { return Role::find($id); }

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}

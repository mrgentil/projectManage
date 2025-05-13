<?php

// app/Policies/DepartmentPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Department;

class DepartmentPolicy
{
    public function before(User $user) {
        if ($user->role_id === 1) return true; // Admin can do everything
    }

    public function viewAny(User $user) { return true; }
    public function view(User $user, Department $department) { return true; }
    public function create(User $user) { return true; }
    public function update(User $user, Department $department) { return true; }
    public function delete(User $user, Department $department) { return true; }
}


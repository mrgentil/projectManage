<?php

// app/Http/Controllers/API/RolePermissionController.php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    public function assignRoleToUser(Request $request, User $user)
    {
        $request->validate(['role_id' => 'required|exists:roles,id']);
        $user->roles()->syncWithoutDetaching([$request->role_id]);
        return response()->json(['message' => 'Rôle assigné']);
    }

    public function assignPermissionToRole(Request $request, Role $role)
    {
        $request->validate(['permission_ids' => 'required|array']);
        $role->permissions()->syncWithoutDetaching($request->permission_ids);
        return response()->json(['message' => 'Permissions assignées au rôle']);
    }

    public function assignPermissionToUser(Request $request, User $user)
    {
        $request->validate(['permission_ids' => 'required|array']);
        $user->permissions()->syncWithoutDetaching($request->permission_ids);
        return response()->json(['message' => 'Permissions assignées à l’utilisateur']);
    }
}


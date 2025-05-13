<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\RoleService;

class RoleController extends Controller
{
    public function __construct(protected RoleService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(StoreRoleRequest $request)
    {
        return response()->json($this->service->store($request->validated()), 201);
    }

    public function show(Role $role)
    {
        return response()->json($role);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        return response()->json($this->service->update($role, $request->validated()));
    }

    public function destroy(Role $role)
    {
        $this->service->destroy($role);
        return response()->json(null, 204);
    }
}


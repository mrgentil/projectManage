<?php

// app/Http/Controllers/API/DepartmentController.php
namespace App\Http\Controllers\API;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    public function __construct(protected DepartmentService $service) {}

    public function index() {
        $this->authorize('viewAny', Department::class);
        return response()->json($this->service->list());
    }

    public function store(StoreDepartmentRequest $request) {
        $this->authorize('create', Department::class);
        return response()->json($this->service->store($request->validated()), 201);
    }

    public function show(Department $department) {
        $this->authorize('view', $department);
        return response()->json($department);
    }

    public function update(UpdateDepartmentRequest $request, Department $department) {
        $this->authorize('update', $department);
        return response()->json($this->service->update($department, $request->validated()));
    }

    public function destroy(Department $department) {
        $this->authorize('delete', $department);
        $this->service->destroy($department);
        return response()->json(null, 204);
    }
}


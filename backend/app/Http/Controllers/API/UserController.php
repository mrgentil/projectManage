<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $service) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(StoreUserRequest $request)
    {
        return response()->json($this->service->store($request->validated()), 201);
    }

    public function show(User $user)
    {
        return response()->json($this->service->get($user->id));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return response()->json($this->service->update($user, $request->validated()));
    }

    public function destroy(User $user)
    {
        return response()->json(['deleted' => $this->service->destroy($user)]);
    }
}


<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function list()
    {
        return $this->userRepository->all();
    }

    public function get(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function store(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(User $user, array $data)
    {
        return $this->userRepository->update($user, $data);
    }

    public function destroy(User $user)
    {
        return $this->userRepository->delete($user);
    }
}

<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'role_id' => Role::inRandomOrder()->first()?->id ?? Role::factory(),
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'profile_picture' => $this->faker->imageUrl(200, 200),
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'is_active' => true,
            'department_id' => Department::inRandomOrder()->first()?->id,
            'last_login_at' => now(),
        ];
    }
}

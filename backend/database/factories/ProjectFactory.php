<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'start_date' => now()->subDays(rand(1, 10)),
            'end_date' => now()->addDays(rand(20, 60)),
            'status' => $this->faker->randomElement(['En cours', 'En progression', 'Achevé']),
            'priority' => $this->faker->randomElement(['Faible', 'Moyen', 'Elevé', 'Urgent']),
            'manager_id' => User::inRandomOrder()->first()?->id,
        ];
    }
}

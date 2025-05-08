<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::inRandomOrder()->first()?->id ?? Project::factory(),
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'assigned_to' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'status' => $this->faker->randomElement(['En cours', 'En progression', 'Achevé']),
            'priority' => $this->faker->randomElement(['Faible', 'Moyen', 'Elevé', 'Urgent']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}

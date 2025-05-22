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
            'creator_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'name' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['En cours', 'En progression', 'Achevé']),
            'priority' => $this->faker->randomElement(['Faible', 'Moyen', 'Elevé', 'Urgent']),
            'estimated_hours' => $this->faker->numberBetween(2, 20),
            'actual_hours' => $this->faker->optional()->numberBetween(1, 25),
            'is_recurring' => $this->faker->boolean(10),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }

    /**
     * Configure the factory to attach users to the task after creation.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Task $task) {
            // On attache 1 à 3 utilisateurs à la tâche
            $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $task->users()->attach($users);
        });
    }
}

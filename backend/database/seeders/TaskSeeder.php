<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Génère 50 tâches avec leurs utilisateurs attachés
        Task::factory()->count(50)->create();
    }
}

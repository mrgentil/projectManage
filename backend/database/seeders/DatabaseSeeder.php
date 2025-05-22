<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    Department,
    Role,
    User,
    Project,
    Task,
    Message,
    Leave,
    PerformanceReview
};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création des rôles
        $roles = ['Admin', 'Manager', 'HR', 'Developer', 'Designer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName], [
                'description' => $roleName . ' role',
            ]);
        }

        // 2. Création des départements
        $departments = ['Informatique', 'Marketing', 'RH', 'Finance', 'Logistique', 'Juridique', 'Commercial'];
        foreach ($departments as $departmentName) {
            Department::firstOrCreate(['name' => $departmentName], [

            ]);
        }

        // 3. Création d’utilisateurs avec rôle et département
        $allRoles = Role::all();
        $allDepartments = Department::all();

        User::factory(20)->create()->each(function ($user) use ($allRoles, $allDepartments) {
            $user->role_id = $allRoles->random()->id;
            $user->department_id = $allDepartments->random()->id;
            $user->save();
        });

        // 4. Création de projets
        Project::factory(5)->create();

        // 5. Création de tâches pour chaque projet
        Project::all()->each(function ($project) {
            Task::factory(5)->create(['project_id' => $project->id]);
        });

        // 6. Création de messages
        Message::factory(30)->create();

        // 7. Création de congés
        Leave::factory(15)->create();

        // 8. Création d'évaluations de performance
        PerformanceReview::factory(10)->create();

        // 9. Liaison utilisateurs-projets avec rôle dans la table pivot project_user
        $projectRoles = ['Developer', 'QA', 'Scrum Master', 'Designer', 'Product Owner'];
        $projects = Project::all();
        $users = User::all();

        foreach ($projects as $project) {
            $assignedUsers = $users->random(rand(2, 5));
            foreach ($assignedUsers as $user) {
                $project->users()->attach($user->id, [
                    'role_in_project' => $projectRoles[array_rand($projectRoles)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        $this->call(TaskSeeder::class);
    }

}

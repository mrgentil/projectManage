<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Department;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\DepartmentPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Department::class => DepartmentPolicy::class,
        Project::class => ProjectPolicy::class,
        Task::class => TaskPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('permission', function ($user, $permissionName) {
            return $user->hasPermission($permissionName);
        });
    }
}

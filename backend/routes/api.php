<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\RolePermissionController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;

// Auth (login/logout/me/reset)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/profile/update', [UserController::class, 'updateProfile']);
    Route::put('/my-profile', [UserController::class, 'updateMyProfile']);

    // Utilisateurs
    Route::apiResource('users', UserController::class);
    Route::put('/users/{user}', [UserController::class, 'update']); // Redondant avec apiResource si tu n’as pas besoin de personnalisation

    // Départements
    Route::apiResource('departments', DepartmentController::class);

    // Rôles et permissions
    Route::apiResource('roles', RoleController::class);
    Route::post('/users/{user}/assign-role', [RolePermissionController::class, 'assignRoleToUser']);
    Route::post('/roles/{role}/assign-permissions', [RolePermissionController::class, 'assignPermissionToRole']);
    Route::post('/users/{user}/assign-permissions', [RolePermissionController::class, 'assignPermissionToUser']);

    // Projets
    Route::prefix('projects')->controller(ProjectController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('{project}', 'show');
        Route::put('{project}', 'update');
        Route::delete('{project}', 'destroy');

        // Gestion des membres
        Route::post('{project}/add-user', 'addUser');
        Route::post('{project}/remove-user', 'removeUser');
        Route::get('{project}/members', 'members');
    });

    // Tâches
    Route::prefix('tasks')->controller(TaskController::class)->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('{task}', [TaskController::class, 'show']);
        Route::put('{task}', [TaskController::class, 'update']);
        Route::delete('{task}', [TaskController::class, 'destroy']);

        Route::post('{task}/assign-users', [TaskController::class, 'assignUsers']);
        Route::post('{task}/remove-user', [TaskController::class, 'removeUser']);
        Route::get('{task}/users', [TaskController::class, 'users']);
    });
});

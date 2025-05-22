<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ ajoute ceci

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profile_picture',
        'phone_number',
        'address',
        'is_active',
        'last_login_at',
        'date_of_birth',
        'job_title',
        'department_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user')->withTimestamps();
    }


    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    public function givenReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class, 'reviewer_id');
    }

    public function receivedReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class, 'user_id');
    }

    public function projectsUser()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('role_in_project')
            ->withTimestamps();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function projectsRole()
    {
        return $this->belongsToMany(Project::class)
            ->withPivot('role_in_project')
            ->withTimestamps();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    public function hasPermission($permission)
    {
        return $this->permissions()->where('name', $permission)->exists()
            || $this->roles()->whereHas('permissions', fn($q) => $q->where('name', $permission))->exists();
    }

    public function assignRole($roleId)
    {
        $this->roles()->syncWithoutDetaching([$roleId]);
    }

    public function givePermissionTo($permissionId)
    {
        $this->permissions()->syncWithoutDetaching([$permissionId]);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅
use Illuminate\Database\Eloquent\Relations\{BelongsTo};

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'name', 'description', 'assigned_to', 'status', 'due_date', 'priority'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}


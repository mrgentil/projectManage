<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

   public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }
}


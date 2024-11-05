<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Define the relationship with the `Project` model
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Define the relationship with the `User` model (students in the group)
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}

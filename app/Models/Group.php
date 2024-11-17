<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
    ];

    // Relationship to the project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // Authors in the group
    public function authors()
    {
        return $this->belongsToMany(User::class, 'group_user')->wherePivot('role', 'author');
    }

    // Technical Adviser (TA) in the group
    public function ta()
    {
        return $this->belongsToMany(User::class, 'group_user')->wherePivot('role', 'ta')->limit(1);
    }
}


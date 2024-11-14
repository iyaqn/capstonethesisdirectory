<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'ipRegistration', 
        'title', 
        'technicalAdviser', 
        'authors', 
        'course',
        'specialization', 
        'yearPublished', 
        'acmPaper', 
        'fullDocument', 
        'pub_mat',
        'approvalForm', 
        'sourceCode', 
        'is_best_proj', 
        'keywords', 
        'status'
    ];
    protected $casts = [
        'authors' => 'array', // Cast authors as an array
    ];

    // Define the relationship with the `Group` model
    public function group()
    {
        return $this->hasOne(Group::class);
    }
}

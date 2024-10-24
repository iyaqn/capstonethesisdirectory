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
        'author1', 
        'author2', 
        'author3', 
        'author4', 
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
}

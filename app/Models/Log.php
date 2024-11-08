<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    // Define the table name (if it differs from the model name)
    protected $table = 'logs';

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'log_course',
        'log_type',
        'action',
    ];

    // Define a relationship with the User model (assuming each log belongs to a user)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

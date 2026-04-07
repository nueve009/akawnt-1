<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'message',
        'resume_path',
        'status',
        'user_id',
    ];

    /**
     * Get the user associated with this job application.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminWhitelist extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
    ];
}

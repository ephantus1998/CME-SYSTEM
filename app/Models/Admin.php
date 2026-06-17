<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = ['name', 'username', 'password'];

    protected $hidden = ['password'];

    // Automatically hash the password when setting it
    protected $casts = [
        'password' => 'hashed',
    ];
}
<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';
    
    protected $fillable = [
        'username',
        'password',
        'role',
        'name',
        'email'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signin extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'middle_name',
    ];
}

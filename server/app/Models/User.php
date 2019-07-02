<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class User extends EloquentModel
{
    protected $table = 'users';
    protected $fillable = ['name','email','username','password','api_token','active_hash','avatar'];
}
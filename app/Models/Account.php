<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'conta';
    protected $hidden = ['created_at','updated_at'];
}
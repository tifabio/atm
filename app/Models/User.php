<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'usuario';
    protected $hidden = ['created_at','updated_at'];

    public function accounts() {
        return $this->hasMany('App\Models\Account', 'id_usuario', 'id');
    }
}
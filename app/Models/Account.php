<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'conta';
    protected $hidden = ['created_at','updated_at'];

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'id_usuario');
    }

    public function accountType() {
        return $this->hasOne('App\Models\AccountType', 'id', 'id_tipo_conta');
    }
}
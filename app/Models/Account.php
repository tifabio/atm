<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      description="Account Model",
 *      title="Account Model",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="id_usuario", type="integer"),
 *      @OA\Property(property="id_tipo_conta", type="integer"),
 *      @OA\Property(property="saldo", type="string")
 * )
 */
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
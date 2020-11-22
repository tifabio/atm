<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      description="User Model",
 *      title="User Model",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="nome", type="string"),
 *      @OA\Property(property="cpf", type="string"),
 *      @OA\Property(property="datanascimento", type="string")
 * )
 */
class User extends Model
{
    protected $table = 'usuario';
    protected $hidden = ['created_at','updated_at'];

    public function accounts() {
        return $this->hasMany('App\Models\Account', 'id_usuario', 'id');
    }
}
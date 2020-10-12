<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public static function find($id) {
        $user = User::find($id);
        return $user;
    }

    public static function save($payload, $id = 0) {
        $user = $id > 0 ? self::find($id) : new User();
        $user->id = $id;
        $user->nome = $payload['nome'];
        $user->cpf = $payload['cpf'];
        $user->datanascimento = $payload['datanascimento'];
        $user->save();
        return $user;
    }

    public static function delete($id) {
        return User::destroy($id);
    }
}
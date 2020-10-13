<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    public static function save($payload) {
        $account = new Account();
        $account->id_usuario = $payload['id_usuario'];
        $account->id_tipo_conta = $payload['id_tipo_conta'];
        $account->saldo = $payload['saldo'];
        $account->save();
        return $account;
    }

    public static function find($params) {
        $account = Account::where($params)->first();
        return $account;
    }
}
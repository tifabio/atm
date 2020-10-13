<?php

namespace App\Http\Controllers;

use App\Exceptions\AccountException;
use App\Services\AccountService;
use App\Exceptions\AccountTypeException;
use App\Services\AccountTypeService;
use App\Exceptions\UserException;
use App\Services\UserService;


class AccountController extends Controller
{
    public static function save($data)
    {
        $user = UserService::find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = AccountTypeService::find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new UserException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        try {
            $account = AccountService::save([
                'id_usuario' => $user->id,
                'id_tipo_conta' => $accountType->id,
                'saldo' => $data['saldo']
            ]);
            if(!$account) {
                throw new AccountException(AccountException::SAVE_ERROR, 500);
            }
        } catch (\Exception $e) {
            throw new AccountException($e->getMessage(), 500);
        }
        return $account->toArray();
    }

    public static function deposit($data) {
        $user = UserService::find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = AccountTypeService::find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new UserException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        $account = AccountService::find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);
        if(!$account) {
            throw new AccountException(AccountException::NOT_FOUND, 404);
        }

        $account->saldo += $data['valor'];
        $account->save();

        return $account->toArray();
    }

    public static function withdrawn($data) {
        $user = UserService::find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = AccountTypeService::find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new UserException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        $account = AccountService::find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);
        if(!$account) {
            throw new AccountException(AccountException::NOT_FOUND, 404);
        }

        $account->saldo -= $data['valor'];
        $account->save();

        return $account->toArray();
    }
}

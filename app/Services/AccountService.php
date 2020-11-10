<?php

namespace App\Services;

use App\Exceptions\AccountException;
use App\Exceptions\AccountTypeException;
use App\Exceptions\UserException;
use App\Models\Account;
use App\Services\AccountTypeService;
use App\Services\UserService;
use App\Services\ATMService;

class AccountService
{
    private $accountTypeService;
    private $userService;

    public function __construct(AccountTypeService $accountTypeService, UserService $userService)
    {
        $this->accountTypeService = $accountTypeService;
        $this->userService = $userService;
    }

    public function save($data) {
        $user = $this->userService->find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = $this->accountTypeService->find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new AccountTypeException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        try {
            $account = new Account();
            $account->id_usuario = $user->id;
            $account->id_tipo_conta = $accountType->id;
            $account->saldo = $data['saldo'];
            $account->save();
            if(!$account) {
                throw new AccountException(AccountException::SAVE_ERROR, 500);
            }

            return $account;
        } catch (\Exception $e) {
            throw new AccountException($e->getMessage(), 500);
        }
    }

    public function deposit($data) {
        $user = $this->userService->find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = $this->accountTypeService->find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new AccountTypeException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        $account = $this->find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);
        if(!$account) {
            throw new AccountException(AccountException::NOT_FOUND, 404);
        }

        $account->saldo += $data['valor'];
        $account->save();

        return $account;
    }

    public function withdrawn($data) {
        $user = $this->userService->find(['cpf' => $data['cpf']]);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        $accountType = $this->accountTypeService->find(['tipo_conta' => $data['tipo_conta']]);
        if(!$accountType) {
            throw new AccountTypeException(AccountTypeException::INVALID_ACCOUNT_TYPE, 422);
        }

        $account = $this->find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);
        if(!$account) {
            throw new AccountException(AccountException::NOT_FOUND, 404);
        }

        $atm = new ATMService($account->saldo);
        $money = $atm->withdrawn($data['valor']);

        $account->saldo -= $data['valor'];
        $account->save();

        return $money;
    }

    public function find($params) {
        $account = Account::where($params)->first();
        return $account;
    }
}
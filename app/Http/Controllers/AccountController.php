<?php

namespace App\Http\Controllers;

use App\Exceptions\AccountException;
use App\Services\AccountService;
use App\Exceptions\AccountTypeException;
use App\Services\AccountTypeService;
use App\Exceptions\UserException;
use App\Services\UserService;
use App\Services\ATMService;
use Illuminate\Http\Request;


class AccountController extends Controller
{
    public function save(Request $request)
    {
        $this->validate($request, [
            'cpf' => 'required|string|min:11',
            'tipo_conta' => 'required|string',
            'saldo' => 'required|integer',
        ]);
        $data = $request->all();
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
        
        return response()->json($account->toArray(), 201);
    }

    public function deposit(Request $request) {
        $this->validate($request, [
            'cpf' => 'required|string|min:11',
            'tipo_conta' => 'required|string',
            'valor' => 'required|integer|gt:0',
        ]);
        $data = $request->all();
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

        return response()->json($account->toArray());
    }

    public function withdrawn(Request $request) {
        $this->validate($request, [
            'cpf' => 'required|string|min:11',
            'tipo_conta' => 'required|string',
            'valor' => 'required|integer|gt:0',
        ]);
        $data = $request->all();
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

        $atm = new ATMService($account->saldo);
        $money = $atm->withdrawn($data['valor']);
        
        $account->saldo -= $data['valor'];
        $account->save();

        return response()->json($money);
    }
}

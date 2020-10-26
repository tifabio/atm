<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
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
        $account = AccountService::save($request->all());        
        return response()->json($account->toArray(), 201);
    }

    public function deposit(Request $request) {
        $this->validate($request, [
            'cpf' => 'required|string|min:11',
            'tipo_conta' => 'required|string',
            'valor' => 'required|integer|gt:0',
        ]);
        $account = AccountService::deposit($request->all());        
        return response()->json($account->toArray());
    }

    public function withdrawn(Request $request) {
        $this->validate($request, [
            'cpf' => 'required|string|min:11',
            'tipo_conta' => 'required|string',
            'valor' => 'required|integer|gt:0',
        ]);
        $money = AccountService::withdrawn($request->all());        
        return response()->json($money);
    }
}

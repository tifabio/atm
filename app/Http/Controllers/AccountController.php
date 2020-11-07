<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\Account\SaveRequest;
use App\Http\Controllers\Requests\Account\BalanceRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function save(SaveRequest $request)
    {
        $account = AccountService::save($request->getRequest());        
        return response()->json($account->toArray(), 201);
    }

    public function deposit(BalanceRequest $request) 
    {
        $account = AccountService::deposit($request->getRequest());        
        return response()->json($account->toArray());
    }

    public function withdrawn(BalanceRequest $request) 
    {
        $money = AccountService::withdrawn($request->getRequest());        
        return response()->json($money);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\Account\SaveRequest;
use App\Http\Controllers\Requests\Account\BalanceRequest;
use App\Services\AccountService;

class AccountController extends Controller
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function save(SaveRequest $request)
    {
        $account = $this->accountService->save($request->getRequest());        
        return response()->json($account->toArray(), 201);
    }

    public function deposit(BalanceRequest $request) 
    {
        $account = $this->accountService->deposit($request->getRequest());        
        return response()->json($account->toArray());
    }

    public function withdrawn(BalanceRequest $request) 
    {
        $money = $this->accountService->withdrawn($request->getRequest());        
        return response()->json($money);
    }
}

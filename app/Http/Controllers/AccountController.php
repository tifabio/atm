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

    /**
     * @OA\Post(
     *      path="/accounts",
     *      tags={"accounts"},
     *      description="Create new account",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"cpf","tipo_conta","saldo"},
     *                  @OA\Property(
     *                      property="cpf",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="tipo_conta",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="saldo",
     *                      type="integer"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="201", 
     *          description="Account Model",
     *          @OA\JsonContent(ref="#/components/schemas/Account")
     *      )
     * )
     */
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

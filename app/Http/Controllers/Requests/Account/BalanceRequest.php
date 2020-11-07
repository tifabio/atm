<?php

namespace App\Http\Controllers\Requests\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BalanceRequest extends Controller
{
   public function __construct(Request $request)
   {
      $this->validate($request, [
         'cpf' => 'required|string|min:11',
         'tipo_conta' => 'required|string',
         'valor' => 'required|integer|gt:0',
     ]);

      parent::__construct($request);
   }
}
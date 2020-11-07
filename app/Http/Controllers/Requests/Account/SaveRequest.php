<?php

namespace App\Http\Controllers\Requests\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveRequest extends Controller
{
   public function __construct(Request $request)
   {
      $this->validate($request, [
         'cpf' => 'required|string|min:11',
         'tipo_conta' => 'required|string',
         'saldo' => 'required|integer',
      ]);

      parent::__construct($request);
   }
}
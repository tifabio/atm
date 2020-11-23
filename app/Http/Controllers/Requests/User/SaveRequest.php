<?php

namespace App\Http\Controllers\Requests\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaveRequest extends Controller
{
   public function __construct(Request $request)
   {
      $this->validate($request, [
         'nome' => 'required|string|min:3',
         'cpf' => 'required|string|min:11|max:11',
         'datanascimento' => 'required|date',
      ]);

      parent::__construct($request);
   }
}
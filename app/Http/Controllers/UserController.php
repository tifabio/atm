<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Requests\User\SaveRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get($id)
    {
        $user = UserService::getById($id);
        return response()->json($user->toArray());
    }

    public function find(Request $request)
    {
        $params = [
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf')
        ];
        $user = UserService::find($params);
        return response()->json($user->toArray());
    }

    public function save(SaveRequest $request, $id = 0)
    {
        $user = UserService::save($request->getRequest(), $id);
        return response()->json($user->toArray(), $id > 0 ? 200 : 201);
    }

    public function delete($id)
    {
        UserService::delete($id);
        return response(null, 204);
    }
}

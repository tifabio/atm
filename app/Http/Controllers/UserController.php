<?php

namespace App\Http\Controllers;

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

    public function save(Request $request, $id = 0)
    {
        $this->validate($request, [
            'nome' => 'required|string|min:3',
            'cpf' => 'required|string|min:11',
            'datanascimento' => 'required|date',
        ]);
        $user = UserService::save($request->all(), $id);
        return response()->json($user->toArray(), $id > 0 ? 200 : 201);
    }

    public function delete($id)
    {
        UserService::delete($id);
        return response(null, 204);
    }
}

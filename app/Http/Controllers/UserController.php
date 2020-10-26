<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get($id)
    {
        $user = UserService::getById($id);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        
        return response()->json($user->toArray());
    }

    public function find(Request $request)
    {
        $params = [
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf')
        ];
        if(!$params['nome'] && !$params['cpf']) {
            throw new UserException(UserException::INVALID_QUERY_PARAMS, 400);
        }
        $user = UserService::find(array_filter($params));
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }

        return response()->json($user->toArray());
    }

    public function save(Request $request, $id = 0)
    {
        $this->validate($request, [
            'nome' => 'required|string|min:3',
            'cpf' => 'required|string|min:11',
            'datanascimento' => 'required|date',
        ]);
        if($id > 0) {
            if(!UserService::getById($id)) {
                throw new UserException(UserException::NOT_FOUND, 404);
            }
        }
        try {
            $user = UserService::save($request->all(), $id);
            if(!$user) {
                throw new UserException(UserException::SAVE_ERROR, 500);
            }
        } catch (\Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }

        return response()->json($user->toArray(), $id > 0 ? 200 : 201);
    }

    public function delete($id)
    {
        if(!UserService::getById($id)) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        try {
            $user = UserService::delete($id);
            if(!$user) {
                throw new UserException(UserException::SAVE_ERROR, 500);
            }
        } catch (\Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }

        return response(null, 204);
    }
}

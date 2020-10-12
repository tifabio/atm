<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Services\UserService;

class UserController extends Controller
{
    public function get($id)
    {
        $user = UserService::getById($id);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        return $user->toJson();
    }

    public static function find($params)
    {
        if(!$params['nome'] && !$params['cpf']) {
            throw new UserException(UserException::INVALID_QUERY_PARAMS, 400);
        }
        $user = UserService::find(array_filter($params));
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        return $user->toArray();
    }

    public static function save($data, $id = 0)
    {
        if($id > 0) {
            if(!UserService::find($id)) {
                throw new UserException(UserException::NOT_FOUND, 404);
            }
        }
        $user = UserService::save($data, $id);
        if(!$user) {
            throw new UserException(UserException::SAVE_ERROR, 500);
        }
        return $user->toArray();
    }

    public function delete($id)
    {
        if(!UserService::find($id)) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        $user = UserService::delete($id);
        if(!$user) {
            throw new UserException(UserException::SAVE_ERROR, 500);
        }
        return $user;
    }
}

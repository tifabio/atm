<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Services\UserService;

class UserController extends Controller
{
    public function find($id)
    {
        $user = UserService::find($id);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        return $user->toJson();
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
        return $user->toJson();
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

<?php

namespace App\Services;

use App\Exceptions\UserException;
use App\Models\User;

class UserService
{
    public function getById($id) {
        $user = User::find($id);
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        return $user;
    }

    public function find($params) {
        $params = [
            'nome' => $params['nome'] ?? '',
            'cpf' => $params['cpf'] ?? ''
        ];
        if(!$params['nome'] && !$params['cpf']) {
            throw new UserException(UserException::INVALID_QUERY_PARAMS, 400);
        }
        $user = User::where(array_filter($params))->first();
        if(!$user) {
            throw new UserException(UserException::NOT_FOUND, 404);
        }
        return $user;
    }

    public function save($payload, $id = 0) {
        $user = $id > 0 ? $this->getById($id) : new User();
        try {
            $user->id = $id;
            $user->nome = $payload['nome'];
            $user->cpf = $payload['cpf'];
            $user->datanascimento = $payload['datanascimento'];
            $user->save();
            if(!$user) {
                throw new UserException(UserException::SAVE_ERROR, 500);
            }
        } catch (\Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }
        return $user;
    }

    public function delete($id) {
        $user = $this->getById($id);
        try {
            $result = $user->delete();
            if(!$result) {
                throw new UserException(UserException::DELETE_ERROR, 500);
            }
        } catch (\Exception $e) {
            throw new UserException($e->getMessage(), 500);
        }
        return $result;
    }
}
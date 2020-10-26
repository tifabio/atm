<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\UserService;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $this->post('/users', [
                'nome' => 'José Silva',
                'cpf' => '12345678910',
                'datanascimento' => '1999-01-01'
            ])
            ->seeStatusCode(201);
    }

    public function testGetUser()
    {
        $user = UserService::find(['cpf' => '12345678910']);
        $this->get('/users/' . $user->id)
                ->seeStatusCode(200)
                ->seeJson([
                    'id' => $user->id,
                    'nome' => 'José Silva',
                    'cpf' => '12345678910',
                    'datanascimento' => '1999-01-01'
                ]);
    }

    public function testFindUser()
    {
        $user = UserService::find(['cpf' => '12345678910']);
        $this->get('/users?cpf=12345678910')
                ->seeStatusCode(200)
                ->seeJson([
                    'id' => $user->id,
                    'nome' => 'José Silva',
                    'cpf' => '12345678910',
                    'datanascimento' => '1999-01-01'
                ]);
    }

    public function testUpdateUser()
    {
        $user = UserService::find(['cpf' => '12345678910']);
        $this->put('/users/' . $user->id, [
                'nome' => 'João Silva',
                'cpf' => '12345678911',
                'datanascimento' => '2000-01-01'
            ])
            ->seeStatusCode(200)
            ->seeJson([
                'id' => $user->id,
                'nome' => 'João Silva',
                'cpf' => '12345678911',
                'datanascimento' => '2000-01-01'
            ]);
    }

    public function testDeleteUser()
    {
        $user = UserService::find(['cpf' => '12345678911']);
        $this->delete('/users/' . $user->id)
                ->seeStatusCode(200);
    }

    public function testUserNotFound()
    {
        $this->get('/users?cpf=99999999999')
                ->seeStatusCode(404);
    }

    public function testCreateUserWithoutBirthDate()
    {
        $this->post('/users', [
            'nome' => 'João dos Santos',
            'cpf' => '12345678900'
        ])
        ->seeStatusCode(422);
    }
}
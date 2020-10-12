<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\UserService;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $this->post('/user', [
                'nome' => 'José Silva',
                'cpf' => '12345678916',
                'datanascimento' => '1999-01-01'
            ])
            ->seeStatusCode(201);
    }

    public function testFindUser()
    {
        $user = UserService::find(['cpf' => '12345678916']);
        $this->get('/user/' . $user->id)
                ->seeStatusCode(200)
                ->seeJson([
                    'id' => $user->id,
                    'nome' => 'José Silva',
                    'cpf' => '12345678916',
                    'datanascimento' => '1999-01-01'
                ]);
    }
}
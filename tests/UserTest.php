<?php

use App\Services\UserService;

class UserTest extends TestCase
{
    private $userService;

    public function setUp(): void
    {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
        $this->baseResource = '/users';
    }

    public function testCreateUser()
    {
        $this->post($this->baseResource, [
                'nome' => 'José Silva',
                'cpf' => '12345678910',
                'datanascimento' => '1999-01-01'
            ])
            ->seeStatusCode(201);
    }

    public function testGetUser()
    {
        $user = $this->userService->find(['cpf' => '12345678910']);
        $this->get($this->baseResource . '/' . $user->id)
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
        $user = $this->userService->find(['cpf' => '12345678910']);
        $this->get($this->baseResource . '?cpf=12345678910')
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
        $user = $this->userService->find(['cpf' => '12345678910']);
        $this->put($this->baseResource . '/' . $user->id, [
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
        $user = $this->userService->find(['cpf' => '12345678911']);
        $this->delete($this->baseResource . '/' . $user->id)
                ->seeStatusCode(204);
    }

    public function testUserNotFound()
    {
        $this->get($this->baseResource . '?cpf=99999999999')
                ->seeStatusCode(404);
    }

    public function testCreateUserWithoutBirthDate()
    {
        $this->post($this->baseResource, [
            'nome' => 'João dos Santos',
            'cpf' => '12345678900'
        ])
        ->seeStatusCode(422);
    }
}
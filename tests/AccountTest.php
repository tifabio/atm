<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\UserService;

class AccountTest extends TestCase
{
    public function testCreateAccount()
    {
        $this->post('/user', [
                'nome' => 'José Silva',
                'cpf' => '12345678920',
                'datanascimento' => '1999-01-01'
            ])
            ->seeStatusCode(201);

        $this->post('/account', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'saldo' => '200'
            ])
            ->seeStatusCode(201);
    }

    public function testCreateAccountInvalidAccountType()
    {
        $this->post('/account', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_PAGAMENTO',
                'saldo' => '200'
            ])
            ->seeStatusCode(422);
    }
}
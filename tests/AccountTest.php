<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\AccountService;
use App\Services\AccountTypeService;
use App\Services\UserService;
use App\Exceptions\ATMException;

class AccountTest extends TestCase
{
    public function testCreateAccount()
    {
        $this->post('/users', [
                'nome' => 'José Silva',
                'cpf' => '12345678920',
                'datanascimento' => '1999-01-01'
            ])
            ->seeStatusCode(201);

        $this->post('/accounts', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'saldo' => '200'
            ])
            ->seeStatusCode(201);
    }

    public function testCreateAccountInvalidAccountType()
    {
        $this->post('/accounts', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_PAGAMENTO',
                'saldo' => '200'
            ])
            ->seeStatusCode(422);
    }

    public function testAccountDeposit()
    {
        $user = UserService::find(['cpf' => '12345678920']);

        $accountType = AccountTypeService::find(['tipo_conta' => 'CONTA_POUPANCA']);

        $account = AccountService::find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);

        $this->put('/accounts/deposit', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'valor' => 50
            ])
            ->seeStatusCode(200)
            ->seeJson([
                'id' => $account->id,
                'id_usuario' => $user->id,
                'id_tipo_conta' => $accountType->id,
                'saldo' => 250
            ]);
    }

    public function testAccountDepositDecimalValue()
    {
        $user = UserService::find(['cpf' => '12345678920']);

        $accountType = AccountTypeService::find(['tipo_conta' => 'CONTA_POUPANCA']);

        $account = AccountService::find([
            'id_usuario' => $user->id,
            'id_tipo_conta' => $accountType->id
        ]);

        $this->put('/accounts/deposit', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'valor' => 40.39
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'valor' => ['The valor must be an integer.']
            ]);
    }

    public function testAccountWithdrawn()
    {
        $this->put('/accounts/withdrawn', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'valor' => 130
            ])
            ->seeStatusCode(200)
            ->seeJson([
                '100' => 0,
                '50'  => 1,
                '20'  => 4
            ]);
    }

    public function testAccountWithdrawnWrongRequiredAmount()
    {
        $this->put('/accounts/withdrawn', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'valor' => 15
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'message' => ATMException::WRONG_REQUIRED_AMOUNT,
                'status_code' => 422
            ]);
    }

    public function testAccountWithdrawnInsufficientFunds()
    {
        $this->put('/accounts/withdrawn', [
                'cpf' => '12345678920',
                'tipo_conta' => 'CONTA_POUPANCA',
                'valor' => 350
            ])
            ->seeStatusCode(422)
            ->seeJson([
                'message' => ATMException::INSUFFICENT_FUNDS,
                'status_code' => 422
            ]);
    }
}
<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Exceptions\ATMException;
use App\Services\ATMService;

class ATMTest extends TestCase
{
    private $balance = 300;

    public function testFifteen() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(15);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), ATMException::WRONG_REQUIRED_AMOUNT);
        }
    }

    public function testTwenty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(20);
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 1
        ]);
    }

    public function testThirty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(30);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), ATMException::WRONG_REQUIRED_AMOUNT);
        }
    }

    public function testFourty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(40);
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 2
        ]);
    }

    public function testFifty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(50);
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 0
        ]);
    }

    public function testSixty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(60);
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 3
        ]);
    }

    public function testSeventy() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(70);
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 1
        ]);
    }

    public function testEighty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(80);
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 4
        ]);
    }

    public function testNinety() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(90);
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 2
        ]);
    }

    public function testOneHundredAndTen() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(110);
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 3
        ]);
    }

    public function testOneHundredAndTwenty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(120);
        $this->assertEquals($money, [
            100 => 1,
            50  => 0,
            20  => 1
        ]);
    }


    public function testOneHundredAndThirty() {
        $atm = new ATMService($this->balance);
        $money = $atm->withdrawn(130);
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 4
        ]);
    }

    public function testInsufficientFunds() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn($this->balance + 50);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), ATMException::INSUFFICENT_FUNDS);
        }
    }
}
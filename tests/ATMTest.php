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
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(20);
        } catch (\Exception $e) {}
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
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(40);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 2
        ]);
    }

    public function testFifty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(50);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 0
        ]);
    }

    public function testSixty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(60);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 3
        ]);
    }

    public function testSeventy() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(70);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 1
        ]);
    }

    public function testEighty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(80);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 0,
            20  => 4
        ]);
    }

    public function testNinety() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(90);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 2
        ]);
    }

    public function testOneHundredAndTen() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(110);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 0,
            50  => 1,
            20  => 3
        ]);
    }

    public function testOneHundredAndTwenty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(120);
        } catch (\Exception $e) {}
        $this->assertEquals($money, [
            100 => 1,
            50  => 0,
            20  => 1
        ]);
    }


    public function testOneHundredAndThirty() {
        try {
            $atm = new ATMService($this->balance);
            $money = $atm->withdrawn(130);
        } catch (\Exception $e) {}
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
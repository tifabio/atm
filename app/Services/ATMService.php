<?php

namespace App\Services;

use App\Exceptions\ATMException;

class ATMService
{
    private $accountBalance;
    private $currentAmount;

    public function __construct($accountBalance) {
        $this->accountBalance = $accountBalance;
    }

    public function withdrawn($amount) {
        if($amount > $this->accountBalance) {
            throw new ATMException(ATMException::INSUFFICENT_FUNDS, 422);
        }
        if($amount < 20 || $amount == 30 || $amount % 10 != 0) {
            throw new ATMException(ATMException::WRONG_REQUIRED_AMOUNT, 422);
        }

        $this->currentAmount = $amount;

        $bankNotes = [
            100 => $this->countBankNotes(100),
            50  => $this->countBankNotes(50),
            20  => $this->countBankNotes(20),
        ];

        return $bankNotes;
    }

    private function countBankNotes($bankNoteValue) {
        if($this->currentAmount < $bankNoteValue) {
            return 0;
        }

        $count = floor($this->currentAmount / $bankNoteValue);

        $checkCount = $this->currentAmount % $bankNoteValue;
        if(($checkCount > 0 && $checkCount < 20) || $checkCount == 30) {
            $count--;
        }

        $this->currentAmount -= $bankNoteValue * $count;

        return $count;
    }
}
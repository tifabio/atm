<?php

namespace App\Exceptions;

class ATMException extends \Exception implements CustomException
{
    const INSUFFICENT_FUNDS = 'Insufficient funds';
    const WRONG_REQUIRED_AMOUNT = 'Wrong required amount';

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
<?php

namespace App\Exceptions;

class AccountTypeException extends \Exception implements CustomException
{
    const INVALID_ACCOUNT_TYPE = 'Invalid account type';

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
<?php

namespace App\Exceptions;

class AccountException extends \Exception implements CustomException
{
    const SAVE_ERROR = 'Error saving account';

    public function __construc($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
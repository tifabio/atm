<?php

namespace App\Exceptions;

class UserException extends \Exception implements CustomException
{
    const NOT_FOUND = 'User not found';
    const SAVE_ERROR = 'Error saving user';

    public function __construc($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
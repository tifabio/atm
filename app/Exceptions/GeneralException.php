<?php

namespace App\Exceptions;

class GeneralException extends \Exception implements CustomException
{
    const INVALID_DATA = 'Invalid data';

    public function __construc($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
<?php

namespace App\Exceptions;

class UserException extends \Exception implements CustomException
{
    const NOT_FOUND = 'User not found';
    const SAVE_ERROR = 'Error saving user';
    const DELETE_ERROR = 'Error removing user';
    const INVALID_QUERY_PARAMS = 'Invalid query parameters';

    public function __construct($message, $code = 0) {
        parent::__construct($message, $code);
    }
} 
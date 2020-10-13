<?php

namespace App\Services;

use App\Models\AccountType;

class AccountTypeService
{
    public static function find($params) {
        $accountType = AccountType::where($params)->first();
        return $accountType;
    }
}
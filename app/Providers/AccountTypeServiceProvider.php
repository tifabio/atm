<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AccountTypeService;

class AccountTypeServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(AccountTypeService::class, function($app) {
            return new AccountTypeService();
        });
    }
}

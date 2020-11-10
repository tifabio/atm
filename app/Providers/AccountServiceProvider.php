<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AccountService;

class AccountServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(AccountServiceProvider::class, function($app) {
            return new AccountService();
        });
    }
}

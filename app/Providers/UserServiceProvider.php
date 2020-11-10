<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(UserService::class, function($app) {
            return new UserService();
        });
    }
}

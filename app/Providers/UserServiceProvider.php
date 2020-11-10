<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\UserService;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Services\UserService', function($app) {
            return new UserService();
        });
    }
}

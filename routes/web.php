<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('foo', function () use ($router) {
    return 'Hello World';
});

$router->get('/users/{id}', '\App\Http\Controllers\UserController@get');

$router->delete('/users/{id}', '\App\Http\Controllers\UserController@delete');

$router->put('/users/{id}', '\App\Http\Controllers\UserController@save');

$router->post('/users', '\App\Http\Controllers\UserController@save');

$router->get('/users', '\App\Http\Controllers\UserController@find');

$router->post('/accounts', '\App\Http\Controllers\AccountController@save');

$router->put('/accounts/deposit', '\App\Http\Controllers\AccountController@deposit');

$router->put('/accounts/withdrawn', '\App\Http\Controllers\AccountController@withdrawn');
<?php

use \Illuminate\Http\Request;
use \App\Exceptions\GeneralException;
use \App\Http\Controllers\UserController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('foo', function () use ($router) {
    return 'Hello World';
});

$router->get('/user/{id}', '\App\Http\Controllers\UserController@find');

$router->delete('/user/{id}', '\App\Http\Controllers\UserController@delete');

$router->put('/user/{id}', function ($id, Request $request) {
    if (!$request->isJson()) {
       throw new GeneralException(GeneralException::INVALID_DATA, 400);
    }
    return UserController::save($request->json()->all(), $id);
});

$router->post('/user', function (Request $request) {
    if (!$request->isJson()) {
       throw new GeneralException(GeneralException::INVALID_DATA, 400);
    }

    return UserController::save($request->json()->all());
});
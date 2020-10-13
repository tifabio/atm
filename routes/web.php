<?php

use \Illuminate\Http\Request;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\AccountController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('foo', function () use ($router) {
    return 'Hello World';
});

$router->get('/user/{id}', '\App\Http\Controllers\UserController@get');

$router->delete('/user/{id}', '\App\Http\Controllers\UserController@delete');

$router->put('/user/{id}', function ($id, Request $request) {
    $this->validate($request, [
        'nome' => 'required|string|min:3',
        'cpf' => 'required|string|min:11',
        'datanascimento' => 'required|date',
    ]);
    $user = UserController::save($request->all(), $id);
    return response()->json($user);
});

$router->post('/user', function (Request $request) {
    $this->validate($request, [
        'nome' => 'required|string|min:3',
        'cpf' => 'required|string|min:11',
        'datanascimento' => 'required|date',
    ]);
    $user = UserController::save($request->all());
    return response()->json($user, 201);
});

$router->get('/user', function (Request $request) {
    $user = UserController::find([
        'nome' => $request->input('nome'),
        'cpf' => $request->input('cpf')
    ]);
    return response()->json($user);  
});

$router->post('/account', function (Request $request) {
    $this->validate($request, [
        'cpf' => 'required|string|min:11',
        'tipo_conta' => 'required|string',
        'saldo' => 'required|integer',
    ]);
    $account = AccountController::save($request->all());
    return response()->json($account, 201);
});
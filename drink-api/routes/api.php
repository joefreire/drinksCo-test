<?php


$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');


$router->group(['prefix' => 'product'], function () use ($router) {
    $router->get('/',  ['uses' => 'ProductController@showAll']);  
    $router->get('/{id}', ['uses' => 'ProductController@showOne']);  
    $router->post('/', ['uses' => 'ProductController@store']);  
    $router->delete('/{id}', ['uses' => 'ProductController@destroy']);  
    $router->patch('/{id}', ['uses' => 'ProductController@update']);
});

$router->group(['prefix' => 'cart'], function () use ($router) {
    $router->get('/{id}', ['uses' => 'CartController@showOne']);  
    $router->get('/remove-all-products/{id}', ['uses' => 'CartController@removeAllProducts']);  
    $router->post('/', ['uses' => 'CartController@store']);  
    $router->post('/remove-item', ['uses' => 'CartController@removeProduct']);  
    $router->delete('/{id}', ['uses' => 'CartController@destroy']);  
    $router->patch('/{id}', ['uses' => 'CartController@update']);
});
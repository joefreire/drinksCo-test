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
    $router->post('/', ['uses' => 'CartController@store']);
    $router->patch('/{user_id}', ['uses' => 'CartController@update']);
    $router->post('/remove-item', ['uses' => 'CartController@removeProduct']);
    $router->get('/remove-all-products/{user_id}', ['uses' => 'CartController@removeAllProducts']);
    $router->get('/total-cart/{user_id}', ['uses' => 'CartController@totalCart']);
});

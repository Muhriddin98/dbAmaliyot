<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function (){
    return app()->version();
});

//$router->get('users/add','UsersController@add');
//$router->get('categorys/add','CategorysController@add');
//$router->get('companys/add','CompanysController@add');
//$router->get('products/add','ProductsController@add');
//$router->post('orders/add', 'OrdersController@add');
//$router->post('test','TransactionsController@test');
$router->post('extjs/add','ExtjsController@add');

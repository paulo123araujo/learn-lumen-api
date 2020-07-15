<?php

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

$router->group([
    'namespace' => 'Api\V1',
    'prefix' => 'api/v1'
], function () use ($router) {
    $router->post('register', 'UsersController@store');
    $router->post('login', 'SessionController@store');

    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->group(['prefix' => 'users'], function () use ($router) {
            $router->get('', 'UsersController@index');
            $router->get('{user}', 'UsersController@show');
            $router->put('{user}', 'UsersController@update');
            $router->delete('{user}', 'UsersController@remove');
        });

        $router->delete('logout', 'SessionController@remove');

        $router->group(['prefix' => 'events'], function () use ($router) {
            $router->get('', 'EventsController@index');
            $router->get('{event}', 'EventsController@show');
            $router->post('', 'EventsController@store');
            $router->put('{event}', 'EventsController@update');
            $router->delete('{event}', 'EventsController@remove');
        });
    });
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

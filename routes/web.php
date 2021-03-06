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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post(
        'auth/login',
        [
            'uses' => 'AuthController@authenticate'
        ]
    );

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post(
            '/upload',
            [
                'uses' => 'UploadController@create'
            ]
        );
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get(
            '/keyword-statistics/{id}',
            [
                'uses' => 'KeywordStatsController@get'
            ]
        );
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get(
            '/keyword-statistics',
            [
                'uses' => 'KeywordStatsController@list'
            ]
        );
    });

});

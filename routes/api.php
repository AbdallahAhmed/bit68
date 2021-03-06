<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth', 'API\AuthController@login');
Route::post('/auth/register', 'API\AuthController@register');

Route::group(["middleware" => ['api-auth'], 'prefix' => 'forecast'], function ($router) {
    $router->get('/weather', 'API\ForecastController@weather');
});

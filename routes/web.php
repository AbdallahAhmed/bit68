<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', 'AuthController@login')->middleware('guest')->name('login');

Route::group(["middleware" => 'auth'], function () {
    Route::any('/logout', 'AuthController@logout')->name('logout');
    Route::group(["prefix" => 'forecast'], function ($router) {
        $router->any('/weather', 'ForecastController@weather')->name('weather');
    });
});

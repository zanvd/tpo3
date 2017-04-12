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

// Landing page.
Route::get('/', function () {
    return view('registerUser');
});


// Login routes.
Route::get('/login', 'LoginController@index');

Route::post('/login', 'LoginController@store');

Route::post('/logout', 'LoginController@destroy');

// Registration routes.
Route::get('/register', 'RegisterController@index');

Route::post('/register', 'RegisterController@store');

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


/**
 * Define sub-namespace prefixes for usage in routes.
 * Use as key => value pair ending with backslash.
 *
 * @var array
 */
$namespacePrefix = [
	'auth' => 'Auth\\'
];

// Landing page.
Route::get('/', function () {
    return view('landing');
});


// Login routes.
Route::get('/login', $namespacePrefix['auth'].'LoginController@index');

Route::post('/login', $namespacePrefix['auth'].'LoginController@store');

Route::post('/logout', $namespacePrefix['auth'].'LoginController@destroy');

// Registration routes for patients.
Route::get('/patient/register',
	$namespacePrefix['auth'].'RegisterPatientController@index');

Route::post('/patient/register',
	$namespacePrefix['auth'].'RegisterPatientController@store');

// Register routes for workers.
Route::get('/employee/register',
	$namespacePrefix['auth'].'RegisterEmployeeController@index');

Route::post('/employee/register',
	$namespacePrefix['auth'].'RegisterEmployeeController@store');

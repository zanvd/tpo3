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

// Register routes for login.
Route::get('/prijava', $namespacePrefix['auth'].'LoginController@index');

Route::post('/prijava', $namespacePrefix['auth'].'LoginController@store');

Route::get('/odjava', $namespacePrefix['auth'].'LoginController@destroy');


// Register routes for password reset.
Route::get('/pozabljeno-geslo',
		   $namespacePrefix['auth'].'ForgotPasswordController@index');

Route::post('/pozabljeno-geslo',
			$namespacePrefix['auth'].'ForgotPasswordController@store');

Route::get('/ponastavi-geslo/{email}/{token}', [
	'as' => 'password.reset',
	'uses'=> $namespacePrefix['auth'].'ResetPasswordController@index'
]);

Route::post('/ponastavi-geslo',
			$namespacePrefix['auth'].'ResetPasswordController@store');




// Register routes for patients.
Route::get('/registracija/pacient',
	$namespacePrefix['auth'].'RegisterPatientController@index');

Route::post('/registracija/pacient',
	$namespacePrefix['auth'].'RegisterPatientController@store');




// Register routes for workers.
Route::get('/registracija/zaposleni',
	$namespacePrefix['auth'].'RegisterEmployeeController@index');

Route::post('/registracija/zaposleni',
	$namespacePrefix['auth'].'RegisterEmployeeController@store');




// Register routes for work order.
Route::get('delovni-nalog', function() {
	return view('workOrder');
});

Route::post('delovni-nalog', function () {
	return view('workOrder');
});

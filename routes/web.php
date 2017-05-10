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
| Documentation is in form of:
| Method:	Description.	can be accessed by
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

/*
|--------------------------------------------------------------------------
| Login and Logout
|--------------------------------------------------------------------------
|
| Get:		display the login page.	guest
| Post:		perform login.			guest
| Destroy:	perform logout.			authenticated
|
*/
Route::get('/prijava', $namespacePrefix['auth'].'LoginController@index');

Route::post('/prijava', $namespacePrefix['auth'].'LoginController@store');

Route::get('/odjava', $namespacePrefix['auth'].'LoginController@destroy');


/*
|--------------------------------------------------------------------------
| Forgotten password
|--------------------------------------------------------------------------
|
| Get:		display the send link page.	guest
| Post:		send link to mail.			guest
|
*/
Route::get('/pozabljeno-geslo',
		   $namespacePrefix['auth'].'ForgotPasswordController@index');

Route::post('/pozabljeno-geslo',
			$namespacePrefix['auth'].'ForgotPasswordController@store');

/*
|--------------------------------------------------------------------------
| Password reset
|--------------------------------------------------------------------------
|
| Get:		display the reset password page.	guest
| Post:		perform password reset.				guest
|
*/
Route::get('/ponastavi-geslo/{email}/{token}', [
	'as' => 'password.reset',
	'uses'=> $namespacePrefix['auth'].'ResetPasswordController@index'
]);

Route::post('/ponastavi-geslo',
			$namespacePrefix['auth'].'ResetPasswordController@store');

/*
|--------------------------------------------------------------------------
| Password change
|--------------------------------------------------------------------------
|
| Get:		display the change password page.	auth
| Post:		perform password change.			auth
|
*/
Route::get('/spremeni-geslo',
			$namespacePrefix['auth'].'ChangePasswordController@index');

Route::post('/spremeni-geslo',
			$namespacePrefix['auth'].'ChangePasswordController@store');


/*
|--------------------------------------------------------------------------
| Patient registration
|--------------------------------------------------------------------------
|
| Get:		display the registration page.	guest
| Post:		perform registration.			guest
|
*/
Route::get('/registracija',
	$namespacePrefix['auth'].'RegisterPatientController@index');

Route::post('/registracija',
	$namespacePrefix['auth'].'RegisterPatientController@store');

/*
|--------------------------------------------------------------------------
| Email verification
|--------------------------------------------------------------------------
|
| Get:		show verification message page.				guest
| Post:		perform verification with given token.		guest
| Put:		resend verification token to given email.	guest
|
*/
Route::get('/verifikacija',
	$namespacePrefix['auth'].'VerificationController@index');

Route::post('/verifikacija/{token}',
	$namespacePrefix['auth'].'VerificationController@verify');

Route::put('/verifikacija',
	$namespacePrefix['auth'].'RegisterPatientController@update');

/*
|--------------------------------------------------------------------------
| Employee registration
|--------------------------------------------------------------------------
|
| Get:		display the registration page.	admin
| Post:		perform registration.			admin
|
*/
Route::get('/registracija/zaposleni',
	$namespacePrefix['auth'].'RegisterEmployeeController@index');

Route::post('/registracija/zaposleni',
	$namespacePrefix['auth'].'RegisterEmployeeController@store');




/*
|--------------------------------------------------------------------------
| Work order creation
|--------------------------------------------------------------------------
|
| Get:		display the work order page.	doctor, chief nurse
| Post:		create new work order.			doctor, chief nurse
|
*/
Route::get('delovni-nalog', function() {
	return view('workOrder');
});

Route::post('delovni-nalog', function () {
	return view('workOrder');
});

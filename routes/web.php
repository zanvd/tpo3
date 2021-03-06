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
| Method:	description.	can be accessed by
|
*/


/**
 * Define sub-namespace prefixes for usage in routes.
 * Use as key => value pair ending with backslash.
 *
 * @var array
 */
$namespacePrefix = [
	'auth'		=> 'Auth\\',
    'employee'	=> 'Employee\\',
	'patient'	=> 'Patient\\'
];

// Landing page.
Route::get('/', function () {
		return auth()->check()
			? view('landing')
				->with([
					'role'	=> auth()->user()->userRole->user_role_title,
					'name'	=> auth()->user()->person->name . ' '
								. auth()->user()->person->surname
				])
			: view('landing');
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
		   $namespacePrefix['auth'].'ForgotPasswordController@edit');

Route::put('/pozabljeno-geslo',
			$namespacePrefix['auth'].'ForgotPasswordController@update');

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
	'uses'=> $namespacePrefix['auth'].'ResetPasswordController@edit'
]);

Route::put('/ponastavi-geslo',
			$namespacePrefix['auth'].'ResetPasswordController@update');

/*
|--------------------------------------------------------------------------
| Password change
|--------------------------------------------------------------------------
|
| Get:		display the change password page.	auth
| Put:		perform password change.			auth
|
*/
Route::get('/spremeni-geslo',
			$namespacePrefix['auth'].'ChangePasswordController@index');

Route::put('/spremeni-geslo',
			$namespacePrefix['auth'].'ChangePasswordController@update');


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

Route::get('/verifikacija/{token}',
	$namespacePrefix['auth'].'VerificationController@verify');

Route::put('/verifikacija',
	$namespacePrefix['auth'].'VerificationController@update');

/*
|--------------------------------------------------------------------------
| Employee registration
|--------------------------------------------------------------------------
|
| Get:		display the registration page.	admin
| Post:		perform registration.			admin
|
*/
Route::get('/zaposleni/ustvari',
	$namespacePrefix['auth'].'RegisterEmployeeController@index');

Route::post('/zaposleni/ustvari',
	$namespacePrefix['auth'].'RegisterEmployeeController@store');


/*
|--------------------------------------------------------------------------
| Work order
|--------------------------------------------------------------------------
|
| Get:		display the work order list page.		doctor, chief nurse
| Get:		display the work order creation page.	doctor, chief nurse
| Post:		create new work order.					doctor, chief nurse
| Get:		display requested work order.			doctor, chief nurse, nurse
|
*/
Route::get('/delovni-nalog',
	$namespacePrefix['employee'].'WorkOrderController@index');

Route::get('/delovni-nalog/ustvari',
    $namespacePrefix['employee'].'WorkOrderController@create');

Route::post('/delovni-nalog',
    $namespacePrefix['employee'].'WorkOrderController@store');

Route::get('/delovni-nalog/{workOrder}',
		   $namespacePrefix['employee'].'WorkOrderController@show');
/*
|--------------------------------------------------------------------------
| Plan
|--------------------------------------------------------------------------
|
| 
| Get:		display plan creation page.				chief nurse, nurse
| Post:		create new plan.						chief nurse, nurse
|
|
*/
Route::get('/nacrt-obiskov/ustvari', function () {
		return view('visitPlan');
});

Route::post('/nacrt-obiskov',
    $namespacePrefix['employee'].'WorkOrderController@store');

/*
|--------------------------------------------------------------------------
| Dependant patient
|--------------------------------------------------------------------------
|
| Get:		display the dependant patient page.	patient
| Post:		create new dependant patient.		patient
|
*/
Route::get('/oskrbovani-pacient',
	$namespacePrefix['patient'].'DependentPatientController@index');

Route::post('/oskrbovani-pacient',
	$namespacePrefix['patient'].'DependentPatientController@store');

/*
|--------------------------------------------------------------------------
| Patient profile
|--------------------------------------------------------------------------
|
| Get:		display patient profile page.	patient
|
*/
Route::get('/profil',
	$namespacePrefix['patient'].'PatientProfileController@index');


/*
|--------------------------------------------------------------------------
| Visit
|--------------------------------------------------------------------------
|
| Get:		display the visit list page.	doctor, chief nurse, nurse
| Get:		display requested visit.		doctor, chief nurse, nurse
| Get:		display edit page for visit.	nurse
| Patch:	update the visit with data.		nurse
|
*/
Route::get('/obisk',
    $namespacePrefix['employee'].'VisitController@index');

Route::get('/obisk/{visit}',
    $namespacePrefix['employee'].'VisitController@show');

Route::get('obisk/{visit}/uredi',
	$namespacePrefix['employee'].'VisitController@edit');

Route::patch('obisk/{visit}',
    $namespacePrefix['employee'].'VisitController@update');

/*
|--------------------------------------------------------------------------
| Substitution
|--------------------------------------------------------------------------
|
| Get:		display substitutions.	        chief nurse
| Get:		create new substitution.		chief nurse
|
*/
Route::get('/nadomeščanja',
    $namespacePrefix['employee'].'SubstitutionController@index');

Route::post('/nadomeščanja',
    $namespacePrefix['employee'].'SubstitutionController@store');

Route::post('/nadomeščanja/končaj',
    $namespacePrefix['employee'].'SubstitutionController@end');


/*
|--------------------------------------------------------------------------
| Plan the visits
|--------------------------------------------------------------------------
|
| Get:		display the plan of the visits.		nurse
| Post:		save the plan of the visits.		nurse
|
*/
Route::get('/nacrt-obiskov/ustvari',
    $namespacePrefix['employee'].'VisitPlanController@index');

Route::get('/nacrt-obiskov',
    $namespacePrefix['employee'].'VisitPlanController@showPlans');

Route::post('/nacrt-obiskov',
    $namespacePrefix['employee'].'VisitPlanController@store');

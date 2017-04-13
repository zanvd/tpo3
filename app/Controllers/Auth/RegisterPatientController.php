<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use App\Models\KontaktnaOseba as Contact;
use App\Models\Uporabnik as User;
use App\Models\Pacient as Patient;

class RegisterPatientController extends Controller {

    /**
     * Create a new controller instance.
     *
     */
	public function __construct() {
		// Only guest users can access register page.
		$this->middleware('guest');
	}

	/**
	 * Display registration page.
	 *
	 */
	public function index() {
		return view('registerUser');
	}

    /**
     * Perform validations on received data and create new user.
     * After successful registration log the user in.
	 *
     */
	public function store() {
		// Validate given data.
		$this->validate(request(), [
			'email'					=> 'required|email',
			'password'				=> 'required|confirmed|min:6|max:64',
			'name'					=> 'required|string',
			'surname'				=> 'required|string',
			'sex'					=> 'required',
			'birthDate'				=> 'required|date_format:d.m.Y|before:today',
			'phoneNumber'			=> 'required|digits:9',
			'address'				=> 'required',
			'areaNumber'			=> 'required',
			'zzzs'					=> 'required|digits:9',
			/*'contactSurname'		=> 'string',
			'contactName'			=> 'string',
			'contactPhoneNumber'	=> 'digits:9'*/
		]);

		// Create new user and populate attributes.
		$user = new User;

		$user->email = request('email');
		$user->password = bcrypt(request('password'));
		$user->vloga = 'pacient';

		$user->save();

		// Check if user specified contact person.
		$contactEmpty = true;

		if (!empty(request('contactSurname')) &&
			!empty(request('contactName')) &&
			!empty(request('contactPhoneNumber'))&&
			!empty(request('contactAddress'))) {
			// Create new contact person and populate attributes.
			$contact = new Contact;

			$contact->priimek = request('contactSurname');
			$contact->ime = request('contactName');
			$contact->telefon = request('contactPhoneNumber');
			$contact->naslov = request('contactAddress');
			$contact->posta = request('contactPostalCode');
			$contact->sorodstveno_razmerje = request('contactFamily');

			$contact->save();
		}

		// Create new patient and populate attributes.
		$patient = new Patient;

		$patient->zavarovanje_stevilka = request('zzzs');
		$patient->priimek = request('surname');
		$patient->ime = request('name');
		$patient->naslov = request('address');
		$patient->telefon = request('phoneNumber');
		$patient->datum_rojstva = \DateTime::createFromFormat(
										'd.m.Y',
										request('birthDate')
									)->format('Y-m-d');
		$patient->spol = request('sex');
		$patient->uporabnik = $user->id_uporabnik;
		$patient->kontaktna_oseba = $contactEmpty ?
			null : $contact->id_kontaktna_oseba;
		$patient->posta = request('postalCode');
		$patient->okolis = request('areaNumber');

		$patient->save();

		// Login user and redirect to home page.
		auth()->login($user);

		return redirect('/');
	}
}

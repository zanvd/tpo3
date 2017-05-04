<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use App\Models\Uporabnik as User;
use App\Models\DelavecZd as Employee;

class RegisterEmployeeController extends Controller {
	/**
	 * Create a new controller instance
	 *
	 */
	public function __construct() {
		// Only administrator can access register page.
		$this->middleware('admin');
	}

	/**
	 * Display registration page.
	 *
	 */
	public function index() {
		return view('registerEmployee');
	}

	/**
	 * Create new employee.
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store() {
		// Validate given data.
		$this->validate(request(), [
			'email'			=> 'required|email',
			'password'		=> 'required|confirmed|min:5|max:64',
			'name'			=> 'required|alpha',
			'surname'		=> 'required|alpha',
			'phoneNumber'	=> 'required|between:8,15',
			'function'		=> 'required',
			'institution'	=> 'required',
			'areaNumber'	=> 'required',
			'address'		=> 'required',
			'postNumber'	=> 'required'
		], [
			'alpha'			=> 'Dovoljene so zgolj črke.',
			'confirmed'		=> 'Gesli se ne ujemata.',
			'required'		=> 'Polje je zahtevano.'
		]);

		// Create new user and populate attributes.
		$user = new User;

		$user->email = request('email');
		$user->password = request('password');
		$user->vloga = 'usluzbenec';

		$user->save();

		// Create new employee and populate attributes.
		$employee = new Employee;

		$employee->priimek = request('surname');
		$employee->ime = request('name');
		$employee->telefon = request('phoneNumber');
		$employee->funkcija = request('function');
		$employee->uporabnik = $user->uporabnik_id;
		$employee->izvajalec = request('institution');
		$employee->okolis = request('areaNumber');

		$employee->save();

		// Login user and redirect to home page.
		auth()->login($user);

		return redirect('/');
	}
}

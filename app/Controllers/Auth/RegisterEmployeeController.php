<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use App\Models\Institution;
use App\Models\Person;
use App\Models\Post;
use App\Models\Region;
use App\Models\Uporabnik as User;
use App\Models\DelavecZd as Employee;
use Carbon\Carbon;

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
		return view('registerEmployee')
			->with([
			   'lastLogin'		=> $this->lastLogin(auth()->user()),
			   'posts'			=> Post::all()->mapWithKeys(function ($post) {
				   return [$post['post_number'] => $post['post_title']];
			   }),
			   'institutions'	=> Institution::all()->mapWithKeys(function ($inst) {
				   return [$inst['institution_id'] => $inst['institution_title']];
			   }),
			   'regions'		=> Region::all()->mapWithKeys(function ($region) {
				   return [$region['region_id'] => $region['region_title']];
			   })
		]);
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
			'address'		=> 'required',
			'postNumber'	=> 'required'
		], [
			'alpha'			=> 'Dovoljene so zgolj črke.',
			'confirmed'		=> 'Gesli se ne ujemata.',
			'required'		=> 'Polje je zahtevano.'
		]);

		// Create new person and populate attributes.
		$person = Person::create([
			'name'			=> request('name'),
			'surname'		=> request('surname'),
			'phone_number'	=>request('phoneNumber'),
			'address'		=> request('address'),
			'post_number'	=> request('postNumber'),
			'region_id'		=> array_key_exists(request('region')) ?
				request('region') : null,
		]);

		dd($person);

		// Create new employee and populate attributes.
		$employee = Employee::create([
			'employee_title'	=> request('function'),
			'person_id'			=> $person->person_id,
			'institution_id'	=> request('institution')
		]);

		// Create new user and populate attributes.
		$user = User::create([
			'email'			=> request('email'),
			'password'		=> bcrypt(request('password')),
			'created_at'	=> Carbon::now()->toDateTimeString(),
			'user_role_id'	=> request('userRole'),
			'person_id'		=> $person->person_id
		]);

		return redirect('/registracija/zaposleni')
			->with(['status' => 'Nov zaposleni uspešno registriran.']);
	}
}

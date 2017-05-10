<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

use App\Models\Institution;
use App\Models\Person;
use App\Models\Post;
use App\Models\Region;
use App\Models\User;
use App\Models\Employee;
use App\Models\UserRole;
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
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *
	 */
	public function index() {
		return view('adminAddUser')
			->with([
				'name'			=> auth()->user()->person->name . ' ' .
									 auth()->user()->person->surname,
				'role'			=> auth()->user()->userRole->user_role_title,
				'lastLogin'		=> $this->lastLogin(auth()->user()),
				'roles'			=> UserRole::all()->mapWithKeys(function ($role) {
					return [$role['user_role_id'] => $role['user_role_title']];
			   }),
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
			'password'		=> 'required|confirmed|min:8|max:64',
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
			'phone_num'		=> request('phoneNumber'),
			'address'		=> request('address'),
			'post_number'	=> request('postNumber'),
			'region_id'		=> array_key_exists('region', request()) ?
				request('region') : null,
		]);

		do
			$employeeId = intval(rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9));
		while (Employee::find($employeeId) !== null);

		// Create new employee and populate attributes.
		Employee::create([
			'employee_id'		=> $employeeId,
			'person_id'			=> $person->person_id,
			'institution_id'	=> request('institution')
		]);

		// Create new user and populate attributes.
		User::create([
			'email'			=> request('email'),
			'password'		=> bcrypt(request('password')),
			'created_at'	=> Carbon::now()->toDateTimeString(),
			'user_role_id'	=> request('function'),
			'person_id'		=> $person->person_id
		]);

		return redirect('/registracija/zaposleni')
			->with(['status' => 'Nov zaposleni uspešno registriran.']);
	}
}

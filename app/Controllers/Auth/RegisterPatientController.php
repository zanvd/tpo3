<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\Contact;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Post;
use App\Models\Region;
use App\Models\Relationship;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		return view('registerUser')->with([
			'posts'			=> Post::all()->mapWithKeys(function ($post) {
				return [$post['post_number'] => $post['post_title']];
			}),
			'regions'		=> Region::all()->mapWithKeys(function ($region) {
				return [$region['region_id'] => $region['region_title']];
			}),
			'relationships' => Relationship::all(function ($relationship) {
				return [
					$relationship['relationship_id']
						=> $relationship['relationship_type']
				];
			})
		]);
	}

	/**
	 * Perform validations on received data and create new user.
	 * After successful registration log the user in.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request) {
		// Validate given data.
		$this->validate(request(), [
			'email'				=> 'required|email',
			'password'			=> 'required|confirmed|min:8|max:64',
			'name'				=> 'required|string',
			'surname'			=> 'required|string',
			'phoneNumber'		=> 'required|digits|digits_between:8,9',
			'address'			=> 'required',
			'postNumber'		=> 'required|digits:4',
			'region'			=> 'required|digits',
			'insurance'			=> 'required|digits:9',
			'birthDate'			=> 'required|date|before:tomorrow',
			'sex'				=> 'required|string|size:1',
			'contactName'		=> 'string',
			'contactSurname'	=> 'string',
			'contactPhone'		=> 'digits|digits_between:8,9',
			'contactAddress'	=> 'string',
			'contactPost'		=> 'digits:4',
			'relationship'		=> 'digits'
		]);

		// Create new Contact if all information is provided.
		if (isset($request['contactName'], $request['contactSurname'],
			$request['contactPhone'], $request['contactPost'],
			$request['relationship'])) {
			$contact = new Contact([
				'contact_name'		=> request('contactName'),
				'contact_surname'	=> request('contactSurname'),
				'contact_phone_num'	=> request('contactPhone'),
				'contact_address'	=> request('contactAddress'),
				'post_number'		=> request('contactPost'),
				'relationship_id'	=> request('relationship')
			]);

		} else if (isset($request['contactName']) ||
				   isset($request['contactSurname']) ||
				   isset($request['contactPhone']) ||
				   isset($request['contactPost']) ||
				   isset($request['relationship']))
			// Warn the user about filling in all of the Contact information.
			return redirect()->back()->withErrors([
				'message' => 'Če želite dodati kontakt, morate izpolniti vsa polja.'
			]);

		// Start Transaction.
		DB::beginTransaction();

		// Try saving everything to the database.
		try {
			// Save the Contact.
			$contact->save();

			// Create new Person.
			$person = new Person([
				'name'			=> request('name'),
				'surname'		=> request('surname'),
				'phoneNumber'	=> request('phoneNumber'),
				'address'		=> request('address'),
				'postNumber'	=> request('postNumber'),
				'region'		=> request('region')
			]);

			$person->save();

			// Create new Patient.
			$patient = new Patient([
				'insurance'		=> request('insurance'),
				'birthDate'		=> Carbon::createFromFormat('d.m.YYYY',
									request('birtDate'))->toDateString(),
				'sex'			=> request('sex'),
				'person_id'		=> $person->person_id,
				'contact_id'	=> isset($contact) ? $contact->contact_id : NULL
			]);

			$patient->save();

			// Create new User.
			$user = new User([
				'email'			=> request('email'),
				'password'		=> bcrypt(request('password')),
				'created_at'	=> Carbon::now()->toDateTimeString(),
				'user_role_id'	=> UserRole::where('user_role_title', 'Pacient')
									->user_role_id,
				'person_id'		=> $person->person_id
			]);

			$user->save();

		} catch (\Exception $e) {
			// Log exception.
			error_log(print_r('Error when creating new patient: ' .
							  $e, true));

			// Rollback everything.
			DB::rollback();

			// Let the user know about failure and ask to try again.
			return redirect()->back()->withErrors([
				'message' => 'Napaka pri ustvarjanju novega uporabniškega ' .
							 'računa. Prosimo, poskusite znova.'
			]);
		}

		// Everything is fine. Commit changes to database.
		DB::commit();

		//TODO: email verification

		return redirect('/')->with([
			'status'	=> 'Registracija uspela. Preverite vaš e-mail predal za '
						   . 'aktivacijsko povezavo.'
		]);
	}
}

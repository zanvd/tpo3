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
	 * Create a new register patient controller instance.
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
		return view('register')->with([
			'posts'			=> Post::all()->mapWithKeys(function ($post) {
				return [$post['post_number'] => $post['post_title']];
			}),
			'regions'		=> Region::all()->mapWithKeys(function ($region) {
				return [$region['region_id'] => $region['region_title']];
			}),
			'relationships' => Relationship::all()->mapWithKeys(function ($relationship) {
				return [
					$relationship['relationship_id']
						=> $relationship['relationship_type']
				];
			})
		]);
	}

	/**
	 * Perform validations on received data and create new user.
	 * Send verification email with token.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request) {
		// Validate given data.
		$this->validate(request(), [
			'email'				=> 'required|email',
			'password'			=> 'required|confirmed|min:8|max:64',
			'firstname'			=> 'required|string',
			'surname'			=> 'required|string',
			'phoneNumber'		=> 'required|digits_between:8,9',
			'address'			=> 'required',
			'postNumber'		=> 'required|digits:4',
			'region'			=> 'required|numeric',
			'insurance'			=> 'required|digits:9',
			'birthDate'			=> 'required|date|before:tomorrow',
			'sex'				=> 'required|string|size:1',
			'contactName'		=> 'required_with_all:contactSurname,
									contactPhone, contactAddress, contactPost,
									relationship|string',
			'contactSurname'	=> 'required_with_all:contactName,
									contactPhone, contactAddress, contactPost,
									relationship|string',
			'contactPhone'		=> 'required_with_all:contactName,
									contactSurname, contactAddress, contactPost,
									relationship|digits_between:8,9',
			'contactAddress'	=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactPost,
									relationship|string',
			'contactPost'		=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactAddress,
									relationship|digits:4',
			'relationship'		=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactAddress,
									contactPost|numeric'
		]);

		// Create new Contact if information is provided.
		// Check only one field as validator takes care of checking everything.
		if (isset($request['contactName'])) {
			$contact = new Contact([
				'contact_name'		=> request('contactName'),
				'contact_surname'	=> request('contactSurname'),
				'contact_phone_num'	=> request('contactPhone'),
				'contact_address'	=> request('contactAddress'),
				'post_number'		=> request('contactPost'),
				'relationship_id'	=> request('relationship')
			]);

		}

		// Start Transaction.
		DB::beginTransaction();

		// Try saving everything to the database.
		try {
			// Save the Contact if created.
			if (isset($contact))
				$contact->save();

			// Create new Person.
			$person = new Person([
				'name'			=> request('firstname'),
				'surname'		=> request('surname'),
				'phone_num'		=> request('phoneNumber'),
				'address'		=> request('address'),
				'post_number'	=> request('postNumber'),
				'region_id'		=> request('region')
			]);

			$person->save();

			// Create new Patient.
			$patient = new Patient([
				'insurance_num'	=> request('insurance'),
				'birth_date'	=> Carbon::createFromFormat('d.m.Y',
									request('birthDate'))->toDateString(),
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
									->value('user_role_id'),
				'person_id'		=> $person->person_id
			]);

			$user->save();

			// Create new Verification.
			$verifController = new VerificationController();
			$verification = $verifController->store($user->user_id);

			$verification->save();

		} catch (\Exception $e) {
			// Log exception.
			error_log(print_r('Error when creating new patient: ' .
							  $e, true));

			// Rollback everything.
			DB::rollback();

			// Let the user know about the failure and ask to try again.
			return redirect()->back()->withErrors([
				'message' => 'Napaka pri ustvarjanju novega uporabniškega ' .
							 'računa. Prosimo, poskusite znova.'
			]);
		}

		// Everything is fine. Commit changes to database.
		DB::commit();

		// Send verification token.
		$verifController->sendVerificationMail($user, $verification);

		return redirect('/verifikacija')->with([
			'email'	=> $user->email
		]);
	}
}

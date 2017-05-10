<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\Contact;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Post;
use App\Models\Region;
use App\Models\Relationship;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
			'contactName'		=> 'required_with_all:contactSurname,
									contactPhone, contactAddress, contactPost,
									relationship|string',
			'contactSurname'	=> 'required_with_all:contactName,
									contactPhone, contactAddress, contactPost,
									relationship|string',
			'contactPhone'		=> 'required_with_all:contactName,
									contactSurname, contactAddress, contactPost,
									relationship|digits|digits_between:8,9',
			'contactAddress'	=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactPost,
									relationship|string',
			'contactPost'		=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactAddress,
									relationship|digits:4',
			'relationship'		=> 'required_with_all:contactName,
									contactSurname, contactPhone, contactAddress,
									contactPost|digits'
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
									->value('user_role_id'),
				'person_id'		=> $person->person_id
			]);

			$user->save();

			// Create new Verification.
			$verification = $this->createVerification($user->user_id);

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
		$email = new EmailVerification($user, $verification);

		Mail::to($user->email)->send($email);

		return redirect('/')->with([
			'status'	=> 'Registracija uspela. Preverite vaš e-mail predal za '
						   . 'aktivacijsko povezavo.'
		]);
	}

	/**
	 * Verify user if provided token is valid.
	 *
	 * @param $token
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function verify ($token) {
		// Check if token exists.
		$verification = Verification::where('verification_token', $token)->first();
		if (isEmpty($verification))
			redirect()->back()->withErrors([
				'message' => 'Nepravilna aktivacija koda.'
			]);

		// Check if user exists.
		$user = User::find($verification->user_id);
		if (isEmpty($user))
			redirect()->back()->withErrors([
				'message' => 'Uporabnik s to aktivacijsko kodo ni bil najden.'
			]);

		// Check if token is still valid.
		if ($verification->value('verification_expiry') < Carbon::now()) {
			// Change token and resend it.
			return $this->resendVerification($user->email);
		}

		// Verify user with provided token.
		$user->active = 1;
		$user->save();

		// Remove verification token from database.
		$verification->delete();

		// Send user to login page.
		return redirect('prijava');
	}

	/**
	 * Create new verification token and send it.
	 *
	 * @param $emailAddress
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function resendVerification ($emailAddress) {
		// Retrieve user with provided email address.
		$user = User::where('email', $emailAddress)->first();

		// Retrieve current verification token.
		$verification = Verification::where('user_id', $user->user_id)->first();

		// Change current token.
		$verification->update($this->createVerification($user->user_id)->attributesToArray());

		// Send new token.
		$email = new EmailVerification($user, $verification);

		Mail::to($emailAddress)->send($email);
		return redirect()->back()->with([
			'status'	=> 'Na vaš e-mail naslov smo poslali novo aktivacijsko '
						   .'povezavo.'
		]);
	}

	/**
	 * Create new verification token.
	 * Verification token is valid for one hour.
	 *
	 * @param $userId
	 *
	 * @return Verification
	 */
	protected function createVerification ($userId) {
		return new Verification([
			'verification_token'	=> Str::random(64),
			'verification_expiry'	=> Carbon::now()
											  ->addHour(1)->toDateTimeString(),
			'user_id'				=> $userId
		]);
	}
}

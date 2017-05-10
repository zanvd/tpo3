<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Models\Verification;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller {

	/**
	 * Create a new verification controller instance.
	 *
	 */
	public function __construct() {
		// Only guest users can access verification page.
		$this->middleware('guest');
	}

	/**
	 * Display verification page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
		return view('verification');
	}

	/**
	 * Activate user if provided token is valid.
	 *
	 * @param $token
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function verify ($token) {
		// Check if token exists.
		$verification = Verification::where('verification_token', $token)->first();
		if (isEmpty($verification))
			return redirect('/verification')->withErrors([
				'message' => 'Nepravilna aktivacija koda.'
			]);

		// Check if user exists.
		$user = User::find($verification->user_id);
		if (isEmpty($user))
			return redirect('/verification')->withErrors([
				'message' => 'Uporabnik s to aktivacijsko kodo ni bil najden.'
			]);

		// Check if token is still valid.
		if ($verification->value('verification_expiry') < Carbon::now()) {
			// Change token and resend it.
			return $this->update($user->email);
		}

		// Verify user with provided token.
		$user->active = 1;
		$user->save();

		// Remove verification token from database.
		$verification->delete();

		// Send user to login page.
		return redirect('/prijava')->with([
			'status' => 'Račun uspešno aktiviran.'
		]);
	}

	/**
	 * Update verification token for user with given email address and resend it.
	 *
	 * @param string $email|null
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update ($email = null) {
		$email = isNull($email) ? request('email') : $email;

		// Retrieve user with provided email address.
		$user = User::where('email', $email)->first();

		// Check if user has been found.
		if (isEmpty($user))
			return redirect()->back()->withErrors([
				'message'	=> 'Uporabnik s tem naslovom ni bil najden.',
				'email'		=> $email
			]);

		// Check if user is already active.
		if ($user->active)
			return redirect('prijava')->withErrors([
				'message' => 'Uporabniški račun je že aktiven.',
				'email'		=> $email
			]);

		// Retrieve current verification token.
		$verification = Verification::where('user_id', $user->user_id)->first();

		// Check if user does not have a verification token.
		if (isEmpty($verification)) {
			// Create new verification token.
			$verification = $this->store($user->user_id);
		} else {
			// Change current token.
			$verification->update($this->store($user->user_id)->attributesToArray());
		}

		// Send new token.
		$this->sendVerificationMail($user, $verification);

		return redirect('/verification')->with([
			'status'	=> 'Na vaš e-mail naslov smo poslali novo aktivacijsko '
							.'povezavo.',
			'email'		=> $email
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
	public function store ($userId) {
		return new Verification([
			'verification_token'	=> Str::random(45),
			'verification_expiry'	=> Carbon::now()
										->addHour(1)->toDateTimeString(),
			'user_id'				=> $userId
		]);
	}


	/**
	 * Send verification token to provided email address.
	 *
	 * @param $user
	 * @param $verification
	 */
	public function sendVerificationMail ($user, $verification) {
		$email = new EmailVerification($user, $verification);

		Mail::to($user->email)->send($email);
	}
}

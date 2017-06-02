<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\ResetLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller {
	use ResetsPasswords;

	/**
	 * Create a new reset password controller instance.
	 *
	 */
	public function __construct () {
		$this->middleware('guest');
	}

	/**
	 * Display password reset form for the given token and email.
	 *
	 * @param string|null $email
	 * @param string|null $token
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit ($email = null, $token = null) {
		// Check if there is data missing and ask for another request.
		if (is_null($email) || is_null($token))
			return view('forgotten')->withErrors([
				'message'	=> 'Prišlo je do napake pri povezavi do obrazca.'
								. ' Prosimo, pošljite ponovno zahtevo.'
				]);

		return view('resetPassword')->with([
			'token' => $token,
			'email' => $email
		]);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function update (Request $request) {
		// Validate request.
		$this->validate($request, [
			'token'		=> 'required',
			'email'		=> 'required|email',
			'password'	=> 'required|confirmed|min:8|max:64'
		]);

		// Check if a user with this email exists.
		$user = User::where('email', $request['email'])->first();
		if (!isset($user))
			return view('forgotten')->withErrors([
				'message'	=> 'Uporabniški račun ni bil najden.'
								. ' Prosimo, pošljite ponovno zahtevo.'
			]);

		// Check if there is actually a reset token.
		$resetLink = ResetLink::where('email', $request['email'])->first();
		if (!isset($resetLink))
			return view('forgotten')->withErrors([
				'message'	=> 'Žeton za ponastavitev ni bil najden.'
								. ' Prosimo, pošljite ponovno zahtevo.'
			]);

		// Check if token is still valid.
		if (Carbon::now()->subHour() > $resetLink->created_at) {
			// Change token and resend it.
			$forgotten = new ForgotPasswordController();
			return $forgotten->update($request);
		}

		// Verify token.
		if ($resetLink->token !== $request['token']) {
			return view('forgotten')->withErrors([
				'message'	=> 'Žeton za ponastavitev ni pravilen.'
								. ' Prosimo, pošljite ponovno zahtevo.'
			]);
		}

		try {
			// Update password
			$user->update([
				'password'	=> bcrypt($request['password'])
			]);

			// Remove reset token.
			$resetLink->delete();

		} catch (\Exception $e) {
			error_log(print_r('Error resetting password: ' . $e, true));

			return back()->with([
				'message'	=> 'Napaka pri ponstavljanju gesla.'
								. ' Prosimo, poskusite ponovno'
				]);
		}


		return redirect('/prijava')->with([
			'status'	=> 'Geslo uspešno ponastavljeno.'
		]);
	}
}

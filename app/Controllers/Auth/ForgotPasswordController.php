<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Mail\EmailResetPassword;
use App\Models\ResetLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller {

	/**
	 * Create a new forgot password controller instance.
	 *
	 */
	public function __construct () {
		$this->middleware('guest');
	}

	/**
	 * Create new reset password link.
	 *
	 * @param $email
	 *
	 * @return ResetLink
	 */
	public function store ($email) {
		return new ResetLink([
			'email'			=> $email,
			'token'			=> Str::random(64),
			'created_at'	=> Carbon::now()->toDateTimeString()
		]);
	}

	/**
	 * Display the form to request a password reset link.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit () {
		return view('forgotten');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update (Request $request) {
		// Check if a user with this email exists.
		$user = User::where('email', $request['email'])->first();
		if (!isset($user))
			return back()->withErrors([
				'message'	=> 'Uporabniški račun ni bil najden.'
			]);

		// Check if user already has a reset link.
		$resetLink = ResetLink::where('email', $request['email'])->first();
		try {
			if (!isset($resetLink)){
				// Create new reset link.
					$resetLink = $this->store($request['email']);
					$resetLink->save();
			} else
				$resetLink->update($this->store($request['email'])->attributesToArray());
		} catch (\Exception $e) {
			error_log(print_r('Error creating reset link: ' . $e, true));

			return back()->withErrors([
				'message'	=> 'Napaka pri ustvarjanju povezave za'
								. ' ponastavitev gesla'
				]);
		}

		// Create mail.
		$mail = new EmailResetPassword($user, $resetLink);

		// Send email with reset links.
		Mail::to($request['email'])->send($mail);

		return redirect('/pozabljeno-geslo')->with([
			'status'	=> 'Na vaš e-mail naslov smo poslali povezavo '
							.'za ponastavitev gesla.',
			'email'		=> $request['email']
		]);
	}
}

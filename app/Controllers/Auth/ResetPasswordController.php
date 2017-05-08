<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller {
	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
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
	public function index ($email = null, $token = null) {
		return view('reset')->with([
			'token' => $token,
			'email' => $email
		]);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store (Request $request) {
		return $this->reset($request);
	}
}

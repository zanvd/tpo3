<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller {
	use SendsPasswordResetEmails;

	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct () {
		$this->middleware('guest');
	}

	/**
	 * Display the form to request a password reset link.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
		return view('forgotten');
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store (Request $request) {
		return $this->sendResetLinkEmail($request);
	}
}

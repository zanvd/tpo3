<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Display profile page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
		return view('changePassword')->with([
			'name' => auth()->user()->person->name,
			'role' => auth()->user()->userRole->user_role_title,
			'lastLogin' => $this->lastLogin(auth()->user())
		]);
	}

	/**
	 * Change users password.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update (Request $request) {
		$this->validate($request, [
			'oldPassword'	=> 'required',
			'password'		=> 'required|confirmed|min:8|max:64'
		]);

		// Retrieve current user.
		$user = auth()->user();

		// Check if the user entered correct old password.
		$credentials = [
			'email'		=> $user->email,
			'password'	=> $request['oldPassword']
		];

		if (!auth()->validate($credentials)) {
			return redirect()->back()->withErrors([
				'message' => 'Napačno staro geslo. Prosimo, poskusite znova.'
			]);
		}

		// Change users password to the new one.
		$user->password = bcrypt($request['password']);
		$user->save();

		// Logout and login the user with new credentials.
		auth()->logout();

		$request->session()->flush();
		$request->session()->regenerate();

		auth()->login($user);

		// Let user know of successful change.
		return redirect('/spremeni-geslo')->with([
			'status' => 'Geslo uspešno spremenjeno.'
		]);
	}
}

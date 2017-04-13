<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

    /**
     * Create a new controller instance.
	 *
     */
	public function __construct() {
		// Allow access only to non-authenticated users.
		// With the exception of destroy method (logout call).
    	$this->middleware('guest', ['except' => 'destroy']);
	}

    /**
     * Display login page.
	 *
     * @return view
     */
    public function index() {
    	return view('login');
	}

    /**
     * Authenticate user with login parameters.
	 *
     */
    public function store() {
    	$email = request('email');
    	$password = request('password');
    	// Try to authenticate user.
		if (!auth()->attempt(['email' => $email, 'password' => $password])) {
			// If authentication fails, return back to login page
			// with error message.
			return view('login')->withErrors([
				'message' => 'Nepravilen email ali geslo. Prosimo, poizkusite znova.'
			]);
		}

		// Authentication succeeded. Redirect to home page.
		return redirect('/');
	}

	/**
	 * Logout user and destroy session.
	 *
	 */
	public function destroy() {
		auth()->logout();

		// Redirect to home page.
		return redirect('/');
	}
}

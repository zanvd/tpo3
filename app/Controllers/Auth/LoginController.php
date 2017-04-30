<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
	 * Redirect to the provided link.
	 *
	 * @param string $link|/
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function redirectTo ($link = '/') {
		return redirect($link);
	}

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

		$user = Auth::user();

		// Check if user exists.
		if ($user === NULL)
			return view('login')->withErrors([
				'message' => 'Napaka pri prijavi. Prosimo, poizkusite znova.'
			]);

		// Check if user has been activated.
		if (!$user->active)
			return view('login')->withErrors([
				'message' => 'Prosimo, aktivirajte račun.'
			]);

		// Redirect to the appropriate page based on user's role.
		$role = $user->userRole->user_role_title;

		switch ($role) {
			case 'admin':
				return $this->redirectTo('administrator/profil');
				break;
			case 'zaposleni':
				return $this->redirectTo('zaposleni/profil');
				break;
			case 'pacient':
				return $this->redirectTo('pacient/profil');
				break;
			default:
				// Something went wrong.
				// Logout user and ask them to try again.
				auth()->logout();
				return view('login')->withErrors([
					'message' => 'Napaka pri prijavi. Prosimo, poizkusite znova.'
				]);
		}
	}

	/**
	 * Logout user and destroy session.
	 *
	 */
	public function destroy() {
		auth()->logout();

		 return $this->redirectTo();
	}
}

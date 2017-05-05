<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller {
	use RedirectsUsers, ThrottlesLogins;

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
     * @return \Illuminate\Http\Response
     */
    public function index() {
    	return view('login');
	}

	/**
	 * Authenticate user with login parameters.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
    public function store(Request $request) {
    	// Check if both email and password are provided.
		$this->validateLogin($request);

    	// Check for too many login attempts.
		if ($this->hasTooManyLoginAttempts($request)) {
			// Fire lockout event.
			$this->fireLockoutEvent($request);

			// Notify user about temporary access lock.
			return $this->sendLockoutResponse($request);
		}

		// Check if user has been activated.
		$user = User::where('email', $request['email'])->first();
		if (!$user->active)
			return $this->redirectTo('prijava', Lang::get('activate'));

		// Unset user variable.
		unset($user);

		// Try to authenticate user.
		if (!$this->login($request)) {
			$this->incrementLoginAttempts($request);
			// If authentication fails, return back to login page
			// with error message.

			return $this->redirectTo('prijava', Lang::get('auth.failed'));
		}

		$user = Auth::user();

		// Check if user exists.
		if ($user === NULL)
			return $this->redirectTo('prijava',
				'Napaka pri prijavi. Prosimo, poizkusite znova.'
			);

		// Retrieve user's last login.
		$lastLogin = $this->lastLogin($user);

		// Redirect to the appropriate page based on user's role.
		$role = $user->userRole->user_role_title;

		switch ($role) {
			case 'Admin':
				return $this->redirectTo('administrator/profil')
							->with([
								'name' => $user->person->name,
								'role' => $role,
								'lastLogin' => $lastLogin
							]);
				break;
			case 'zaposleni':
				return $this->redirectTo('zaposleni/profil')
							->with([
									   'name' => $user->person->name,
									   'role' => $role,
									   'lastLogin' => $lastLogin
								   ]);
				break;
			case 'pacient':
				return $this->redirectTo('pacient/profil')
							->with([
									   'name' => $user->person->name,
									   'role' => $role,
									   'lastLogin' => $lastLogin
								   ]);
				break;
			default:
				// Something went wrong.
				// Logout user and ask them to try again.
				auth()->logout();

				$request->session()->flush();
				$request->session()->regenerate();

				return $this->redirectTo('prijava',
					'Napaka pri prijavi. Prosimo, poizkusite znova.'
				);
		}
	}

	/**
	 * Logout user and reset session.
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy(Request $request) {
		// Set new last login to current timestamp.
		request()->user()->last_login = Carbon::now()->toDateTimeString();
		request()->user()->save();

		auth()->logout();

		$request->session()->flush();
		$request->session()->regenerate();

		return $this->redirectTo();
	}

	/**
	 * Redirect to the provided link.
	 *
	 * @param string $link | /
	 * @param string $message | null
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	protected function redirectTo ($link = '/', $message = null) {
		// If error message is set, return to login page with errors set.
		if ($message !== null)
			return redirect()->back()->withErrors([
				'message' => $message
			]);
		return redirect($link);
	}

	/**
	 * Validate form fields.
	 *
	 * @param Request $request
	 *
	 */
	protected function validateLogin (Request $request) {
		$this->validate($request, [
			$this->username()	=> 'required',
			'password'			=> 'required'
		]);
	}

	/**
	 * Return name of field which is used as username.
	 * Required for Throttle key.
	 *
	 * @return string
	 */
	protected function username () {
		return 'email';
	}

	/**
	 * Perform a login attempt.
	 *
	 * @param Request $request
	 *
	 * @return boolean
	 */
	protected function login (Request $request) {
		return auth()->attempt([
				$this->username()	=> $request[$this->username()],
				'password'			=> $request['password']
			],
			$request->has('remember')
		);
	}
}

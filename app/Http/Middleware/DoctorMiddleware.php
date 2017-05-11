<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DoctorMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param $request
	 * @param Closure $next
	 * @param $guard|null
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function handle ($request, Closure $next, $guard = null) {
		// Check if user is authenticated and has a role of doctor.
		$user = Auth::guard($guard)->authenticate();
		if (!is_null($user) && $user->userRole->user_role_title !== 'Zdravnik')
			return redirect('/');

		return $next($request);
	}
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class NurseMiddleware {
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
		// Check if user is authenticated and has a role of nurse.
		$user = Auth::guard($guard)->authenticate();
		if (!is_null($user) && $user->userRole->user_role_title !== 'Patronažna sestra')
			return redirect('/');

		return $next($request);
	}
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param          $request
	 * @param \Closure $next
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 */
	public function handle ($request, Closure $next, $guard = null) {
		// Check if user is authenticated and has a role of Admin.
		$user = Auth::guard($guard)->authenticate();
		if ($user !== null && $user->userRole->user_role_title !== 'Admin')
			return redirect('/');

		return $next($request);
	}
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param         $request
	 * @param Closure $next
	 * @param         $roles
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 *
	 */
	public function handle ($request, Closure $next, $roles) {
		// Explode roles by delimiter.
		if (!is_array($roles)) {
			$roles = explode('|', $roles);
		}

		$user = Auth::user();
		// Check if user is authenticated and has desired roles.
		if (Auth::guest() || !$user->hasRole($roles))
			return redirect('/')->withErrors([
				'message' => 'Nedvoljen dostop.'
			]);

		return $next($request);
	}
}
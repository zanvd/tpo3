<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param         $request
	 * @param Closure $next
	 * @param         $roles
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
	 * @internal param $role
	 *
	 */
	public function handle ($request, Closure $next, $roles) {
		// Explode roles by delimiter.
		if (!is_array($roles)) {
			$roles = explode('|', $roles);
		}

		// Check if user is authenticated and has desired roles.
		$user = $request->user();
		if (!is_null($user) && !$user->hasRole($roles, is_array($roles)))
			return redirect('/')->withErrors([
				'message' => 'Nedvoljen dostop.'
			]);

		return $next($request);
	}
}
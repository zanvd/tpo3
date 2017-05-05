<?php

namespace App\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Retrieve last login information and format it to Slovene locale.
	 *
	 * @param User $user
	 *
	 * @return string
	 */
	protected  function lastLogin ($user = null) {
		return $user->last_login != null ?
			Carbon::createFromFormat('Y-m-d H:i:s', $user->last_login)
				  ->format('d.m.Y H:i')
			: 'Nikoli';
	}
}

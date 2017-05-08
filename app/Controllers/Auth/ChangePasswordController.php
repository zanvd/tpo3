<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;

class ChangePasswordController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct() {
		$this->middleware('auth');
	}
}

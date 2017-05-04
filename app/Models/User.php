<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements CanResetPassword {
	use Notifiable;

	protected $table = 'User';

	protected $primaryKey = 'user_id';

	public $timestamps = false;

	public function userRole () {
		return $this->belongsTo('App\Models\UserRole',
								'user_role_id',
								'user_role_id'
		);
	}
}

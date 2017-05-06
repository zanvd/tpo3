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

	// All fields can be mass assigned.
	protected $guarded = [];

	/**
	 * One User belongs to one UserRole.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function userRole () {
		return $this->belongsTo(
			'App\Models\UserRole',
			'user_role_id',
			'user_role_id'
		);
	}

	/**
	 * One User belongs to one Person.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function person() {
		return $this->belongsTo(
			'App\Models\Person',
			'person_id',
			'person_id'
		);
	}
}

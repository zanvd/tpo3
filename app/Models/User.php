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
	 * Check if user has provided role.
	 *
	 * @param      $roles
	 * @param bool $all
	 *
	 * @return bool
	 * @internal param $role
	 */
	public function hasRole ($roles, $all = false) {
		// Check if multiple roles were specified.
		if (is_array($roles)) {
			// Iterate over provided roles.
			foreach ($roles as $role) {
				// Check for role with nested call.
				$temp = $this->hasRole($role);

				// For OR it's enough if we find just one.
				if ($temp && !$all)
					return true;
				// For AND we have to have all.
				else if (!$temp && $all)
					return false;
			}

			// It's either all roles were found or none.
			return $all;
		} else {
			// Iterate over all user roles.
			$userRoles = UserRole::all();
			foreach ($userRoles as $userRole) {
				if ($userRole == $roles)
					return true;
			}
		}
		return false;
	}

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

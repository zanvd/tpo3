<?php

namespace App\Models;


use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Database\Eloquent\Model;

class Uporabnik extends Model implements AuthenticatableContract {
	use Authenticatable;

	// Set table name.
	protected $table = 'Uporabnik';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_uporabnik';

	/**
	 * Overrides the method to ignore the remember token.
	 */
	public function setAttribute($key, $value) {
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute) {
			parent::setAttribute($key, $value);
		}
	}
}

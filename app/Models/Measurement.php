<?php

namespace App\Models;

class Measurement extends Model {
	protected $table = 'Measurement';

	protected $primaryKey = 'measurement_id';

	public function input () {
		return $this->hasMany(
			'App\Models\Input',
			'measurement_id',
			'measurement_id'
		);
	}
}

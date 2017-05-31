<?php

namespace App\Models;

class Visit_Measurement extends Model {
	protected $table = 'Visit_Measurement';

	// There is no primary key in this table.
	protected $primaryKey = null;
	public $incrementing = false;

	/**
	 * Bind relation table with Measurement table.
	 *
	 * One Visit can have many Measurements.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function measurement () {
		return $this->belongsTo(
			'App\Models\Measurement',
			'measurement_id',
			'measurement_id'
		);
	}
}

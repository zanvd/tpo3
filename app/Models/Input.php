<?php

namespace App\Models;

class Input extends Model {
	protected $table = 'Input';

	protected $primaryKey = 'input_id';

	/**
	 * One Input belongs to one Measurement.
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

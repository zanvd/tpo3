<?php

namespace App\Models;

class WorkOrder_BloodTube extends Model {
    protected $table = 'WorkOrder_BloodTube';

	/**
	 * Bind relation table with Blood Tube table.
	 *
	 * One Work Order can have many Blood tubes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function bloodTube () {
		return $this->belongsToMany(
			'App\Models\BloodTube',
			'blood_tube_id',
			'blood_tube_id'
		);
	}
}

<?php

namespace App\Models;

class WorkOrder_BloodTube extends Model {
    protected $table = 'WorkOrder_BloodTube';

	// There is no primary key in this table.
	protected $primaryKey = null;

	public $incrementing = false;

	/**
	 * Bind relation table with Blood Tube table.
	 *
	 * One Work Order can have many Blood tubes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function bloodTube () {
		return $this->belongsTo(
			'App\Models\BloodTube',
			'blood_tube_id',
			'blood_tube_id'
		);
	}
}

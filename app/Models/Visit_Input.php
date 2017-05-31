<?php

namespace App\Models;

class Visit_Input extends Model {
	protected $table = 'Visit_Input';

	// There is no primary key in this table.
	protected $primaryKey = null;
	public $incrementing = false;

	/**
	 * Bind relation table with Input table.
	 *
	 * One Visit can have many Inputs.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function input () {
		return $this->belongsTo(
			'App\Models\Input',
			'input_id',
			'input_id'
		);
	}
}

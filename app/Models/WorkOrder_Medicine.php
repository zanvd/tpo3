<?php

namespace App\Models;

class WorkOrder_Medicine extends Model {
    protected $table = 'WorkOrder_Medicine';

	// There is no primary key in this table.
	protected $primaryKey = null;

	public $incrementing = false;

	/**
	 * Bind relation table with Medicine table.
	 *
	 * One Medicine can belong to many Work Orders.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function medicine () {
    	return $this->belongsTo(
    		'App\Models\Medicine',
			'medicine_id',
			'medicine_id'
		);
	}
}

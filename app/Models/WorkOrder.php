<?php

namespace App\Models;

class WorkOrder extends Model {
    protected $table = 'WorkOrder';

    protected $primaryKey = 'work_order_id';

	/**
	 * One Work Order belongs to one Prescriber (Employee).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function prescriber () {
    	return $this->belongsTo(
    		'App\Model\Employee',
			'prescriber_id',
			'employee_id');
	}

	/**
	 * One Work Order belongs to one Performer (Employee).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function performer () {
    	return $this->belongsTo(
    		'App\Model\Employee',
			'performer_id',
			'employee_id');
	}

	/**
	 * One Work Order belongs to one Substitution.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function substitution () {
    	return $this->belongsTo(
    		'App\Model\Substitution',
			'substitution_id',
			'substitution_id');
	}
}

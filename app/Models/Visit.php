<?php

namespace App\Models;

class Visit extends Model {
    protected $table = 'Visit';

    protected $primaryKey = 'visit_id';

	/**
	 * One Visit belongs to one Substitution.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function substitution () {
		return $this->belongsTo(
			'App\Models\Substitution',
			'substitution_id',
			'substitution_id');
	}

    public function workorder () {
        return $this->belongsTo(
            'App\Models\WorkOrder',
            'work_order_id',
            'work_order_id');
    }
}

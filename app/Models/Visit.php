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

	/**
	 * One Visit belongs to one Work order.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function workOrder () {
		return $this->belongsTo(
			'App\Models\WorkOrder',
			'work_order_id',
			'work_order_id');
	}

	/**
	 * One Visit has many Inputs.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function inputRel () {
		return $this->hasMany(
			'App\Models\Visit_Input',
			'visit_id',
			'visit_id'
		);
	}

	/**
	*One Visit belongs to one visit_subtype
	*/

	public function visit_subtype() {
        return $this->belongsTo(
            'App\Models\VisitSubtype',
            'visit_subtype_id',
            'visit_subtype_id'
        );
    }
}

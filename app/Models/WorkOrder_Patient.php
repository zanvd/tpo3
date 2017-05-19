<?php

namespace App\Models;

class WorkOrder_Patient extends Model {
    protected $table = 'WorkOrder_Patient';

    public function work_order() {
        return $this->belongsTo(
            'App\Models\WorkOrder',
            'work_order_id',
            'work_order_id'
        );
    }


	// There is no primary key in this table.
	protected $primaryKey = null;

	public $incrementing = false;

    protected function patient() {
        return $this->hasOne(
            'App\Models\Patient',
            'patient_id',
            'patient_id'
        );
    }
}
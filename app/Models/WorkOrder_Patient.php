<?php

namespace App\Models;

class WorkOrder_Patient extends Model {
    protected $table = 'WorkOrder_Patient';

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
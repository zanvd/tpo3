<?php

namespace App\Models;

class WorkOrder_Patient extends Model {
    protected $table = 'WorkOrder_Patient';

    protected function patient() {
        return $this->hasOne(
            'App\Models\Patient',
            'patient_id',
            'patient_id'
        );
    }
}
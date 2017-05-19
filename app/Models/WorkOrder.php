<?php

namespace App\Models;

class WorkOrder extends Model {
    protected $table = 'WorkOrder';

    protected $primaryKey = 'work_order_id';

    public function work_order_patient() {
        return $this->hasMany(
            'App\Models\WorkOrder_Patient'
        );
    }

    public function visit() {
        return $this->hasMany(
            'App\Models\Visit',
            'work_order_id',
            'work_order_id'
        );
    }

     public function performer_employee() {
        return $this->belongsTo(
            'App\Models\Employee',
            'performer_id',
            'performer_id'
        );
    }
}

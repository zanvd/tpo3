<?php

namespace App\Models;

class Plan_Material extends Model {
    protected $table = 'Plan_Material';

    protected $primaryKey = null;

    public $incrementing = false;

    public function plan () {
        return $this->belongsTo(
            'App\Models\Plan',
            'plan_id',
            'plan_id'
        );
    }

    public function material () {
        return $this->belongsTo(
            'App\Models\Material',
            'material_id',
            'material_id'
        );
    }
}

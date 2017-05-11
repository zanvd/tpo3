<?php

namespace App\Models;

class Patient extends Model {
    protected $table = 'Patient';

    protected $primaryKey = 'patient_id';

    public function person() {
        return $this->belongsTo(
            'App\Models\Person',
            'person_id',
            'person_id'
        );
    }
}

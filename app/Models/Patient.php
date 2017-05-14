<?php

namespace App\Models;

class Patient extends Model {
    protected $table = 'Patient';

    protected $primaryKey = 'patient_id';

	/**
	 * One Person belong to one Patient.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function person() {
        return $this->belongsTo(
            'App\Models\Person',
            'person_id',
            'person_id'
        );
    }
}

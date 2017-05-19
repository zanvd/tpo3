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
    public function work_order_patient() {
        return $this->belongsToMany(
            'App\Models\WorkOrder_Patient',
            'patient_id',
            'patient_id'
        );
    }

	/**
	 * One Patient can be assigned as Guardian many times.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function guardian () {
    	return $this->hasMany(
    		'App\Models\DependentPatient',
			'guardian_patient_id',
			'patient_id'
		);
	}

	/**
	 * One Patient can be assigned as Dependent many times.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function dependent () {
		return $this->hasMany(
			'App\Models\DependentPatient',
			'dependent_patient_id',
			'patient_id'
		);
	}
}

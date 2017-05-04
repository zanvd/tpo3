<?php

namespace App\Models;

class Employee extends Model {
	protected $table = 'Employee';

	protected $primaryKey = 'employee_id';

	/**
	 * One Employee belongs to one Person.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function person () {
		return $this->belongsTo(
			'App\Models\Person',
			'person_id',
			'person_id'
		);
	}

	/**
	 * One Employee belongs to one Institution.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function institution () {
		return $this->belongsTo(
			'App\Models\Institution',
			'institution_id',
			'institution_id'
		);
	}
}

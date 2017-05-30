<?php

namespace App\Models;

class Substitution extends Model {
	protected $table = 'Substitution';

	protected $primaryKey = 'substitution_id';

	/**
	 * One Substitution belongs to one substitution Employee.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function employeeSubstitution () {
		return $this->belongsTo(
			'App\Models\Employee',
			'employee_substitution',
			'employee_id');
	}

	/**
	 * One Substitution has many Visits.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function visit () {
		return $this->hasMany(
			'App\Models\Visit',
			'substitution_id',
			'substitution_id'
		);
	}
}

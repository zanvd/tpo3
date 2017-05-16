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
			'App\Model\Employee',
			'employee_substitution',
			'employee_id');
	}
}

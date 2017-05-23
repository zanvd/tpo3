<?php

namespace App\Models;

class Visit extends Model {
    protected $table = 'Visit';

    protected $primaryKey = 'visit_id';

	/**
	 * One Visit has one Substitution.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function substitution () {
		return $this->hasOne(
			'App\Models\Substitution',
			'substitution_id',
			'substitution_id');
	}
}

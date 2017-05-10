<?php

namespace App\Models;

class DependentPatient extends Model {
	protected $table = 'DependentPatient';

	// There is no primary key in this table.
	protected $primaryKey = null;
	public $incrementing = false;
}

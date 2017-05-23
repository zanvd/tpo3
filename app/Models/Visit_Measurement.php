<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit_Measurement extends Model {
	protected $table = 'Visit_Measurement';

	// There is no primary key in this table.
	protected $primaryKey = null;
	public $incrementing = false;
}

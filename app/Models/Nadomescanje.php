<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nadomescanje extends Model {
	// Set table name.
	protected $table = 'Nadomescanje';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_nadomescanje';
}

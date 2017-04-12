<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meritev extends Model {
	// Set table name.
	protected $table = 'Meritev';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_meritev';
}

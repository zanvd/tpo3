<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelavecZd extends Model {
	// Set table name.
	protected $table = 'Delavec_ZD';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_delavec';
	// Set incrementing to off.
	public $incrementing = false;
}

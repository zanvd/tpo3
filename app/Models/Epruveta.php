<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epruveta extends Model {
	// Set table name.
	protected $table = 'Epruveta';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_epruveta';
}

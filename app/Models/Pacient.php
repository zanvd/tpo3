<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pacient extends Model {
	// Set table name.
	protected $table = 'Pacient';
	// Disable timestamps.
	public $timestamps = false;
}

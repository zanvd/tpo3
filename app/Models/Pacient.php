<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacient extends Model {
	// Set table name.
	protected $table = 'Pacient';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_pacient';
}

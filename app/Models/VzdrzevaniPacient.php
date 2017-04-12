<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VzdrzevaniPacient extends Model {
	// Set table name.
	protected $table = 'Vzdrzevani_pacient';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_vzd_pacient';
}

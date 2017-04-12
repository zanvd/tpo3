<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontaktnaOseba extends Model {
	// Set table name.
	protected $table = 'Kontaktna_oseba';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_kontaktna_oseba';
}

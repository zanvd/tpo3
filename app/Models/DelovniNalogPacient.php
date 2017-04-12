<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelovniNalogPacient extends Model {
	// Set table name.
	protected $table = 'Delovni_nalog_Pacient';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_dn_pac';
}

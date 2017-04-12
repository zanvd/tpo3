<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelovniNalogZdravilo extends Model {
	// Set table name.
	protected $table = 'Delovni_nalog_Zdravilo';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_dn_zdr';
}

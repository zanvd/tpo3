<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelovniNalogMaterial extends Model {
	// Set table name.
	protected $table = 'Delovni_nalog_Material';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_dn_mat';
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelovniNalog extends Model {
	// Set table name.
	protected $table = 'Delovni_nalog';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_delovni_nalog';
}

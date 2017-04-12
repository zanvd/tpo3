<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KrovnaMeritev extends Model {
	// Set table name.
	protected $table = 'Krovna_meritev';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_krovna_meritev';
}

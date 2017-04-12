<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzvajalecZdravstvenihStoritev extends Model {
	// Set table name.
	protected $table = 'Izvajalec_zdravstvenih_storitev';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_izvajalec';
}

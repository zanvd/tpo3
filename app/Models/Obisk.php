<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obisk extends Model {
	// Set table name.
	protected $table = 'Obisk';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_obisk';
}

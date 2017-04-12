<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model {
	// Set table name.
	protected $table = 'Material';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_material';
}

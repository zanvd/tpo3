<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storitev extends Model {
	// Set table name.
	protected $table = 'Storitev';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_storitev';
}

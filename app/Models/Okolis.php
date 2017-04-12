<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Okolis extends Model {
	// Set table name.
	protected $table = 'Okolis';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_okolis';
}

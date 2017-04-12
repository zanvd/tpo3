<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uporabnik extends Model {
	// Set table name.
	protected $table = 'Uporabnik';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_uporabnik';
}

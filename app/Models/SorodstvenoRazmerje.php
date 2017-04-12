<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SorodstvenoRazmerje extends Model {
	// Set table name.
	protected $table = 'Sorodstveno_razmerje';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey ='id_sorodstveno_razmerje';
}

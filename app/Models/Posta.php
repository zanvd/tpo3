<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posta extends Model {
	// Set table name.
	protected $table = 'Posta';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'postna_stevilka';
	// Set incrementing to off.
	public $incrementing = false;
}

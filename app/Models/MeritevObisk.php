<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeritevObisk extends Model {
	// Set table name.
	protected $table = 'Meritev_Obisk';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = ['meritev', 'obisk'];
}

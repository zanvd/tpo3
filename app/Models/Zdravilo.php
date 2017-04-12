<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zdravilo extends Model {
	// Set table name.
	protected $table = 'Zdravilo';
	// Disable timestamps.
	public $timestamps = false;
	// Set primary key.
	protected $primaryKey = 'id_zdravilo';
}

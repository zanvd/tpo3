<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel {
	public $timestamps = false;

	// All fields can be mass assigned.
	protected $guarded = [];
}

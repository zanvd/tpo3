<?php

namespace App\Models;

class Region extends Model {
	protected $table = 'Region';

	protected $primaryKey = 'region_id';

    public function region() {
        return $this->hasMany(
            'App\Models\Person',
            'region_id',
            'region_id'
        );
    }
}

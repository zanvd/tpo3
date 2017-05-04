<?php

namespace App\Models;

class Person extends Model {
	protected $table = 'Person';

	protected $primaryKey = 'person_id';

	/**
	 * One Person belongs to one Post.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function post () {
		return $this->belongsTo(
			'App\Models\Person',
			'post_number',
			'post_number'
		);
	}

	/**
	 * One Person belongs to one Region.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function region() {
		return $this->belongsTo(
			'App\Models\Region',
			'region_id',
			'region_id'
		);
	}
}

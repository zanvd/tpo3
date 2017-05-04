<?php

namespace App\Models;

class Institution extends Model {
	protected $table = 'Institution';

	protected $primaryKey = 'institution_id';

	/**
	 * One Institution belongs to one Post.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function post () {
		return $this->belongsTo(
			'App\Models\Post',
			'post_number',
			'post_number'
		);
	}
}

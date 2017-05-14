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
	public function region () {
		return $this->belongsTo(
			'App\Models\Region',
			'region_id',
			'region_id'
		);
	}

    /**
     * One Person has one User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
	public function user () {
	    return $this->hasOne(
	        'App\Models\User',
            'person_id',
            'person_id'
        );
    }

	/**
	 * One Person has one Patient.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function patient () {
		return $this->hasOne(
			'App\Models\Patient',
			'person_id',
			'person_id'
		);
	}
}

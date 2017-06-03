<?php

namespace App\Models;

class Medicine extends Model {
    protected $table = 'Medicine';

    protected $primaryKey = 'medicine_id';

	/**
	 * Get all Medicines for given Work Order.
	 *
	 * @param $wom
	 *
	 * @return array
	 *
	 */
	public static function getMedicinesForWorkOrder ($wom) {
		$medicines = [];
		foreach ($wom as $relation) {
			$medicines[] = $relation->medicine;
		}
		return $medicines;
	}
}
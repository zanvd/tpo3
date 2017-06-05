<?php

namespace App\Models;

class Medicine extends Model {
    protected $table = 'Medicine';

    protected $primaryKey = 'medicine_id';

    public $incrementing = false;

	/**
	 * Get all Medicines for given Work Order.
	 *
	 * @param WorkOrder_Medicine $wom
	 *
	 * @return array
	 *
	 */
	public static function getMedicinesForWorkOrder (WorkOrder_Medicine $wom) {
		$medicines = [];
		foreach ($wom as $relation) {
			$medicines[] = $relation->medicine;
		}
		return $medicines;
	}
}
<?php

namespace App\Models;

class BloodTube extends Model {
    protected $table = 'BloodTube';

    protected $primaryKey = 'blood_tube_id';

	public $incrementing = false;

	/**
	 * Get number of Blood Tubes by color for given Work Order.
	 *
	 * @param $wob
	 *
	 * @return array
	 */
	public static function getBloodTubesByColor ($wob) {
		$bloodTubes = [];
		foreach ($wob as $relation) {
			$color = $relation->bloodTube->color;

			switch ($color) {
				case 'Rdeča':
					$bloodTubes['red'] = $relation->num_of_tubes;
					$bloodTubes['redId'] = $relation->blood_tube_id;
					break;
				case 'Modra':
					$bloodTubes['blue'] = $relation->num_of_tubes;
					$bloodTubes['blueId'] = $relation->blood_tube_id;
					break;
				case 'Zelena':
					$bloodTubes['green'] = $relation->num_of_tubes;
					$bloodTubes['greenId'] = $relation->blood_tube_id;
					break;
				case 'Rumena':
					$bloodTubes['yellow'] = $relation->num_of_tubes;
					$bloodTubes['yellowId'] = $relation->blood_tube_id;
					break;
			}
		}
		return $bloodTubes;
	}
}

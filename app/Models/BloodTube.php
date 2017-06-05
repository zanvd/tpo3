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
		foreach ($wob as $bloodTube) {
			$color = $bloodTube->bloodTube->color;

			switch ($color) {
				case 'Rdeča':
					$bloodTubes['red'] = $bloodTube->num_of_tubes;
					break;
				case 'Modra':
					$bloodTubes['blue'] = $bloodTube->num_of_tubes;
					break;
				case 'Zelena':
					$bloodTubes['green'] = $bloodTube->num_of_tubes;
					break;
				case 'Rumena':
					$bloodTubes['yellow'] = $bloodTube->num_of_tubes;
					break;
			}
		}
		return $bloodTubes;
	}
}

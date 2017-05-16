<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Pagination\AbstractPaginator;

class Model extends EloquentModel {
	public $timestamps = false;

	// All fields can be mass assigned.
	protected $guarded = [];

	/**
	 * Casts a given array or collection to this model class if it isn't
	 *  already
	 *
	 * @link https://gist.github.com/danken00/3f30af1c700f29227985
	 *
	 * @param mixed $results Collection/array/pagintor to cast
	 * @return mixed EloquentCollection or pagination object depending
	 *  on what was passed in
	 */
	static function castStdToEloquent($results) {
		// If the object being passed in is a paginator, let's create
		//  another paginator with the updated results
		$isPaginator = is_a($results, AbstractPaginator::class);

		$resultsToCast = $isPaginator ? $results->items() : $results;

		// Item is an array. Check to make sure each item within that array
		//  is of the correct type, and cast if not
		if (is_array($resultsToCast))
		{
			$castResults = new EloquentCollection();

			foreach ($resultsToCast as $objectToCast)
			{
				if (!is_a($objectToCast, self::class))
				{
					$castResults->push((new static)->newFromBuilder($objectToCast));
				}
				else
				{
					$castResults->push($objectToCast);
				}
			}
		}
		else
		{
			$castResults = $resultsToCast;
		}

		// If the original object was a paginator, then re-create it as
		//  best we can
		if ($isPaginator)
		{
			$paginatorClass = get_class($results);
			$newPaginator = new $paginatorClass($castResults, $results->total(), $results->perPage(), $results->currentPage());
			$newPaginator->setPath($results->resolveCurrentPath());
			return $newPaginator;
		}
		else
		{
			return $castResults;
		}
	}
}

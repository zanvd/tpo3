<?php

namespace App\Models;

class WorkOrder extends Model {
    protected $table = 'WorkOrder';

    protected $primaryKey = 'work_order_id';

	/**
	 * One Work Order belongs to one Prescriber (Employee).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function prescriber () {
    	return $this->belongsTo(
    		'App\Models\Employee',
			'prescriber_id',
			'employee_id');
	}

	/**
	 * One Work Order belongs to one Performer (Employee).
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    public function performer () {
    	return $this->belongsTo(
    		'App\Models\Employee',
			'performer_id',
			'employee_id');
	}

	public function patients() {
        return $this->hasMany(
            'App\Models\WorkOrder_Patient',
            'work_order_id',
            'work_order_id');
    }

	/**
	 * One Work Order belongs to one VisitSubtype.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function visitSubtype () {
		return $this->belongsTo(
			'App\Models\VisitSubtype',
			'visit_subtype_id',
			'visit_subtype_id');
	}

	/**
	 * One Work Order has many Visits.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function visit () {
		return $this->hasMany(
			'App\Models\Visit',
			'work_order_id',
			'work_order_id');
	}

	/**
	 * Bind Work Order table with relation table.
	 *
	 * One Work Order has many Medicines.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function medicineRel () {
		return $this->hasMany(
			'App\Models\WorkOrder_Medicine',
			'work_order_id',
			'work_order_id'
		);
	}

	/**
	 * Bind Work Order table with relation table.
	 *
	 * One Work Order has many Blood Tubes.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function bloodTubeRel () {
		return $this->hasMany(
			'App\Models\WorkOrder_BloodTube',
			'work_order_id',
			'work_order_id'
		);
	}

	/**
	 * Get Work Order data by given ID.
	 * Store additional information about performer.
	 *
	 * @param $workOrderId
	 *
	 * @return \App\Models\WorkOrder
	 */
	public static function getWorkOrderWithPerformer ($workOrderId) {
		$workOrder = WorkOrder::find($workOrderId);

		// Store performer data.
		$workOrder->performer = $workOrder->performer->employee_id . ' '
								. $workOrder->performer->person->name . ' '
								. $workOrder->performer->person->surname;

		return $workOrder;
	}
}

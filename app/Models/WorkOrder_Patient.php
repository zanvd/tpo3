<?php

namespace App\Models;

class WorkOrder_Patient extends Model {
    protected $table = 'WorkOrder_Patient';

	// There is no primary key in this table.
	protected $primaryKey = null;

	public $incrementing = false;

	/**
	 * Bind relation table with Patient table.
	 *
	 * One relation entry belongs to one Patient.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
    protected function patient() {
        return $this->belongsTo(
            'App\Models\Patient',
            'patient_id',
            'patient_id'
        );
    }

	/**
	 * Get all Patients under given Work Order.
	 *
	 * @param WorkOrder $workOrder
	 *
	 * @return mixed
	 */
    public static function getPatientsForWorkOrder (WorkOrder $workOrder) {
		$workOrderPatients = WorkOrder_Patient
			::join('WorkOrder AS Wo', function ($join) use ($workOrder) {
				$join->on(
					'WorkOrder_Patient.work_order_id',
					'=',
					'Wo.work_order_id'
				)
					 ->where('Wo.work_order_id', '=', $workOrder->work_order_id);
			})
			->join('Patient As Pat',
				   'WorkOrder_Patient.patient_id',
				   '=',
				   'Pat.patient_id')
			->select('WorkOrder_Patient.patient_id')
			->get();

		return $workOrderPatients->map(function ($wop){
			return $wop->patient;
		});
	}
}
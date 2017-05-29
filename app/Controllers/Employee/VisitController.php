<?php

namespace App\Controllers\Employee;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\WorkOrder;
use App\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller {

	public function __construct() {
		// Medical personal can access visit functionality.
		$this->middleware('role:Zdravnik|Vodja PS|Patronažna sestra');
	}

	/**
	 * Display page with listed visits.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {

	}


	/**
	 * Display details about requested visit.
	 *
	 * @param Visit $visit
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show (Visit $visit) {

		$workOrder = WorkOrder::where('work_order_id', $visit->work_order_id)->first();
		$type = $workOrder->visitSubtype->visit_subtype_title;
		$workOrder->type = $type;
		$workOrder->performer = $workOrder->performer->employee_id . ' '
			. $workOrder->performer->person->name . ' '
			. $workOrder->performer->person->surname;
		$patients = DB::table('WorkOrder_Patient')
			->join('WorkOrder AS Wo', function ($join) use ($workOrder) {
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
			->select('Pat.*')
			->get()
			->toArray(); // Return array instead of Collection.

		// DB returns stdObjects but we require Eloquent Models.
		// Cast stdObject to Patient Model.
		$patients = Patient::castStdToEloquent($patients);

		foreach ($patients as $pat) {
			// Store data about patient.
			$pat->person->region = $pat->person->region->region_title;

			$pat->birth_date = Carbon::createFromFormat('Y-m-d',
				$pat->birth_date)
				->format('d.m.Y');

			// Check if work order type is of type mother and newborn.
			if ($type == 'Obisk novorojenčka in otročnice') {
				// Check whether this patient is mother or child
				if (!$pat->dependent->isEmpty()) {
					$relationship = $pat->dependent[0]->relationship->relationship_type;
					if ($relationship == 'Hči' || $relationship == 'Sin')
						$children[] = $pat;
				}
				else {
					$patient = $pat;
				}
			} else
				$patient = $pat;
		}

		return view('visit', compact(
			'visit',
			'workOrder',
			'patient',
			'children'
//            'visits',
//            'medicines',
//            'bloodTubes'
		))->with([
			'name'			=> auth()->user()->person->name . ' '
				. auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user())
		]);
	}
}
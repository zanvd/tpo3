<?php

namespace App\Controllers\Employee;

use App\Models\Employee;
use App\Models\Patient;
use App\Models\Substitution;
use App\Models\Visit;
use App\Models\WorkOrder;
use App\Controllers\Controller;
use App\Models\WorkOrder_Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller {

	public function __construct() {
		// Medical personal can view visits.
		$this->middleware('role:Zdravnik|Vodja PS|Patronažna sestra')
			 ->except(['edit', 'update']);
		// Nurses can edit visit data.
		$this->middleware('role:Patronažna sestra')
			 ->only(['edit', 'update']);
	}

	/**
	 * Display page with listed visits.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {

	    $user = auth()->user();
        $userRole = $user->userRole->user_role_title;
        $employeeId = $user->person->employee->employee_id;

        switch($userRole) {
            case "Zdravnik":
                $workOrderIds = WorkOrder::select('work_order_id')->where('prescriber_id', $employeeId)->get();
                $visits = Visit::wherein('work_order_id', $workOrderIds)->get();
                break;
            case "Vodja PS":
                $visits = Visit::all();
                break;
            case "Patronažna sestra":
                // Finds array of employee_id-s that are absent
                $visits = Visit::all();
                $visits = $visits->filter(
                    function ($visit) use ($employeeId) {
                        if ($visit->workOrder->performer_id == $employeeId)
                            return true;

                        if(!is_null($visit->substitution_id)) {
                           $subsId = Substitution::where('substitution_id', $visit->substitution_id)->first()->employee_substitution;
                           return $subsId == $employeeId;
                        }
                    });
                break;
            default:
                // Something went wrong -> user not authorized for this page.
                // Redirect to previous site.
                return redirect()->back();
                break;
        }

        foreach ($visits as $visit) {
            $workOrder = WorkOrder::where('work_order_id', $visit->work_order_id)->first();
            // Get work order type.
            $type = $workOrder->visitSubtype->visit_subtype_title;
            $workOrder->type = $type;
            $visit->workorder = $workOrder;

            // Prescriber
            $visit->prescriber = $visit->workOrder->prescriber->person->name . ' ' . $visit->workOrder->prescriber->person->surname;

            // Performer
            $visit->performer = $visit->workOrder->performer->person->name . ' ' . $visit->workOrder->performer->person->surname;

            // Patient
            $patient = WorkOrder_Patient::where('work_order_id', $workOrder->work_order_id)->first()->patient;
            $visit->patient = $patient->person->name . ' ' . $patient->person->surname;

            // Substitution
            if ($visit->substitution_id != null) {
                $subsId = Substitution::where('substitution_id', $visit->substitution_id)->first()->employee_substitution;
                $employee = Employee::find($subsId);
                $name = $employee->person->name . ' ' . $employee->person->surname;
                $visit->substitution = $name;
            }
        }

        return view('visitList')->with([
            'visits'        => $visits,
            'name'			=> auth()->user()->person->name . ' '
                . auth()->user()->person->surname,
            'role'			=> auth()->user()->userRole->user_role_title,
            'lastLogin'		=> $this->lastLogin(auth()->user())
        ]);


	}


	/**
	 * Display details about requested visit.
	 *
	 * @param Visit $visit
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show (Visit $visit) {
		// Retrieve visit's work order.
		$workOrder = WorkOrder::where('work_order_id', $visit->work_order_id)->first();
		// Get work order type.
		$type = $workOrder->visitSubtype->visit_subtype_title;
		$workOrder->type = $type;
		// Format performer.
		$workOrder->performer = $workOrder->performer->employee_id . ' '
								. $workOrder->performer->person->name . ' '
								. $workOrder->performer->person->surname;
		// Retrieve all visits under this work order.
		$visits = $workOrder->visit;

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

			// Retrieve measurements for this patient.
			$measurementRel = $visit->measurementRel
				->where('visit_id', '=', $visit->visit_id)
				->where('patient_id', '=', $pat->patient_id);
			$pat->measurements = [];
			foreach ($measurementRel as $measurement) {
				$measurement->measurement->value = is_null($measurement->date)
					? 'Meritev še ni bila opravljena.'
					: $measurement->value;
				$measurement->measurement->date = is_null($measurement->date)
					? null
					: Carbon::createFromFormat('Y-m-d',
											   $measurement->date)
							->format('d.m.Y');
				$pat->measurements = array_merge($pat->measurements, [
					$measurement->measurement,
				]);
			}

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

		// Check work order type and retrieve material data.
		switch ($type) {
			case 'Aplikacija injekcij':
				$medicines = [];
				foreach ($workOrder->medicineRel as $relation) {
					$medicines[] = $relation->medicine;
				}
				break;
			case 'Odvzem krvi':
				// Get number of blood tubes and store them by color.
				$bloodTubesRel = $workOrder->bloodTubeRel;

				foreach ($bloodTubesRel as $bt) {
					$color = $bt->bloodTube->color;

					switch ($color) {
						case 'Rdeča':
							$bloodTubes['red'] = $bt->num_of_tubes;
							break;
						case 'Modra':
							$bloodTubes['blue'] = $bt->num_of_tubes;
							break;
						case 'Zelena':
							$bloodTubes['green'] = $bt->num_of_tubes;
							break;
						case 'Rumena':
							$bloodTubes['yellow'] = $bt->num_of_tubes;
							break;
					}
				}
				break;
		}

		// Format substitution if it exists.
		if (!is_null($visit->substitution))
			$visit->substitution = $visit->substitution->employeeSubstitution->employee_id . ' '
								   . $visit->substitution->employeeSubstitution->person->name . ' '
								   . $visit->substitution->employeeSubstitution->person->surname;

		return view('visit', compact(
			'visit',
			'workOrder',
			'patient',
			'children',
			'medicines',
			'bloodTubes',
			'visits'
		))
		->with([
			'name'		=> auth()->user()->person->name . ' '
							. auth()->user()->person->surname,
			'role'		=> auth()->user()->userRole->user_role_title,
			'lastLogin'	=> $this->lastLogin(auth()->user())
		]);
	}

	/**
	 * Display page to edit visit.
	 *
	 * @param Visit $visit
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit (Visit $visit) {
		// Get work order with performer.
		$workOrder = WorkOrder::getWorkOrderWithPerformer($visit->work_order_id);
		// Get work order type.
		$type = $workOrder->visitSubtype->visit_subtype_title;

		// Get patients for this work order.
		$patients = WorkOrder_Patient::getPatientsForWorkOrder($workOrder);

		// Get modified data about patients.
		$patients = $this->modifyPatientsData($patients, $visit, $type);
		// Store data about patient and possible newborns.
		$patient = $patients[0];
		$children = $patients[1];

		// Get material based on work order type.
		switch ($type) {
			case 'Aplikacija injekcij':
				break;
			case 'Odvzem krvi':
				break;
		}

		// Retrieve necessary data and display visit details view.
		return view('visitEdit', $this->getVisitData($visit))
		->with([
			'visit'		=> $visit,
			'name'		=> auth()->user()->person->name . ' '
							. auth()->user()->person->surname,
			'role'		=> auth()->user()->userRole->user_role_title,
			'lastLogin'	=> $this->lastLogin(auth()->user())
		]);
	}

	/**
	 * Update visit with provided data.
	 *
	 * @param Visit $visit
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function update (Visit $visit) {
		return view('visit')
		->with([
			'status'	=> 'Obisk uspešno posodobljen.',
			'name'		=> auth()->user()->person->name . ' '
							. auth()->user()->person->surname,
			'role'		=> auth()->user()->userRole->user_role_title,
			'lastLogin'	=> $this->lastLogin(auth()->user())
		]);
	}

	/**
	 * Retrieve data for patients with measurements included.
	 *
	 * @param       $patients
	 * @param Visit $visit
	 * @param       $type
	 *
	 * @return array
	 */
	private function modifyPatientsData ($patients, Visit $visit, $type) {
		$mainPatient = [];
		$children = [];

		foreach ($patients as $patient) {
			// Store data about patient.
			$patient->person->region = $patient->person->region->region_title;

			$patient->birth_date = Carbon::createFromFormat('Y-m-d',
														$patient->birth_date)
									 ->format('d.m.Y');

			// Retrieve measurements for this patient.
			$measurementRel = $visit->measurementRel
				->where('visit_id', '=', $visit->visit_id)
				->where('patient_id', '=', $patient->patient_id);

			$patient->measurements = [];
			foreach ($measurementRel as $measurement) {
				$measurement->measurement->value = is_null($measurement->date)
					? 'Meritev še ni bila opravljena.'
					: $measurement->value;
				$measurement->measurement->date = is_null($measurement->date)
					? null
					: Carbon::createFromFormat('Y-m-d',
											   $measurement->date)
							->format('d.m.Y');
				$patient->measurements = array_merge($patient->measurements, [
					$measurement->measurement,
				]);
			}

			// Check if work order type is of type mother and newborn.
			if ($type == 'Obisk novorojenčka in otročnice') {
				// Check whether this patient is mother or child
				if (!$patient->dependent->isEmpty()) {
					$relationship = $patient->dependent[0]->relationship->relationship_type;
					if ($relationship == 'Hči' || $relationship == 'Sin')
						$children[] = $patient;
				}
				else {
					$mainPatient = $patient;
				}
			} else
				$mainPatient = $patient;
		}

		return [$mainPatient, $children];
	}

	/**
	 * Get data necessary for displaying visit details.
	 *
	 * @param Visit $visit
	 *
	 * @return array
	 */
	private function getVisitData (Visit $visit) {
		// Retrieve visit's work order.
		$workOrder = WorkOrder::where('work_order_id', $visit->work_order_id)->first();
		// Get work order type.
		$type = $workOrder->visitSubtype->visit_subtype_title;
		$workOrder->type = $type;
		// Format performer.
		$workOrder->performer = $workOrder->performer->employee_id . ' '
								. $workOrder->performer->person->name . ' '
								. $workOrder->performer->person->surname;
		// Retrieve all visits under this work order.
		$visits = $workOrder->visit;

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

			// Retrieve measurements for this patient.
			$measurementRel = $visit->measurementRel
				->where('visit_id', '=', $visit->visit_id)
				->where('patient_id', '=', $pat->patient_id);
			$pat->measurements = [];
			foreach ($measurementRel as $measurement) {
				$measurement->measurement->value = is_null($measurement->date)
					? 'Meritev še ni bila opravljena.'
					: $measurement->value;
				$measurement->measurement->date = is_null($measurement->date)
					? null
					: Carbon::createFromFormat('Y-m-d',
											   $measurement->date)
							->format('d.m.Y');
				$pat->measurements = array_merge($pat->measurements, [
					$measurement->measurement,
				]);
			}

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

		// Check work order type and retrieve material data.
		switch ($type) {
			case 'Aplikacija injekcij':
				$medicines = [];
				foreach ($workOrder->medicineRel as $relation) {
					$medicines[] = $relation->medicine;
				}
				break;
			case 'Odvzem krvi':
				// Get number of blood tubes and store them by color.
				$bloodTubesRel = $workOrder->bloodTubeRel;

				foreach ($bloodTubesRel as $bt) {
					$color = $bt->bloodTube->color;

					switch ($color) {
						case 'Rdeča':
							$bloodTubes['red'] = $bt->num_of_tubes;
							break;
						case 'Modra':
							$bloodTubes['blue'] = $bt->num_of_tubes;
							break;
						case 'Zelena':
							$bloodTubes['green'] = $bt->num_of_tubes;
							break;
						case 'Rumena':
							$bloodTubes['yellow'] = $bt->num_of_tubes;
							break;
					}
				}
				break;
		}

		// Format substitution if it exists.
		if (!is_null($visit->substitution))
			$visit->substitution = $visit->substitution->employeeSubstitution->employee_id . ' '
								   . $visit->substitution->employeeSubstitution->person->name . ' '
								   . $visit->substitution->employeeSubstitution->person->surname;

		return compact(
			'visit',
			'workOrder',
			'patient',
			'children',
			'medicines',
			'bloodTubes',
			'visits'
		);
	}
}
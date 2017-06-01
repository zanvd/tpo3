<?php

namespace App\Controllers\Employee;

use App\Models\BloodTube;
use App\Models\Employee;
use App\Models\Medicine;
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
		// Retrieve necessary data and display visit details view.
		return view('visit', $this->getVisitDetailsData($visit))
		->with([
			'visit'		=> $visit,
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
		// Retrieve necessary data and display visit details view.
		return view('visitEdit', $this->getVisitDetailsData($visit))
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
	 * Get details about given Visit.
	 *
	 * @param Visit $visit
	 *
	 * @return array
	 */
	private function getVisitDetailsData (Visit $visit) {
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
				$medicines = Medicine::getMedicinesForWorkOrder($workOrder->medicineRel);
				break;
			case 'Odvzem krvi':
				$bloodTubes = BloodTube::getBloodTubesByColor($workOrder->bloodTubeRel);
				break;
		}

		// Format substitution if it exists.
		if (!is_null($visit->substitution))
			$visit->substitution = $visit->substitution
									   ->employeeSubstitution->employee_id . ' '
								   . $visit->substitution
									   ->employeeSubstitution->person->name . ' '
								   . $visit->substitution
									   ->employeeSubstitution->person->surname;

		// Retrieve all visits under this work order.
		$visits = $workOrder->visit;

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
			$inputRel = $visit->inputRel
				->where('patient_id', '=', $patient->patient_id);

			$patient->measurements = [];
			foreach ($inputRel as $input) {
				$input->input->value = is_null($input->input_value)
					? 'Meritev še ni bila opravljena.'
					: $input->input_value;
				$input->input->date = is_null($input->input_date)
					? null
					: Carbon::createFromFormat('Y-m-d',
											   $input->input_date)
							->format('d.m.Y');
				$patient->measurements = array_merge($patient->measurements, [
					$input->input,
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
}
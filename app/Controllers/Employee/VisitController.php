<?php

namespace App\Controllers\Employee;

use App\Models\BloodTube;
use App\Models\Employee;
use App\Models\Input;
use App\Models\Medicine;
use App\Models\Substitution;
use App\Models\Visit;
use App\Models\WorkOrder;
use App\Controllers\Controller;
use App\Models\WorkOrder_Patient;
use Carbon\Carbon;

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
		return view('visit', $this->getVisitDetailsData($visit, false))
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
		// dd($this->getVisitDetailsData($visit, true)['children']);
		// Retrieve necessary data and display visit details view.
		return view('visitEdit', $this->getVisitDetailsData($visit, true))
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
	 * @param bool	$edit
	 *
	 * @return array
	 */
	private function getVisitDetailsData (Visit $visit, $edit) {
		// Get work order with performer.
		$workOrder = WorkOrder::getWorkOrderWithPerformer($visit->work_order_id);
		// Get work order type.
		$type = $workOrder->visitSubtype->visit_subtype_title;
		$workOrder->type = $type;

		// Get patients for this work order.
		$patients = WorkOrder_Patient::getPatientsForWorkOrder($workOrder);

		// Get modified data about patients.
		$patients = $this->modifyPatientsData($patients, $visit, $type, $edit);
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
	 * @param mixed		$patients
	 * @param Visit 	$visit
	 * @param string	$type
	 * @param bool		$edit
	 *
	 * @return array
	 */
	private function modifyPatientsData ($patients, Visit $visit, $type, $edit) {
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

			$measurements = [];
			foreach ($inputRel as $relation) {
				$mid = $relation->input->measurement_id;
				if (!array_key_exists($mid, $measurements)) {
					$measurements[$mid] = [];
					$measurements[$mid]['description'] = $relation->input->measurement->description;
				}

				// Check for select and radio button inputs.
				if ($relation->input->type == 'radio'
						|| $relation->input->type == 'select') {
					// If input is not selected or empty and we are not editing,
					// don't store it.
					if (!$edit && ($relation->input_value == 'no'
							|| is_null($relation->input_value))) continue;

					$relation->input->value = is_null($relation->input_value)
						? 'no'
						: $relation->name;
				} elseif ($relation->input->type == 'date') {
					$relation->input->value = is_null($relation->input_value)
						? 'Meritev še ni bila opravljena.'
						: \Carbon\Carbon::createFromFormat(
								'Y-m-d',
								$relation->input_value
							)->format('d.m.Y');
				} elseif ($relation->input->type == 'number') {
					// Get min and max values.
					$relation->input = $this->inputSwitch($relation->input);

					$relation->input->value = is_null($relation->input_value)
						? 'Meritev še ni bila opravljena.'
						: $relation->input_value;
				} else {
					$relation->input->value = is_null($relation->input_value)
						? 'Meritev še ni bila opravljena.'
						: $relation->input_value;
				}

				$relation->input->date = is_null($relation->input_date)
					? null
					: Carbon::createFromFormat('Y-m-d',
											   $relation->input_date)
							->format('d.m.Y');

				$measurements[$mid][] = $relation->input;
			}
			$patient->measurements = $measurements;

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
	 * @param Input $input
	 *
	 * @return Input
	 */
	private function inputSwitch (Input $input) {
		switch ($input->input_name) {
			case 'Sistolični (mmHg)':
				$input->min = 40;
				$input->max = 250;
				break;
			case 'Diastolični (mmHg)':
				$input->min = 20;
				$input->max = 130;
				break;
			case 'Udarcev na minuto':
				$input->min = 30;
				$input->max = 220;
				break;
			case 'Vdihov na minuto':
				$input->min = 5;
				$input->max = 100;
				break;
			case 'Telesna temperatura (°C)':
				$input->min = 33;
				$input->max = 43;
				break;
			case 'Telesna teža (kg)':
			case 'Trenutna telesna teža (kg)':
			case 'Telesna teža pred nosečnostjo (kg)':
				$input->min = 4;
				$input->max = 400;
				break;
			case 'Porodna teža otroka (g)':
			case 'Trenutna telesna teža (g)':
				$input->min = 1200;
				$input->max = 6000;
				break;
			case 'Porodna višina otroka (cm)':
			case 'Trenutna telesna višina (cm)':
				$input->min = 20;
				$input->max = 70;
				break;
			case 'Krvni sladkor (mmol/L)':
				$input->min = 3.0;
				$input->max = 50;
				break;
			case 'Oksigenacija SpO2 (%)':
				$input->min = 3.0;
				$input->max = 50;
				break;
		}
		return $input;
	}
}
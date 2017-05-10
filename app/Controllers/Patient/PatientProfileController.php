<?php

namespace App\Controllers\Patient;

use App\Controllers\Controller;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PatientProfileController extends Controller {
	/**
	 * Create a new patient profile controller instance.
	 *
	 */
	public function __construct() {
		// Only patients can access this page.
		$this->middleware('patient');
	}

	/**
	 * Display patient's profile page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
		return view('patientProfile')->with([
			'name'			=> auth()->user()->person->name . ' ' .
								 auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user()),
			'patients'		=> $this->getDependentPatients()
		]);
	}

	/**
	 * Retrieve all dependent patient for currently logged in patient.
	 *
	 * @return mixed
	 */
	protected function getDependentPatients () {
		// Set double inner join on DependentPatient table.
		// First is on Patient table connecting with guardian patient.
		// Second join is on Patient table connecting with all dependent patients.
		// Select statement retrieves dependent patients insurance number, birth
		// date, sex and person_id.
		$dependents = DB::table('DependentPatient')
			->join(
				'Patient AS Gua', function ($join) {
					$guardian_id = auth()->user()->person->patient->patient_id;
					$join->on(
							'DependentPatient.guardian_patient_id',
							'=',
							'Gua.patient_id'
						)
						->where('Gua.patient_id', $guardian_id);
				}
			)
			->join(
				'Patient AS Dep',
				'DependentPatient.dependent_patient_id',
				'=',
				'Dep.patient_id'
			)
			->select('Dep.insurance_num', 'Dep.birth_date', 'Dep.sex', 'Dep.person_id')
			->get();

		// Iterate over patients and retrieve their data from Person table.
		foreach ($dependents as $index => $dependent) {
			$person = Person::find($dependent->person_id);
			$dependent->name = $person->name;
			$dependent->surname = $person->surname;

			// Rename keys to meet frontend requirements.
			$dependent->insurance = $dependent->insurance_num;
			$dependent->birthDate = Carbon::createFromFormat('Y-m-d',
												   $dependent->birth_date)
											->format('d.m.Y');

			// Remove unused values.
			unset($dependent->insurance_num, $dependent->birth_date,
				$dependent->person_id);

			// Store new array.
			$dependents[$index] = $dependent;
		}

		return $dependents;
	}
}

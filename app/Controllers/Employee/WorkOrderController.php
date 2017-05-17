<?php

namespace App\Controllers\Employee;

use App\Models\DependentPatient;
use App\Models\FreeDays;
use App\Models\User;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Medicine;
use App\Controllers\Controller;
use App\Models\Person;
use App\Models\Visit;
use App\Models\VisitSubtype;
use App\Models\WorkOrder;
use App\Models\WorkOrder_BloodTube;
use App\Models\WorkOrder_Measurement;
use App\Models\WorkOrder_Patient;
use App\Models\WorkOrder_Medicine;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller {

	public function __construct () {
		// Only doctor and main nurse can access work order creation page.
		//$this->middleware('role:Zdravnik|Patronažna sestra');
	}

	/**
	 * Display page with listed work orders.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
	    $workOrders = WorkOrder::all();
	    foreach($workOrders as $workOrder) {
            $patients = DB::table('WorkOrder_Patient')
                ->join('WorkOrder AS Wo',
                    'WorkOrder_Patient.work_order_id',
                    '=',
                    'Wo.work_order_id')
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

            // Set visit_subtype object
            $workOrder->visitTitle = $workOrder->visitSubtype;
            unset($workOrder->visit_subtype_id);

            // Set perscriber and performer person objects
            $workOrder->performer = $workOrder->performer->person;
            $workOrder->prescriber = $workOrder->prescriber->person;
            unset($workOrder->perscriber_id, $workOrder->performer_id);

            // Set performer substitution person object, if exists
//            if ($workOrder->substitution != 0) {
//                $workOrder->substitution = $workOrder->substitution->person;
//            } else {
//                unset($workOrder->substitution);
//            }

            // Iterate over patients and set their birthday to required format.
            foreach ($patients as $pat) {
                $pat->birthDate = Carbon::createFromFormat('Y-m-d',
                    $pat->birth_date)
                    ->format('d.m.Y');
                $pat->person = $pat->person;
                unset($pat->birth_date);
            }
            $workOrder->patients = $patients;
        }
//        dd($workOrders);
		return view('workOrderList', compact(
                'workOrders'
        ));
	}

	/**
	 * Display work order creation page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create () {
		return view('newWorkorder')->with([
			'visitTypes'	=> VisitSubtype::all()->mapWithKeys(function ($visitSubtype) {
				return [$visitSubtype['visit_subtype_id']
						=> $visitSubtype['visit_subtype_title']];
			}),
			'patients'		=> Patient::all()->mapWithKeys(function ($patient) {
				$person = $patient->person;
				return [$patient['patient_id']
						=> $patient['insurance_num'] . ' ' . $person['name']
												  . ' ' .$person['surname']];
			}),
			'medicine'		=> Medicine::all()->mapWithKeys(function ($medicine) {
				return [$medicine['medicine_id']
						=> $medicine['medicine_name'] . ' '
						   . $medicine['medicine_packaging'] . ' '
						   . $medicine['medicine_type']];
			}),
			// Get sons and daughters.
			// Encapsulate array with child's ID and set mothers ID as key.
			'children'		=> DependentPatient::wherein('relationship_id', [12, 13])
				->get()
				->mapWithKeys(function ($child) {
					$patient = $child->patient;
					$person = $patient->person;
					return [
						$child['dependent_patient_id'] => [
							$child['guardian_patient_id']
							=> $patient['insurance_num'] . ' '
							   . $person['name'] . ' ' .$person['surname']
						]
					];
			}),
			'name'			=> auth()->user()->person->name . ' '
								 . auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user())
		]);
	}

	/**
	 * Store new work order in database.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store () {
		$this->validate(request(), [
			'visitTypeId'           => 'required',
			'visits'                => 'required|numeric|min:1|max:10',
			'firstVisit'            => 'required|date|after:yesterday',
			'mandatory'             => 'required|min:0|max:1',
			'finalDate'             => 'nullable|date|after:yesterday,firstVisit',
			'interval'              => 'nullable|numeric',
			'patientId'             => 'required',
			'newborn[]'             => 'array|in_array:integer',
			'red'                   => 'nullable|numeric',
			'blue'                  => 'nullable|numeric',
			'yellow'                => 'nullable|numeric',
			'green'                 => 'nullable|numeric',
			'medicine[]'            => 'array|in_array:integer'
		],[
			'required'		    => 'Polje je zahtevano.',
			'numeric'		    => 'Zahtevano je število.',
			'min'		        => 'Vrednost mora biti večja od 1.',
			'max'		        => 'Vrednost mora biti manjša od 10.',
			'required_without'  => 'Izberi končni datum ali interval',
			'after'             => 'Datum mora biti večji ali enak današnjemu',
			'date'              => 'Polje mora vsebovati datum',
			'array'             => 'Napaka pri izbiri zdravil'
		]);

		$workOrder = new WorkOrder();

		// TODO: only woman can have visit type 1 or 2
		$visitSubtype = request('visitTypeId');
		$isFixed = request('mandatory');
		$workOrder->created_at = Carbon::now()->toDateTimeString();

		$numOfVisits = request('visits');
		$start_date = request('firstVisit');
		$fDate = \DateTime::createFromFormat(
			'd.m.Y',
			$start_date)->format('Y-m-d');
		$start_date = new Carbon($fDate);

		/** If start date is not a business day, set start date to first business day */
		while (!$this->isBusinessDay($start_date)) {
			$start_date->addDay();
		}
		$workOrder->start_date = $start_date;


		$date = request('firstVisit');
		$ftDate = \DateTime::createFromFormat(
			'd.m.Y',
			$date)->format('Y-m-d');
		$date = new Carbon($date);
		while (!$this->isBusinessDay($date)) {
			$date->addDay();
		}

		/** If there is more then one visit in WO, calculate other visit's dates */
		$num = $numOfVisits;
		if ($numOfVisits > 1) {
			$interval = request('interval');

			/** If interval is given, calculater date, that is business day, first after interval */
			if ($interval != null) { /** obisk na vsakih x dni */
				while ($num > 1) {
					$date->addDays($interval);
					while (!$this->isBusinessDay($date)) {
						$date->addDay();
					}
					$num--;
				}
				$workOrder->end_date = $date;
			}

			/** If the interval is not given, calculate interval from number of business days between start and end date */
			else { /** zadnji datum in stevilo obiskov -> pogostost obiskov */
				$workDays = 0;
				$end_date = request('finalDate');
				$feDate = \DateTime::createFromFormat(
					'd.m.Y',
					$end_date)->format('Y-m-d');
				$endDate = new Carbon($feDate);
				while (!$date->isSameDay($endDate)) {
					if ($this->isBusinessDay($date)) {
						$workDays++;
					}
					$date->addDay();
				}
				$workOrder->end_date = $date;
				(int)$interval = ($workDays / ($numOfVisits - 1));
			}
		} else {
			$workOrder->end_date = $start_date;
			$interval = 0;
		}

		/** Narocnik */
		$user = Auth::user();
		$prescriber = Employee::where('person_id', $user->person_id)->first();
		$workOrder->prescriber_id = $prescriber->employee_id;

		/** Avtomatsko dodeljevanje MS */
		$patient_id = request('patientId');
		$personNurseId = User::where('user_role_id', 23)->get()->filter(function ($person, $region) {
			return $person->region_id == $region;
		})[0]->person_id;
		$workOrder->performer_id = Employee::where('person_id', $personNurseId)->first()->employee_id;
		$workOrder->substitution = false;
		$workOrder->visit_subtype_id = $visitSubtype;
		$workOrder->save();

		/** Pacient */
		$workOrderPatient = new WorkOrder_Patient();
		$workOrderPatient->patient_id = $patient_id;
		$workOrderPatient->work_order_id = $workOrder->work_order_id;
		$workOrderPatient->save();

		switch ($visitSubtype) {
			case '1':   /** Obisk nosecnice */
				$this->defaultMeasurements($workOrder->work_order_id, $patient_id);
				$this->setMeasurements(16, $workOrder->work_order_id, $patient_id);  /** Teza pred nosecnostjo */
				break;
			case '2':   /** Obisk otrocnice in novorojencka */
				$this->defaultMeasurements($workOrder->work_order_id, $patient_id);
				$newborn = request('newborn');
				for ($i = 0; $i < count($newborn); $i++) {
					$workOrderPatient = new WorkOrder_Patient();
					$workOrderPatient->patient_id = $newborn[$i];
					$workOrderPatient->work_order_id = $workOrder->work_order_id;
					$workOrderPatient->save();
                    $this->setMeasurements(15, $workOrder->work_order_id, $newborn[$i]);  /** Telesna teza novorojencka*/
                    $this->setMeasurements(18, $workOrder->work_order_id, $newborn[$i]);  /** Telesna visina novorojencka */
                    $this->setMeasurements(22, $workOrder->work_order_id, $newborn[$i]);  /** Meritev bilirubina */
				}
				break;
			case '3':   /** Preventiva starostnika */
				$this->defaultMeasurements($workOrder->work_order_id, $patient_id);
				break;
			case '4':   /** Aplikacija injekcij */
				$medicine = request('medicine');
				for ($i = 0; $i < count($medicine); $i++) {
					$this->setMedicine($medicine[$i], $workOrder->work_order_id);
				}
				break;
			case '5':   /** Odvzem krvi */
				if (request('red') != null) {
					$this->setNumOfBloodTubes(996, request('red'), $workOrder->work_order_id);
				}
				if (request('blue') != null) {
					$this->setNumOfBloodTubes(997, request('blue'), $workOrder->work_order_id);
				}
				if (request('yellow') != null) {
					$this->setNumOfBloodTubes(998, request('yellow'), $workOrder->work_order_id);
				}
				if (request('green') != null) {
					$this->setNumOfBloodTubes(999, request('green'), $workOrder->work_order_id);
				};
				break;
			case '6':   /** Kontrola zdravstvenega stanja */
				$this->defaultMeasurements($workOrder->work_order_id, $patient_id);
				$this->setMeasurements(20, $workOrder->work_order_id, $patient_id);  /** Krvni sladkor */
				$this->setMeasurements(21, $workOrder->work_order_id, $patient_id);  /** Oksigenacija SpO2 */
				break;
		}

        /** Create first visit **/
		$vDate = $start_date;
		$this->createVisit($start_date, true, $isFixed == 1, $workOrder->work_order_id);
		/** Create other visits, if there are more **/
		for ($i = 1; $i < $numOfVisits; $i++) {
			$vDate->addDays($interval);
			while (!$this->isBusinessDay($vDate)) {
				$vDate->addDay();
			}
			$this->createVisit($vDate, false, false, $workOrder->work_order_id);
		}
		return redirect('/delovni-nalog/ustvari')->with([
			'status' => 'Delovni nalog uspešno kreiran'
		]);
	}

	/**
	 * Display details about requested work order.
	 *
	 * @param WorkOrder $workOrder
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show (WorkOrder $workOrder) {
		/**
		 * Zdravnik/vodja PS/patronažna sestra lahko izpiše delovni nalog.
		 *
		 * Za vsak DN je treba izpisati:
		 * njegove podrobnosti in
		 * podatke o vseh predvidenih obiskih:
			 * predvideni datum obiska
			 * dejanski datum obiska (če je bil obisk že opravljen)
			 * zadolžena medicinska sestra oziroma nadomestna medicinska sestra.
		 *
		 * Za že opravljene obiske naj bo možen tudi izpis podrobnosti obiska (povezava na zgodbo #11).
		 *
		 * Preveri izpis za vse vrste obiskov (pri aplikaciji injekcij je treba izpisati tudi podatke o zdravilih, pri odvzemu krvi pa podatke o epruvetah).
		 * Preveri, da se izpišejo tako podatki, ki se zajamejo, kot podatki, ki se avtomatsko določijo ob kreiranju DN.
		 */

		// Retrieve all patients.
		// Set double inner join on WorkOrder_Patient table.
		// First is on WorkOrder table connecting with given work order.
		// Second is on Patient table connecting with all patients under this
		// work order.
		// Select statement retrieves all patients data.
		$patients = DB::table('WorkOrder_Patient')
			->join('WorkOrder AS Wo',
				'WorkOrder_Patient.work_order_id',
				'=',
				'Wo.work_order_id')
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

		// Iterate over patients and set their birthday to required format.
		foreach ($patients as $pat) {
			$pat->birthDate = Carbon::createFromFormat('Y-m-d',
													$pat->birth_date)
													->format('d.m.Y');

			// Check if work order type is of type mother and newborn.
			if ($workOrder->visitSubtype->visit_subtype_title
					== 'Obisk novorojenčka in otročnice') {
				// Check whether this patient is mother or child.
				if (!$pat->dependent->isEmpty()) {
					$children[] = $pat;
				}
				else {
					$patient = $pat;
				}
			} else
				$patient = $pat;
		}

		/// Check if there was a substitution and
		// today is inside substitution period.
		if (!is_null($workOrder->substitution)
			&& Carbon::now() >= $workOrder->substitution->start_date
			&& Carbon::now() <= $workOrder->substitution->end_date) {
			$substitution = $workOrder->substitution;
		}

		// Retrieve all visits.
		$visits = $workOrder->visit;

		return view('workOrder', compact(
			'workOrder',
			'patient',
			'children',
			'substitution',
			'visits'
		));
	}

	protected function defaultMeasurements($workOrderId, $patient_id) {
		$this->setMeasurements(10, $workOrderId, $patient_id);  //Sistolicni
		$this->setMeasurements(11, $workOrderId, $patient_id);  //Diastolicni
		$this->setMeasurements(12, $workOrderId, $patient_id);  //Dihanje
		$this->setMeasurements(13, $workOrderId, $patient_id);  //Srcni utrip
		$this->setMeasurements(14, $workOrderId, $patient_id);  //Telesna teza
		$this->setMeasurements(19, $workOrderId, $patient_id);  //Telesna temperatura
	}

	protected function setMedicine($medicineId, $workOrderId) {
		$medicine = new WorkOrder_Medicine();
		$medicine->medicine_id = $medicineId;
		$medicine->work_order_id = $workOrderId;
		$medicine->save();
	}

	protected function setNumOfBloodTubes($bloodTubeId, $numOfTubes, $workOrderId) {
		$tube = new WorkOrder_BloodTube();
		$tube->blood_tube_id = $bloodTubeId;
		$tube->num_of_tubes = $numOfTubes;
		$tube->work_order_id = $workOrderId;
		$tube->save();
	}

	protected function setMeasurements($measurementId, $workOrderId, $patient_id) {
		$measurement = new WorkOrder_Measurement();
		$measurement->measurement_id = $measurementId;
		$measurement->work_order_id = $workOrderId;
		$measurement->patient_id = $patient_id;
		$measurement->save();
	}

	protected function createVisit($vDate, $isFirst, $isFixed, $workOrderId) {
		$visit = new Visit();
		$visit->visit_date = $vDate;
		$visit->first_visit = $isFirst;
		$visit->fixed_visit = $isFixed;
		$visit->work_order_id = $workOrderId;
		$visit->save();
	}

	protected function isBusinessDay($date) {
		if (FreeDays::where($date) == null) {
			return false;
		}
		if ($date->isWeekend()) {
			return false;
		}
		return true;
	}
}

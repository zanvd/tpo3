<?php

namespace App\Controllers\Employee;

use App\Models\DependentPatient;
use App\Models\FreeDays;
use App\Models\Input;
use App\Models\User;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Medicine;
use App\Controllers\Controller;
use App\Models\Visit;
use App\Models\Visit_Input;
use App\Models\VisitSubtype;
use App\Models\WorkOrder;
use App\Models\WorkOrder_BloodTube;
use App\Models\WorkOrder_Material;
use App\Models\WorkOrder_Patient;
use App\Models\WorkOrder_Medicine;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller {

	public function __construct () {
		// Only doctor and main nurse can access all work order pages.
		$this->middleware('role:Zdravnik|Vodja PS')
			->except(['index', 'show']);
		// Nurse can access work order list and details page.
		$this->middleware('role:Zdravnik|Vodja PS|Patronažna sestra')
			 ->only(['index', 'show']);
	}

	/**
	 * Display page with listed work orders.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index () {
		/**
		 * Zdravnik/vodja PS/patronažna sestra lahko izpiše seznam delovnih nalogov po različnih kriterijih.
		 *
		 * Seznam naj bo možno filtrirati glede na časovno obdobje izdaje, vrsto obiska, izdajatelja (kateri zdravnik ali
		 * vodja PS), pacienta, zadolženo patronažno sestro in nadomestno patronažno sestro.
		 *
		 * Za vsak DN iz seznama naj bo potem možno izpisati njegove podrobnosti.
		 *
		 * Pri uporabniški vlogi zdravnik naj bo kot kriterij za izbor zdravnika že vnaprej nastavljena šifra trenutno
		 * prijavljenega zdravnika, pri uporabniški vlogi patronažna sestra pa naj bo kot kriterij za zadolženo in
		 * nadomestno patronažno sestro nastavljena šifra trenutno prijavljene patronažne sestre.
		 *
		 * Za izbran DN naj bo moč izpisati njegove podrobnosti (povezava na zgodbo Izpis delovnega naloga).
		 */
		$user = auth()->user();
		$userRole = $user->userRole->user_role_title;
		$employeeId = $user->person->employee->employee_id;

		switch($userRole) {
			case "Zdravnik":
				$workOrders = WorkOrder::where('prescriber_id', $employeeId)->get();
				break;
			case "Vodja PS":
			case "Patronažna sestra":
				$workOrders = WorkOrder::all();
				break;
			default:
				// Something went wrong -> user not authorized for this page.
				// Redirect to previous site.
				return redirect()->back();
				break;
		}

		foreach($workOrders as $workOrder) {
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

			// Set visit_subtype object
			$workOrder->visitTitle = $workOrder->visitSubtype;
			unset($workOrder->visit_subtype_id);

			// Set perscriber and performer person objects
			$workOrder->performer = $workOrder->performer->person;
			$workOrder->prescriber = $workOrder->prescriber->person;
			unset($workOrder->perscriber_id, $workOrder->performer_id);

			// Iterate over patients and set their birthday to required format.
			foreach ($patients as $pat) {
				$pat->birthDate = Carbon::createFromFormat('Y-m-d',
					$pat->birth_date)
					->format('d.m.Y');
				$pat->person = $pat->person;
				unset($pat->birth_date);
			}
			$workOrder->patients = $patients;

			// Check for substitutions and insert them.
			// Get visits.
			$visits = $workOrder->visit->filter(function ($visit) {
				return $visit->substitution_id != null;
			})->all();

			foreach ($visits as $visit) {
				// Create substitution array if it doesn't exist yet.
				if (!isset($workOrder->substitutions))
					$workOrder->substitutions = [];

				$substitution =
					$visit->substitution->employeeSubstitution->person->name
					. ' '
					. $visit->substitution->employeeSubstitution->person->surname;

				// Check if this substitution is already included.
				if (!in_array($substitution, $workOrder->substitutions))
					$workOrder->substitutions = array_merge(
						$workOrder->substitutions,
						[$substitution]
					);
			}

		}

		// If nurse is accessing the page,
		// filter work orders based on substitutions and performer.
		if ($userRole == 'Patronažna sestra') {
			$name = $user->person->name . ' ' . $user->person->surname;
			$workOrders = $workOrders->filter(
				function ($workOrder) use ($name, $employeeId) {
					if ($workOrder->performer->employee->employee_id == $employeeId)
						return true;

					if(!is_null($workOrder->substitutions))
						return in_array($name, $workOrder->substitutions);
			});
		}

		return view('workOrderList')->with([
			'workOrders'	=> $workOrders,
			'name'			=> auth()->user()->person->name . ' '
								 . auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user())
		]);
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

		// Start Transaction.
		DB::beginTransaction();

		// Try saving new WorkOrder and relating recordings to the database.
		try {
			$workOrder = new WorkOrder();

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
			$date = new Carbon($ftDate);
			while (!$this->isBusinessDay($date)) {
				$date->addDay();
			}
			/** If there is more then one visit in WO, calculate other visit's dates */
			$num = $numOfVisits;
			if ($numOfVisits > 1) {
				$interval = request('interval');

				/** If interval is given, calculater date, that is business day, first after interval */
				if ($interval != null) {
					/** obisk na vsakih x dni */
					while ($num > 1) {
						$date->addDays($interval);
						while (!$this->isBusinessDay($date)) {
							$date->addDay();
						}
						$num--;
					}
					$workOrder->end_date = $date;
				} /** If the interval is not given, calculate interval from number of business days between start and end date */
				else {
					/** zadnji datum in stevilo obiskov -> pogostost obiskov */
					$days = 0;
					$end_date = request('finalDate');
					$feDate = \DateTime::createFromFormat(
						'd.m.Y',
						$end_date)->format('Y-m-d');
					$endDate = new Carbon($feDate);
					while (!$date->isSameDay($endDate)) {
						$date->addDay();
						$days++;
					}
					$workOrder->end_date = $date;
					(int)$interval = ($days / ($numOfVisits - 1));
					if ($interval < 1) {
					    $interval = 1;
                    }
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
			$region_id = Patient::find($patient_id)->person->region_id;
			$personNurseId = User::where('user_role_id', 23)->get()->filter(function ($user) use ($region_id) {
				return $user->person->region_id == $region_id;
			})->first()->person_id;

			$workOrder->performer_id = Employee::where('person_id', $personNurseId)->first()->employee_id;
			$workOrder->visit_subtype_id = $visitSubtype;
			$workOrder->save();

			/** Pacient */
			$workOrderPatient = new WorkOrder_Patient();
			$workOrderPatient->patient_id = $patient_id;
			$workOrderPatient->work_order_id = $workOrder->work_order_id;
			$workOrderPatient->save();

			/** Set newborns as work order patients for visit type '2' */
			if ($visitSubtype == '2') {
				$newborn = request('newborn');
				for ($i = 0; $i < count($newborn); $i++) {
					// Set every newborn as work order patient
					$workOrderPatient = new WorkOrder_Patient();
					$workOrderPatient->patient_id = $newborn[$i];
					$workOrderPatient->work_order_id = $workOrder->work_order_id;
					$workOrderPatient->save();
				}
			}

			/** Set medicine for visit type '4' */
			if ($visitSubtype == '4') {
				/** Aplikacija injekcij */
				$medicine = request('medicine');
				for ($i = 0; $i < count($medicine); $i++) {
					$this->setMedicine($medicine[$i], $workOrder->work_order_id);
					$this->setMaterial($medicine[$i], 1, $workOrder->work_order_id);
				}
			}

			/** Set blood tubes for work order of visit type 5 */
			if ($visitSubtype == '5') {
				/** Odvzem krvi */
				if (request('red') != null && request('red') > 0) {
					$this->setNumOfBloodTubes(996, request('red'), $workOrder->work_order_id);
					$this->setMaterial(996, request('red'), $workOrder->work_order_id);

				} else {
                    $this->setNumOfBloodTubes(996, 0, $workOrder->work_order_id);
                }
				if (request('blue') != null && request('blue') > 0) {
					$this->setNumOfBloodTubes(997, request('blue'), $workOrder->work_order_id);
					$this->setMaterial(997, request('blue'), $workOrder->work_order_id);
				} else {
                    $this->setNumOfBloodTubes(997, 0, $workOrder->work_order_id);
                }
				if (request('yellow') != null && request('yellow') > 0) {
					$this->setNumOfBloodTubes(998, request('yellow'), $workOrder->work_order_id);
					$this->setMaterial(998, request('yellow'), $workOrder->work_order_id);
				} else {
                    $this->setNumOfBloodTubes(998, 0, $workOrder->work_order_id);
                }
				if (request('green') != null && request('green') > 0) {
					$this->setNumOfBloodTubes(999, request('green'), $workOrder->work_order_id);
					$this->setMaterial(999, request('green'), $workOrder->work_order_id);
				} else {
                    $this->setNumOfBloodTubes(999, 0, $workOrder->work_order_id);
                }
			}

			/** Create first visit **/
			$vDate = $start_date;
			$visitId = $this->createVisit($start_date, true, $isFixed, $workOrder->work_order_id);
			/** Create measurements for first visit that are same for all visits */
			switch ($visitSubtype) {
				case '1':
					/** Obisk nosecnice 1-24 */
                    // First visit only
                    /** Teza pred nosecnostjo */
                    $this->setMeasurements(24, $visitId, $patient_id);
                    // For all visits
                    for ($k = 1; $k < 24; $k++) {
                        $this->setMeasurements($k, $visitId, $patient_id);
                    }
                    break;
				case '2':
					/** Obisk otrocnice in novorojencka  25-48 */
                    for ($k = 26; $k < 49; $k++) {
                        $this->setMeasurements($k, $visitId, $patient_id);
                    }
					$newborn = request('newborn');
					for ($i = 0; $i < count($newborn); $i++) {
						// Set measurements for every newborn 49-62
                        $this->setMeasurements(25, $visitId, $newborn[$i]);
                        for ($k = 49; $k < 63; $k++) {
                            $this->setMeasurements($k, $visitId, $newborn[$i]);
                        }
					}
					break;
				case '3':
					/** Preventiva starostnika 63-79 */
                    for ($k = 63; $k < 80; $k++) {
                        $this->setMeasurements($k, $visitId, $patient_id);
                    }
					break;
				case '4':
					/** Aplikacija injekcij 80 */
                    $this->setMeasurements(80, $visitId, $patient_id);
					break;
				case '5':
					/** Odvzem krvi 81*/
                    $this->setMeasurements(81, $visitId, $patient_id);
					break;
				case '6':
					/** Kontrola zdravstvenega stanja 82-92*/
                    for ($k = 82; $k < 93; $k++) {
                        $this->setMeasurements($k, $visitId, $patient_id);
                    }
					break;
			}

			/** Create other visits, if there are more **/
			for ($i = 1; $i < $numOfVisits; $i++) {
				$vDate->addDays($interval);
				while (!$this->isBusinessDay($vDate)) {
					$vDate->addDay();
				}
				$visitId = $this->createVisit($vDate, false, $isFixed, $workOrder->work_order_id);
                switch ($visitSubtype) {
                    //setMeasurements($measurementId, $visitId, $patient_id) {
                    case '1':
                        /** Obisk nosecnice 1-24 */
                        // For all visits
                        for ($k = 1; $k < 24; $k++) {
                            $this->setMeasurements($k, $visitId, $patient_id);
                        }
                        break;
                    case '2':
                        /** Obisk otrocnice in novorojencka  25-48 */
                        for ($k = 26; $k < 49; $k++) {
                            $this->setMeasurements($k, $visitId, $patient_id);
                        }
                        $newborn = request('newborn');
                        for ($j = 0; $j < count($newborn); $j++) {
                            // Set measurements for every newborn 49-62
                            for ($k = 49; $k < 63; $k++) {
                                $this->setMeasurements($k, $visitId, $newborn[$j]);
                            }
                        }
                        break;
                    case '3':
                        /** Preventiva starostnika 63-79 */
                        for ($k = 63; $k < 80; $k++) {
                            $this->setMeasurements($k, $visitId, $patient_id);
                        }
                        break;
                    case '4':
                        /** Aplikacija injekcij 80 */
                        $this->setMeasurements(80, $visitId, $patient_id);
                        break;
                    case '5':
                        /** Odvzem krvi 81*/
                        $this->setMeasurements(81, $visitId, $patient_id);
                        break;
                    case '6':
                        /** Kontrola zdravstvenega stanja 82-92*/
                        for ($k = 82; $k < 93; $k++) {
                            $this->setMeasurements($k, $visitId, $patient_id);
                        }
                        break;
                }
			}

		} catch (\Exception $e) {
			// Log exception.
			error_log(print_r('Error when creating new WorkOrder or relating recordings: ' .
				$e, true));

			// Rollback everything.
			DB::rollback();

			// Let the user know about the failure and ask to try again.
			return redirect()->back()->withErrors([
				'message' => 'Napaka pri ustvarjanju delovnega naloga ' .
					'ali zapisa, povezanega z njim. Prosimo, poskusite znova.'
			]);
		}
		// Everything is fine. Commit changes to database.
		DB::commit();

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
		// Get work order type.
		$type = $workOrder->visitSubtype->visit_subtype_title;

		// Retrieve all patients.
		// Set double inner join on WorkOrder_Patient table.
		// First is on WorkOrder table connecting with given work order.
		// Second is on Patient table connecting with all patients under this
		// work order.
		// Select statement retrieves all patients data.
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

		// If we decide to support assigning same patient to multiple guardians.
		// $patIds = array_column($patients, 'patient_id');

		// DB returns stdObjects but we require Eloquent Models.
		// Cast stdObject to Patient Model.
		$patients = Patient::castStdToEloquent($patients);

		// Iterate over patients and set their birthday to required format.
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

		// Retrieve all visits.
		$visits = $workOrder->visit;

		// Set substituion data for each visit.
		foreach ($visits as $visit) {
			$substituion = $visit->substituion;
			if (!is_null($substituion))
				$visit->substitution = $substituion->employeeSubstitution->employee_id . ' '
					. $substituion->employeeSubstitution->person->name . ' '
					. $substituion->employeeSubstitution->person->surname;
		}

		// Check work order type and get additional equipment if necessary.
		if ($type == 'Aplikacija injekcij') {
			$medicines = [];
			foreach ($workOrder->medicineRel as $relation) {
				$medicines[] = $relation->medicine;
			}
		} else if ($type == 'Odvzem krvi') {
			// Get the number of blood tubes and store them by color.
			$bloodTubes = $workOrder->bloodTubeRel;

			foreach ($bloodTubes as $bt) {
				$color = $bt->bloodTube->color;

				switch ($color) {
					case 'Rdeča':
						$bloodTubes->red = $bt->num_of_tubes;
						break;
					case 'Modra':
						$bloodTubes->blue = $bt->num_of_tubes;
						break;
					case 'Zelena':
						$bloodTubes->green = $bt->num_of_tubes;
						break;
					case 'Rumena':
						$bloodTubes->yellow = $bt->num_of_tubes;
						break;
				}
			}
		}

		// Fix format of dates.
		$workOrder->created_at = Carbon::createFromFormat('Y-m-d H:i:s',
														  $workOrder->created_at)
									   ->format('H:i d.m.Y');
		$workOrder->start_date = Carbon::createFromFormat('Y-m-d',
														  $workOrder->start_date)
									   ->format('d.m.Y');
		$workOrder->end_date = Carbon::createFromFormat('Y-m-d',
														  $workOrder->end_date)
									   ->format('d.m.Y');

		// Store type of visits.
		$workOrder->type = $type;

		// Store actual data about employees instead of just id's.
		$workOrder->prescriber = $workOrder->prescriber->employee_id . ' '
			. $workOrder->prescriber->person->name . ' '
			. $workOrder->prescriber->person->surname;
		$workOrder->performer = $workOrder->performer->employee_id . ' '
								 . $workOrder->performer->person->name . ' '
								 . $workOrder->performer->person->surname;

		// Unset unnecessary id's.
		unset($workOrder->visit_subtype_id);
		unset($workOrder->prescriber_id);
		unset($workOrder->performer_id);

		return view('workOrder', compact(
			'workOrder',
			'patient',
			'children',
			'visits',
			'medicines',
			'bloodTubes'
		))->with([
			'name'		=> auth()->user()->person->name . ' '
							 . auth()->user()->person->surname,
			'role'		=> auth()->user()->userRole->user_role_title,
			'lastLogin'	=> $this->lastLogin(auth()->user())
		]);
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

    protected function setMaterial($materialId, $quantity, $workOrderId) {
        $material = new WorkOrder_Material();
        $material->material_id = $materialId;
        $material->material_quantity = $quantity;
        $material->work_order_id = $workOrderId;
        $material->save();
    }

	protected function setMeasurements($measurementId, $visitId, $patient_id) {
        $inputs = Input::where('measurement_id', $measurementId)->get();
        foreach ($inputs as $input) {
            $this->createVisitInput($input->input_id, $visitId, $patient_id);
        }
	}

	protected function createVisitInput($inputId, $visitId, $patient_id) {
        $input = new Visit_Input();
        $input->input_id = $inputId;
        $input->visit_id = $visitId;
        $input->patient_id = $patient_id;
        $input->save();
    }

	protected function createVisit($vDate, $isFirst, $isFixed, $workOrderId) {
		$visit = new Visit();
		$visit->planned_date = $vDate;
		$visit->first_visit = $isFirst;
		$visit->fixed_visit = $isFixed;
		$visit->work_order_id = $workOrderId;
		$visit->save();
		return $visit->visit_id;
	}

	protected function isBusinessDay($date) {
		if (FreeDays::find($date) != null) {
			return false;
		}
		if ($date->isWeekend()) {
			return false;
		}
		return true;
	}
}

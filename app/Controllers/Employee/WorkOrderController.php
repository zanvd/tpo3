<?php

namespace App\Controllers\Employee;

use App\Models\BloodTube;
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

class WorkOrderController extends Controller {

	public function __construct() {
		// Only doctor and main nurse can access register page.
		$this->middleware('auth');
//        $this->middleware(['doctor', 'chiefNurse']);
	}

	public function index() {
		return view('newWorkorder')->with([
			'visitTypes'    => VisitSubtype::all()->mapWithKeys(function ($visitSubtype) {
				return [$visitSubtype['visit_subtype_id'] => $visitSubtype['visit_subtype_title']];
			}),
			'patients'       => Patient::all()->mapWithKeys(function ($patient) {
				$person = $patient->person;
				return [$patient['patient_id'] => $patient['insurance_num'] . ' ' . $person['name'] . ' ' .$person['surname']];
			}),
			'medicine'      => Medicine::all()->mapWithKeys(function ($medicine) {
				return [$medicine['medicine_id'] => $medicine['medicine_name'] . ' ' . $medicine['medicine_packaging'] . ' ' . $medicine['medicine_type']];
			}),
			'name'			=> auth()->user()->person->name . ' ' .
				auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user()),
		]);
	}

	public function store() {
		$this->validate(request(), [
			'visitTypeId'           => 'required',
			'visits'                => 'required|numeric|min:1|max:10',
			'firstVisit'            => 'required|date|after:yesterday',
			'mandatory'             => 'required|min:0|max:1',
			'finalDate'             => 'date|after:yesterday,firstVisit',
			'interval'              => 'nullable|numeric',
			'patientId'             => 'required',
			'newbornId'             => 'nullable',
			'red'                   => 'nullable|numeric',
			'blue'                  => 'nullable|numeric',
			'yellow'                => 'nullable|numeric',
			'green'                 => 'nullable|numeric',

//            'medicine[]'            => 'numericarray'
//            'medicine[]'            => 'array|in_array:integer'
		],[
			'required'		    => 'Polje je zahtevano.',
			'numeric'		    => 'Zahtevano je število.',
			'min'		        => 'Vrednost mora biti večja od 1.',
			'max'		        => 'Vrednost mora biti manjša od 10.',
			'required_without'  => 'Izberi končni datum ali interval',
			'after'             => 'Datum mora biti večji ali enak današnjemu',
			'date'              => 'Polje mora vsebovati datum',
		]);

//        Validator::extend('numericarray', function($attribute, $value, $parameters) {
//            if(is_array($value)) {
//                foreach($value as $v) {
//                    if(!is_int($v)) {
//                        return false;
//                    }
//                }
//                return true;
//            }
//            return is_int($value);
//        });

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

		// If start date is not a business day, set start date to first business day
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

		// If there is more then one visit in WO, calculate other visit's dates
		$num = $numOfVisits;
		if ($numOfVisits > 1) {
			$interval = request('interval');

			// If interval is given, calculater date, that is business day, first after interval
			if ($interval != null) { // obisk na vsakih x dni
				while ($num > 1) {
					$date->addDays($interval);
					while (!$this->isBusinessDay($date)) {
						$date->addDay();
					}
					$num--;
				}
				$workOrder->end_date = $date;
			}

			// If the interval is not given, calculate interval from number of business days between start and end date
			else { // zadnji datum in stevilo obiskov -> pogostost obiskov
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
//                    dd($workOrder->start_date);
				}
				$workOrder->end_date = $date;
				(int)$interval = ($workDays / ($numOfVisits - 1));
			}
		} else {
			$workOrder->end_date = $start_date;
			$interval = 0;
		}

		//narocnik
		$user = Auth::user();
		$prescriber = Employee::where('person_id', $user->person_id)->first();
		$workOrder->prescriber_id = $prescriber->employee_id;

		// Avtomatsko dodeljevanje MS
		$patient_id = request('patientId');
		$patient = Patient::find($patient_id);
		$person = Person::find($patient->person_id);
		$region = $person->region_id;
		$user = new User();
		$personNurseId = User::where('user_role_id', 23)->get()->filter(function ($person, $region) {
			return $person->region_id == $region;
		})[0]->person_id;
		$workOrder->performer_id = Employee::where('person_id', $personNurseId)->first()->employee_id;
		$workOrder->substitution = false;
		$workOrder->save();

		//pacient
		$workOrderPatient = new WorkOrder_Patient();
		$workOrderPatient->patient_id = $patient_id;
		$workOrderPatient->work_order_id = $workOrder->work_order_id;
		$workOrderPatient->save();

		if (request('newbornId') != null) {
			$workOrderPatient = new WorkOrder_Patient();
			$workOrderPatient->patient_id = request('newbornId');
			$workOrderPatient->work_order_id = $workOrder->work_order_id;
			$workOrderPatient->save();
		}

		switch ($visitSubtype) {
			case '1':   // Obisk nosecnice
				$this->defaultMeasurements($workOrder->work_order_id);
				$this->setMeasurements(16, $workOrder->work_order_id);  //Teza pred nosecnostjo
				break;
			case '2':   // Obisk otrocnice in novorojencka
				$this->defaultMeasurements($workOrder->work_order_id);
				$this->setMeasurements(15, $workOrder->work_order_id);  //Telesna teza novorojencka
				$this->setMeasurements(18, $workOrder->work_order_id);  //Telesna visina novorojencka
				$this->setMeasurements(22, $workOrder->work_order_id);  //Meritev bilirubina
				break;
			case '3':   // Preventiva starostnika
				$this->defaultMeasurements($workOrder->work_order_id);
				break;
			case '4':   // Aplikacija injekcij
                dd(request('medicine'));
                $medicine[] = request('medicine[]');
                //$this->setMedicine($medicineId, $numOfUnits, $workOrderId);
				break;
			case '5':   // Odvzem krvi
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
			case '6':   // Kontrola zdravstvenega stanja
				$this->defaultMeasurements($workOrder->work_order_id);
				$this->setMeasurements(20, $workOrder->work_order_id);  //Krvni sladkor
				$this->setMeasurements(21, $workOrder->work_order_id);  //Oksigenacija SpO2
				break;
		}

		// Create first visit
		$vDate = $start_date;
		$this->createVisit($start_date, true, $isFixed == 1, $visitSubtype, $workOrder->work_order_id);
		if (request('interval') != null) {
			$isFixed = 1;
		}
		// Create other visits, if there are more
		for ($i = 1; $i < $numOfVisits; $i++) {
			$vDate->addDays($interval);
			while (!$this->isBusinessDay($vDate)) {
				$vDate->addDay();
			}
			$this->createVisit($vDate, false, $isFixed == 1, $visitSubtype, $workOrder->work_order_id);
		}
		return redirect('/delovni-nalog');
	}

	protected function defaultMeasurements($workOrderId) {
		$this->setMeasurements(10, $workOrderId);  //Sistolicni
		$this->setMeasurements(11, $workOrderId);  //Diastolicni
		$this->setMeasurements(12, $workOrderId);  //Dihanje
		$this->setMeasurements(13, $workOrderId);  //Srcni utrip
		$this->setMeasurements(14, $workOrderId);  //Telesna teza
		$this->setMeasurements(19, $workOrderId);  //Telesna temperatura
	}

	protected function setMedicine($medicineId, $numOfUnits, $workOrderId) {
		$medicine = new WorkOrder_Medicine();
		$medicine->medicine_id = $medicineId;
		$medicine->num_of_units = $numOfUnits;
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

	protected function setMeasurements($measurementId, $workOrderId) {
		$measurement = new WorkOrder_Measurement();
		$measurement->measurement_id = $measurementId;
		$measurement->work_order_id = $workOrderId;
		$measurement->save();
	}

	protected function createVisit($vDate, $isFirst, $isFixed, $subtypeId, $workOrderId) {
		$visit = new Visit();
		$visit->visit_date = $vDate;
		$visit->first_visit = $isFirst;
		$visit->fixed_visit = $isFixed;
		$visit->visit_subtype_id = $subtypeId;
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
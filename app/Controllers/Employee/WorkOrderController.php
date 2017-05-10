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
use App\Models\WorkOrder_Measurement;
use App\Models\WorkOrder_Patient;
use App\WorkOrder_Medicine;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WorkOrderController extends Controller {

	public function index() {
		$visitTypes = VisitSubtype::all();
		$patients = Patient::all();
		$medicines = Medicine::all();
		$bloodTubes = BloodTube::all();
		return view('workOrder');
	}

	public function store() {
		$this->validate(request(), [
			'visitTypeId'           => 'required|numeric',
			'numberOfVisits'        => 'required|numeric|min:1|max:10',
			'firstVisit'            => 'required|after:yesterday',
			'fixedDate'             => 'required|boolean',
			'lastVisit'             => 'required_without:time_interval|after:yesterday',
			'timeInterval'          => 'required_without:lastVisit|numeric',
			'patientId'             => 'required|numeric',
            'medicine[]'            => 'numericarray'
		]);

        Validator::extend('numericarray', function($attribute, $value, $parameters) {
            if(is_array($value)) {
                foreach($value as $v) {
                    if(!is_int($v)) {
                        return false;
                    }
                }
                return true;
            }
            return is_int($value);
        });

		$workOrder = new WorkOrder();

		// TODO: if visit type is 2, there are two patients
		// TODO: only woman can have visit type 1 or 2
		$visitSubtype = request('visitTypeId');
		$isFixed = request('isFixed');
		$workOrder->created_at = Carbon::now()->toDateTimeString();

		$numOfVisits = request('numberOfVisits');
		$start_date = request('firstVisit');
		/* TODO: Uncomment when proper format is sent from frontend.
		 * $fDate = \DateTime::createFromFormat(
			'd.m.Y',
			$start_date)->format('Y-m-d');*/
		$fDate = $start_date;
		$start_date = new Carbon($fDate);

		// If start date is not a business day, set start date to first business day
		while (!$this->isBusinessDay($start_date)) {
			$start_date->addDay();
		}
		$workOrder->start_date = $start_date;
		$date = request('firstVisit');
		$date = new Carbon($date);

		// If there is more then one visit in WO, calculate other visit's dates
		$num = $numOfVisits;
		if ($numOfVisits > 1) {
			$interval = request('timeInterval');

			// If interval is given, calculater date, that is business day, first after interval
			if ($interval != null) { // obisk na vsakih x dni
				while ($num > 0) {
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
				$end_date = request('lastVisit');
				/* TODO: Uncomment when proper format is sent from frontend.
				$feDate = \DateTime::createFromFormat(
					'd.m.Y',
					$end_date)->format('Y-m-d');*/
				$feDate = $end_date;
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

		$patient_id = request('patientId');
		// Avtomatsko dodeljevanje MS
		$patient = Patient::find($patient_id);
		$person = Person::find($patient->person_id);
		$region = $person->region_id;
		$user = new User();
		$personNurseId = User::where('user_role_id', 23)->get()->filter(function ($person, $region) {
			return $person->region_id == $region;
		})[0]->person_id;
		//dd($personNurseId);
		$workOrder->performer_id = Employee::where('person_id', $personNurseId)->first()->employee_id;
		$workOrder->substitution = false;
		$workOrder->save();

		//pacient
		$workOrderPatient = new WorkOrder_Patient();
		$workOrderPatient->patient_id = $patient_id;
		$workOrderPatient->work_order_id = $workOrder->work_order_id;
		$workOrderPatient->save();

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

			   // $this->setNumOfBloodTubes($bloodTubeId, $numOfTubes, $workOrderId);
				break;
			case '5':   // Odvzem krvi
                $medicine[] = request('medicine[]');
				//$this->setMedicine($medicineId, $numOfUnits, $workOrderId);
				break;
			case '6':   // Kontrola zdravstvenega stanja
				$this->defaultMeasurements($workOrder->work_order_id);
				$this->setMeasurements(20, $workOrder->work_order_id);  //Krvni sladkor
				$this->setMeasurements(21, $workOrder->work_order_id);  //Oksigenacija SpO2
				break;
		}

		// Create first visit
		$vDate = $start_date;
		$this->createVisit($start_date, true, $isFixed, $visitSubtype, $workOrder->work_order_id);
		if (request('interval') != null) {
			$isFixed = true;
		}
		// Create other visits, if there are more
		for ($i = 1; $i < $numOfVisits; $i++) {
			$vDate->addDays($interval);
			while (!$this->isBusinessDay($vDate)) {
				$vDate->addDay();
			}
			$this->createVisit($vDate, false, $isFixed, $visitSubtype, $workOrder->work_order_id);
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
		$tube = new BloodTube();
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
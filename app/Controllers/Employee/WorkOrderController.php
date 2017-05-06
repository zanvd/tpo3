<?php

namespace App\Controllers\Employee;

use App\Models\BloodTube;
use App\Models\User;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Medicine;
use App\Controllers\Controller;
use App\Models\Person;
use App\Models\VisitSubtype;
use App\Models\WorkOrder;
use App\Models\WorkOrder_Patient;
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
        $workOrder = new WorkOrder();
        $workOrder->visitSubtype = request('visitType');
        $workOrder->created_at = Carbon::now()->toDateTimeString();

        $numOfVisits = request('number_of_visits');
        $start_date = request('firstVisit');
        $workOrder->start_date = new Carbon($start_date);
        // TODO:izračunaj končni datum!!
        $date = new Carbon($start_date);
        $interval = request('time_interval');
        if ($interval != null) { // obisk na vsakih x dni
            while ($numOfVisits > 0) {
                $date->addDays($interval);
                while (!$this->isBusinessDay($date)) {
                    $date->addDay();
                }
                $numOfVisits--;
            }
            $workOrder->end_date = $date;
        } else { // zadnji datum in stevilo obiskov -> pogostost obiskov

        }

        //narocnik
        $user = Auth::user();
        $prescriber = Employee::where('person_id', $user->person_id)->get();
        $workOrder->prescriber_id = $prescriber->employee_id;

        $patient_id = request('patient_id');
        // Avtomatsko dodeljevanje MS
        $region = Person::find($patient_id->person_id)->region_id;
        $personNurseId = User::where('region_id', $region)->where('user_role_id', 23)->first()->person_id;
        $workOrder->performer_id = Employee::where('person_id', $personNurseId)->first();

        //pacient
        $workOrderPatient = new WorkOrder_Patient();
        $workOrderPatient->patient_id = $patient_id;
        $workOrderPatient->work_order_id = $workOrder->work_order_id;
    }

    protected function isBusinessDay($date) {
        $objDate = new Carbon($date);
        $year = $objDate->year;
        $month = $objDate->month;
        $day = $objDate->day;
        return json_decode(file_get_contents('http://api.dmz6.net/datum/businessday/'.$year.'/'.$month.'/'.$day ), true);
    }
}

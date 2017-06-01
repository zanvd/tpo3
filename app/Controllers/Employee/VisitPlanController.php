<?php

namespace App\Controllers\Employee;

use Illuminate\Support\Facades\DB;
use App\Controllers\Controller;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Plan;
use App\Models\WorkOrder;
use App\Models\Substitution;
use Carbon\Carbon;

class VisitPlanController extends Controller {
    
	public function __construct () {
        // Only nurses can access
        $this->middleware('role:Patronažna sestra');
    }   

    public function index(){

    	$todayDate = date("Y-m-d");
        $employeeId = auth()->user()->person->employee->employee_id;

        //poišče vsa nadomeščanja, ki jih bo opravljala ta sestra
        $substitutions = Substitution::where('employee_substitution', $employeeId)->get();
        
        //Poišči vse obiske, ki jih mora opraviti prijavljena sestra in jih še ni opravila
    	$obiski_sestra = Visit::whereHas('workOrder', function($workOrder) use ($employeeId){
            $workOrder->where('performer_id', $employeeId);
        })->where('done', '0')->get();

        //Poišči vse obiske, ki jih morajo opraviti sestre, ki jih nadomešča prijavljena sestra v času teh nadomeščanj in še niso bili orpavljeni
        $obiski_nadomescanje = collect();
        if(sizeof($substitutions)> 0){
            foreach ($substitutions as $sub) {
                $empId = $sub->employee_absent;

                $currentSub = Visit::whereHas('workOrder', function($q) use ($empId){
                    $q->where('performer_id', $empId);
                })->where('done', '0')->where('planned_date', '>=', $sub->start_date)->where('planned_date', '<=', $sub->end_date)->get();
                
                foreach($currentSub as $cs){
                    $obiski_nadomescanje->push($cs);
                }
                
            }
        }

        //Združimo vse obiske v en seznam
        $obiski_vsi = $obiski_sestra->merge($obiski_nadomescanje)->sortBy('planned_date');

        foreach($obiski_vsi as $obisk){
            $workOrder = WorkOrder::where('work_order_id', $obisk->work_order_id)->first();
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

                $patients = Patient::castStdToEloquent($patients);

            // Set visit_subtype object
            $obisk->visitTitle = $workOrder->visitSubtype->visit_subtype_title;
            unset($workOrder->visit_subtype_id);
            
//            $obisk->patients = $patients;
            $obisk->workOrderId = $obisk->work_order_id;
            $obisk->fixedVisit = $obisk->fixed_visit;
            $obisk->plannedDate = $obisk->planned_date;
            $obisk->planID = $obisk->plan_id;
        }

        //Razdelimo vse obiske po potrebnih seznamih za frontend
        $obvezni_v_planu = collect();
        $obvezni_brez_plana = collect();
        $okvirni_v_planu = collect();
        $okvirni_brez_plana = collect();

        foreach($obiski_vsi as $obisk){
            if($obisk->fixed_visit == 0){
                if(!empty ($obisk->plan_id)){
                    $date = Plan::where('plan_id', $obisk->plan_id)->first()->plan_date;
                    $obisk->plan_date = $date;
                    $okvirni_v_planu->push($obisk);
                }
                else{
                    $okvirni_brez_plana->push($obisk);
                } 
            }
            else{
                if(!empty ($obisk->plan_id)){
                    $obvezni_v_planu->push($obisk);
                }
                else{
                    $obvezni_brez_plana->push($obisk);
                } 
            }
        }

        $plani = Plan::where('nurse_id', $employeeId)->where('plan_date', '>=', $todayDate)->get();

        //Vrnemo vse potrebne spremenljivke
        return view('visitPlan', [
            'obvezniBrezPlana'  => $obvezni_brez_plana,
            'obvezniVPlanu'     => $obvezni_v_planu,
            'okvirniVPlanu'     => $okvirni_v_planu,
            'okvirniBrezPlana'  => $okvirni_brez_plana,
            'plani'             => $plani,
            'name'              => auth()->user()->person->name . ' '
                                    . auth()->user()->person->surname,
            'role'              => auth()->user()->userRole->user_role_title,
            'lastLogin'         => $this->lastLogin(auth()->user())
            ]);


/*
    	return view('visitPlan')->with([
    			

			'visits'		=> Visit::all()->where('visit_date', '==', $date)->where('done', '==', '0')->where('fixed_visit', '==', '1')->sortBy('visit_date')->mapWithKeys(function($visit){
				$work_order = $visit->work_order;
				$visit_subtype = $visit->visit_subtype;
				$visit_type = $visit_subtype->visit_type;

				return [$visit['visit_id'] => $visit['visit_date'] . ' ' . $visit['fixed_visit'] . ' ' . $work_order['work_order_id'] . ' ' . $visit_type['visit_type_title'] . ' ' . $visit_subtype['visit_subtype_title']];
			})

		]);

		*/
    }

    public function store(){

        //Start transaction
        DB::beginTransaction();

        try{
            //Razčlenimo seznam 
            $nizNovih = request('visitIDs');
            $nizOdstranjenih = request('removedVisitIDs');

            if (is_null($nizOdstranjenih) && empty($nizNovih)){
                return redirect()->back()->withErrors([
                'message' => 'V planu ni obiskov. Prosim dodajte obisk v željeni plan, če ga želite shraniti'
                ]);
            }

            $seznamNovih = explode('-', $nizNovih);
            //Ustvarimo nov plan, če še ne obstaja.
            
            $planId = request('planIDs');
            if ($planId == null){
                $plan = new Plan();
                
                $planDate = Carbon::createFromFormat('d.m.Y',
                    request('planDate')) ->format('Y-m-d');

                $nurseId = auth()->user()->person->employee->employee_id;

                $plan->plan_date = $planDate;
                $plan->nurse_id = $nurseId;

                $plan->save();
                $planId = $plan->plan_id;
            }

//            dd($seznamNovih);
            if ($seznamNovih[0] != "") {
                foreach($seznamNovih as $visitID){
                    $visit = Visit::where('visit_id', $visitID)->first();
                    $visit->plan_id = $planId;
                    $visit->save();
                }
            }

            $seznamOdstranjenih = explode('-', $nizOdstranjenih);

            for ($i = 0; $i < count($seznamOdstranjenih) - 1; $i++){
                $visit = Visit::where('visit_id', $seznamOdstranjenih[$i])->first();
                $visit->plan_id = null;
                $visit->save();
            }

            $plan = Plan::where('plan_id', $planId)->first();
            $visitsInPlan = Visit::where('plan_id', $planId)->get();
            $deleted = false;
            if (count($visitsInPlan) == 0) {
                $deleted = true;
                $plan->delete();
            }


        }
        catch (\Exception $e) {
            // Log exception.
            error_log(print_r('Error when saving a visit-plan: ' .
                $e, true));

            // Rollback everything.
            DB::rollback();

            // Let the user know about the failure and ask to try again.
            return redirect()->back()->withErrors([
                'message' => 'Napaka pri shranjevanju načrta obiskov ' .
                    'ali zapisa, povezanega z njim. Prosimo, poskusite znova.'
            ]);
        }

        DB::commit();

        if ($deleted) {
            return redirect('/nacrt-obiskov')->with([
                'status' => 'Načrt obiskov izbrisan.'
            ]);
        }

        return redirect('/nacrt-obiskov')->with([
            'status' => 'Načrt obiskov uspešno shranjen.'
        ]);
    }

    public function showPlans() {
        $employeeId = auth()->user()->person->employee->employee_id;
        $plans = Plan::where('nurse_id', '=', $employeeId)->where('plan_date', '>=', date("Y-m-d"))->get();

        foreach($plans as $plan) {
            $plan->visits = Visit::where('plan_id', $plan->plan_id)->get();

            foreach($plan->visits as $visit) {
                $visit->visit_type = WorkOrder::where('work_order_id', $visit->work_order_id)->first()->visitSubtype->visit_subtype_title;
            }
        }
        return view('planList', [
            'plans'         => $plans,
            'name'          => auth()->user()->person->name . ' '
                                 . auth()->user()->person->surname,
            'role'          => auth()->user()->userRole->user_role_title,
            'lastLogin'     => $this->lastLogin(auth()->user())
        ]);
    }
}

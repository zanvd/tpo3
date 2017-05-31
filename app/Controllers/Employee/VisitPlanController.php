<?php

namespace App\Controllers\Employee;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Plan;
use App\Models\WorkOrder;
use App\Models\WorkOrder_Patient;
use App\Models\Person;
use App\Models\Employee;
use App\Models\User;
use App\Models\Substitution;
use Carbon\Carbon;



class VisitPlanController extends Controller
{
    
	public function __construct () {
        // Only nurses can access
        $this->middleware('role:Patronažna sestra')
            ->except(['index', 'show']);
    }   

    public function index(){

    	$todayDate = date("Y-m-d");
    	
        //ID sestre, ki je prijavljena v sistem.
        global $employee_id;
        $employee_id = auth()->user()->person->employee->employee_id;

        //poišče vsa nadomeščanja, ki jih bo opravljala ta sestra
        $substitutions = Substitution::all()->where('employee_substitution', '=', $employee_id); 
        
        //Poišči vse obiske, ki jih mora opraviti prijavljena sestra in jih še ni opravila
    	$obiski_sestra = Visit::whereHas('work_order', function($q){
            global $employee_id;
            $q->where('performer_id', '=', $employee_id);
        })->where('done', '=', '0')->get();

        //Poišči vse obiske, ki jih morajo opraviti sestre, ki jih nadomešča prijavljena sestra v času teh nadomeščanj in še niso bili orpavljeni
        $obiski_nadomescanje = collect();
        if(sizeof($substitutions)> 0){
            foreach ($substitutions as $sub) {
                global $emp_id;
                $emp_id = $sub->employee_absent;
                

                $currentSub = Visit::whereHas('work_order', function($q){
                global $emp_id;
                $q->where('performer_id', '=', $emp_id);
                })->where('done', '=', '0')->where('planned_date', '>=', $sub->start_date)->where('planned_date', '<=', $sub->end_date)->get();
                
                foreach($currentSub as $cs){
                    $obiski_nadomescanje->push($cs);
                }
                
            }
        }

        //Združimo vse obiske v en seznam
        $obiski_vsi = $obiski_sestra->merge($obiski_nadomescanje)->sortBy('planned_date');

        foreach($obiski_vsi as $obisk){
            $workOrder = WorkOrder::where('work_order_id', '=', $obisk->work_order_id)->first();
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

            
            $obisk->patients = $patients;
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

        $plani = Plan::where('nurse_id', '=', $employee_id)->where('plan_date', '>=', $todayDate)->get();


        //Vrnemo vse potrebne spremenljivke
        return view('visitPlan', ['obvezniBrezPlana' => $obvezni_brez_plana, 'obvezniVPlanu' =>$obvezni_v_planu, 'okvirniVPlanu' => $okvirni_v_planu, 'okvirniBrezPlana' => $okvirni_brez_plana, 'plani' => $plani]);


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


}

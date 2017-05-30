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
use App\Models\WorkOrder;
use App\Models\WorkOrder_Patient;
use App\Models\Person;
use App\Models\Employee;
use App\Models\User;
use App\Models\Substitution;


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
        $substitutions = Substitution::all()->where('employee_substitution', '=', $employee_id); //->where('end_date', '>=', 'todayDate');
        

    	$obiski_sestra = Visit::whereHas('work_order', function($q){
            $employee_id = auth()->user()->person->employee->employee_id;
            $q->where('performer_id', '=', $employee_id);
        })->where('done', '=', '0')->get();


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

        $obiski_vsi = $obiski_sestra->merge($obiski_nadomescanje)->sortBy('planned_date');


        //Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $currentPageSearchResults = $obiski_vsi->slice (($currentPage - 1) * $perPage, $perPage) -> all ();
        $obiski_paginated= new LengthAwarePaginator($currentPageSearchResults, count($obiski_vsi), $perPage);

        $obiski_paginated->setPath('/nacrt-obiskov/');

    	$wops = WorkOrder_Patient::all();



        return view('visitPlan', ['visits' => $obiski_paginated, 'wops' => $wops]);


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

<?php

namespace App\Controllers\Employee;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\WorkOrder;
use App\Models\WorkOrder_Patient;
use App\Models\Person;
use App\Models\Employee;
use App\Models\User;

class VisitPlanController extends Controller
{
    
	
    

    public function index(){

    	$todayDate = '2017-05-15';//date("Y-m-d");
    	$employee_id = 94252; //auth()->user()->person->employee->employee_id;

    	$obvezniObiski = Visit::whereHas('work_order', function($q){
    		$employee_id = 94252;
    		$q->where('performer_id', '=', $employee_id);
    	})->where('visit_date', '=', $todayDate)->where('fixed_visit', '=', 1)->get();

    	$wops = WorkOrder_Patient::all();

    	return view('visitPlan', ['obvezniObiski' => $obvezniObiski, 'wops' => $wops]);


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

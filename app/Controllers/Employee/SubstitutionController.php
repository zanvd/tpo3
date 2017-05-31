<?php

namespace App\Controllers\Employee;


use App\Controllers\Controller;
use App\Models\Employee;
use App\Models\Plan;
use App\Models\Substitution;
use App\Models\User;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubstitutionController extends Controller {

	public function __construct () {
		// Only main nurse can access and store substitutions.
		$this->middleware('role:Vodja PS');
	}

	/**
	 * Display page with listed substitutions.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		$substitutions = Substitution::all();

		foreach ($substitutions as $substitution) {
			$absent = Employee::where('employee_id', $substitution->employee_absent)->first()->person;
			$absentName = $absent->name . ' ' . $absent->surname;
			$substitution->absent = $absentName;

			$subs = Employee::where('employee_id', $substitution->employee_substitution)->first()->person;
			$subsName = $subs->name . ' ' . $subs->surname;
			$substitution->subs = $subsName;

			unset($substitution->employee_substitution, $substitution->employee_absent);
		}

		$sisters = User::where('user_role_id', 23)->get();

		foreach ($sisters as $sister) {
			$sister->name = $sister->person->employee->employee_id . ' ' . $sister->person->name . ' ' . $sister->person->surname;
			$sister->employee_id = $sister->person->employee->employee_id;
		}

		return view('substitution')->with([
			'sisters'		=> $sisters->mapWithKeys(function ($sister) {
								return [$sister['employee_id'] => $sister->name];
							}),
			'substitutions' => $substitutions,
			'name'			=> auth()->user()->person->name . ' '
				. auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user())
		]);
	}


	/**
	 * Store substitution in database.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store() {

		$this->validate(request(), [
			'dateFrom' => 'required|date|after:yesterday',
			'dateTo' => 'required|date|after:yesterday,dateFrom',
			'absent' => 'required|different:present',
			'present' => 'required|different:absent'
		], [
			'required' => 'Polje je zahtevano.',
			'after' => 'Datum mora biti večji ali enak današnjemu in večji od datuma začetka odsotnosti',
			'date' => 'Polje mora vsebovati datum'
		]);

		$absent = request('absent');
		$subs = request('present');
		$dateFrom = Carbon::createFromFormat('d.m.Y',
			request('dateFrom')) ->format('Y-m-d');
		$dateTo = Carbon::createFromFormat('d.m.Y',
			request('dateTo')) ->format('Y-m-d');

		// Start Transaction.
		DB::beginTransaction();

		// Try saving new WorkOrder and relating recordings to the database.
		try {
			$substitution = new Substitution();

			$substitution->employee_absent =  $absent;
			$substitution->employee_substitution = $subs;
			$substitution->start_date = $dateFrom;
			$substitution->end_date = $dateTo;
			$substitution->save();

			$visits = Visit::all();
			foreach ($visits as $visit) {
				// Assign absent nurse's visits to substitution nurse (connection through substitution_id in visit)
				if ($visit->workOrder->performer_id == $absent && $visit->done == 0
					&& $visit->planned_date >= $dateFrom
					&& $visit->planned_date <= $dateTo) {

					$visit->substitution_id = $substitution->substitution_id;
					$visit->plan_id = null;
					$visit->save();
				}
				// Assign visits of absent nurse, where she is substitute, to substitution nurse (connection through substitution_id in visit)
				if ($visit->done == 0 && $visit->substitution_id != 0
					&& $visit->substitution->employee_substitution == $absent
					&& $visit->planned_date >= $dateFrom
					&& $visit->planned_date <= $dateTo) {

					$visit->substitution_id = $substitution->substitution_id;
					$visit->plan_id = null;
					$visit->save();
				}
			}

			// If nurse had planed visits for days she is absent, those plans are deleted
			$nursePlans = Plan::where('nurse_id', $absent)->get();
			foreach ($nursePlans as $plan) {
				if ($plan->plan_date >= $dateFrom && $plan->plan_date <= $dateTo) {
					$plan->delete();
				}
			}

		} catch (\Exception $e) {
			// Log exception.
			error_log(print_r('Error when creating new Substitution or relating recordings: ' .
				$e, true));

			// Rollback everything.
			DB::rollback();

			// Let the user know about the failure and ask to try again.
			return redirect()->back()->withErrors([
				'message' => 'Napaka pri shranjevanju nadomeščanja.'
			]);
		}
		// Everything is fine. Commit changes to database.
		DB::commit();

		return redirect('/nadomeščanja')->with([
			'status' => 'Nadomeščanje shranjeno'
		]);

	}
}
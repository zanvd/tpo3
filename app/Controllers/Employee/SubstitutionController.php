<?php

namespace App\Controllers\Employee;


use App\Controllers\Controller;
use App\Models\Employee;
use App\Models\Substitution;

class SubstitutionController extends Controller {

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
        return view('substitution')->with([
            'substitutions'        => $substitutions,
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
            'dateFrom'          => 'required|date|after:yesterday',
            'dateTo'            => 'required|date|after:yesterday,dateFrom',
            'absent'            => 'required',
            'subs'              => 'required'
        ],[
            'required'		    => 'Polje je zahtevano.',
            'after'             => 'Datum mora biti večji ali enak današnjemu in večji od datuma začetka odsotnosti',
            'date'              => 'Polje mora vsebovati datum'
        ]);

        // Start Transaction.
        DB::beginTransaction();

        // Try saving new WorkOrder and relating recordings to the database.
        try {
            $substitution = new Substitution();

            $substitution->employee_absent = request('absent');
            $substitution->employee_substitution = request('subs');
            $substitution->start_date = request('dateFrom');
            $substitution->end_date = request('dateTo');
            $substitution->save();


            //TODO: nadomestni sestri dodeli obiske odsotne sestre


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
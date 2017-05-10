<?php

namespace App\Controllers\Patient;

use App\Controllers\Controller;
use App\Models\DependentPatient;
use App\Models\Patient;
use App\Models\Person;
use App\Models\Post;
use App\Models\Region;
use App\Models\Relationship;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DependentPatientController extends Controller {
	/**
	 * Create a new dependant patient controller instance.
	 *
	 */
	public function __construct() {
		// Only patients can access this page.
		$this->middleware('patient');
	}

	/**
	 * Display add new dependant patient page.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 *
	 */
	public function index () {
		return view('addPatient')->with([
			'name'			=> auth()->user()->person->name . ' ' .
								 auth()->user()->person->surname,
			'role'			=> auth()->user()->userRole->user_role_title,
			'lastLogin'		=> $this->lastLogin(auth()->user()),
			'posts'			=> Post::all()->mapWithKeys(function ($post) {
				return [$post['post_number'] => $post['post_title']];
			}),
			'regions'		=> Region::all()->mapWithKeys(function ($region) {
				return [$region['region_id'] => $region['region_title']];
			}),
			'relationships' => Relationship::all()->mapWithKeys(function ($relationship) {
				return [
					$relationship['relationship_id']
					=> $relationship['relationship_type']
				];
			})
		]);
	}

	/**
	 * Create new dependant patient.
	 *
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function store () {
		$this->validate(request(), [
			'name'			=> 'required|string',
			'surname'		=> 'required|string',
			'sex'			=> 'required|string|size:1',
			'birthDate'		=> 'required|date|before:tomorrow',
			'address'		=> 'required',
			'postNumber'	=> 'required|digits:4',
			'region'		=> 'required|numeric',
			'insurance'		=> 'required|digits:9',
			'relationship'	=> 'required|numeric'
		]);

		// Start Transaction.
		DB::beginTransaction();

		// Try saving new patient to the database.
		try {
			// Create new Person.
			$person = new Person([
				'name'			=> request('name'),
				'surname'		=> request('surname'),
				'phone_num'		=> auth()->user()->person->phone_num,
				'address'		=> request('address'),
				'post_number'	=> request('postNumber'),
				'region_id'		=> request('region'),
			]);

			$person->save();

			// Create new Patient.
			$patient = new Patient([
				'insurance_num' => request('insurance'),
				'birth_date'	=> Carbon::createFromFormat('d.m.Y',
									request('birthDate'))->toDateString(),
				'sex'			=> request('sex'),
				'person_id'		=> $person->person_id,
				'contact_id'	=> isset($contact) ? $contact->contact_id : NULL
			]);

			$patient->save();

			// Create new relationship between guardian and dependent patient.
			$dependent = new DependentPatient([
				'dependent_patient_id'	=> $patient->patient_id,
				'guardian_patient_id'	=> auth()->user()->person->patient->patient_id,
				'relationship_id'		=> request('relationship')
			]);

			$dependent->save();

		} catch (\Exception $e) {
			// Log exception.
			error_log(print_r('Error when creating new dependent patient: ' .
							  $e, true));

			// Rollback everything.
			DB::rollback();

			// Let the user know about the failure and ask to try again.
			return redirect()->back()->withErrors([
				'message' => 'Napaka pri ustvarjanju novega oskrbovanega ' .
					'pacienta. Prosimo, poskusite znova.'
			]);
		}

		// Everything is fine. Commit changes to database.
		DB::commit();

		return redirect('/profil')->with([
			'status' => 'Oskrbovani pacient uspešno dodan.'
		]);
	}
}

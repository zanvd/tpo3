<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Uporabnik;

class LoginControllerTest extends TestCase {

	use DatabaseTransactions;

	/**
	 * Perform a unit test on store function.
	 * Check for when login succeeds and when it fails.
	 *
	 */
	public function testStore() {
		// Create user for successful call.
		$success = factory(Uporabnik::class)->create();

		// Create user for failed call.
		$fail = factory(Uporabnik::class)->create();

		$data = [
			'success'	=> [
				'email'		=> $success->email,
				'password'	=> '123456'
			],
			'fail'		=> [
				'email'		=> $fail->email,
				'password'	=> 'blablahopsasa'
			]
		];

		$respSuccess = $this->post('prijava', $data['success']);

		$respSuccess->assertRedirect('http://patronaza.tpo');

		$this->get('odjava');

		$respFail = $this->post('prijava', $data['fail']);

		$respFail->assertSee('Nepravilen email ali geslo. Prosimo, poizkusite znova.');
	}
}

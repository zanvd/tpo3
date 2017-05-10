<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Verification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable {
	use Queueable, SerializesModels;

	public $user;

	public $verification;

	/**
	 * EmailVerification constructor.
	 *
	 * @param User $user
	 * @param Verification $verification
	 */
	public function __construct (User $user, Verification $verification) {
		$this->user = $user;
		$this->verification = $verification;
	}

	public function build () {
		return $this->view('emails.verification');
	}
}

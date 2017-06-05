<?php
namespace App\Mail;

use App\Models\ResetLink;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailResetPassword extends Mailable {
	use Queueable, SerializesModels;

	public $user;

	public $resetLink;

	/**
	 * EmailResetPassword constructor.
	 *
	 * @param User      $user
	 * @param ResetLink $resetLink
	 */
	public function __construct (User $user, ResetLink $resetLink) {
		$this->user = $user;
		$this->resetLink = $resetLink;
	}

	/**
	 * Build email view.
	 *
	 * @return $this
	 */
	public function build () {
		return $this->view('emails.resetPassword');
	}
}

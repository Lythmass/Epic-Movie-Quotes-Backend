<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifySecondaryEmail extends Mailable
{
	use Queueable;

	use SerializesModels;

	private $userId;

	private $email;

	private $token;

	public function __construct($userId, $email, $token)
	{
		$this->userId = $userId;
		$this->email = $email;
		$this->token = $token;
	}

	public function envelope()
	{
		return new Envelope(
			subject: 'Please verify your email address',
		);
	}

	public function content()
	{
		$verificationLink = config('app.front_app_url') . app()->getLocale() . '/profile?verify_secondary_email=' . $this->userId . '&token=' . $this->token . '&email=' . $this->email;
		return new Content(
			markdown: 'emails.index',
			with: [
				'frontURL'   => $verificationLink,
				'notifiable' => (object)['name' => auth()->user()->name],
			]
		);
	}
}

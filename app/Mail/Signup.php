<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Signup extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		return $this->view('emails.signup')
			->subject("Welcome to MyTravel Compared")
			->with([
				'first_name' => $this->data['first_name'],
				'email' => $this->data['email'],
				'password' => $this->data['password']
			]);
    }
}

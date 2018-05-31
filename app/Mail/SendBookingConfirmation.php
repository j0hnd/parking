<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingConfirmation extends Mailable
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
		return $this->view('emails.booking_confirmation')
			->subject("My Travel Compared Booking Confirmation")
			->with([
				'booking_id' => $this->data['booking_id'],
				'drop_off' => $this->data['drop_off'],
				'return_at' => $this->data['return_at'],
				'order' => $this->data['order'],
				'firstname' => $this->data['firstname']
			]);
    }
}

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
    	if (isset($this->data['bcc'])) {
			return $this->view('emails.booking_customer')
				->bcc(config('app.bcc'), 'MyTravelCompared Booking Check')
				->subject($this->data['subject'])
				->with($this->data);
		} else {
			return $this->view('emails.booking_customer')
				->subject($this->data['subject'])
				->with($this->data);
		}
    }
}

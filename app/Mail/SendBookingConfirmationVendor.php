<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBookingConfirmationVendor extends Mailable
{
    use Queueable, SerializesModels;

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
		$booking = $this->data['booking'];
		$csv_filename = strtoupper($booking->booking_id).'.csv';

		return $this->view('emails.booking_company')
			->subject("My Travel Compared Booking Confirmation")
			->with([
				'booking'  => $booking,
				'customer' => $this->data['customer'],
				'vendor'   => $this->data['vendor'],
				'carpark'  => $this->data['carpark']
			])
			->attach(storage_path('csv') . '/' . $csv_filename, [
				'as'   => 'booking-'.$csv_filename,
				'mime' => 'text/csv'
			]);
	}
}

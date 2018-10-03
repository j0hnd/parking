<?php

namespace App\Export;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TravelAgentExport implements FromView
{
	protected $data;

	public function __construct($data)
	{
		$this->data = $data;
	}


	public function view(): View
	{
		return view('app.Export.travel_agent', [
			'bookings' => $this->data
		]);
	}
}
<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;



class CompletedJobs implements FromCollection, WithMapping, WithHeadings
{
	protected $data;


	public function __construct($data)
	{
		$this->data = $data;
	}

	public function map($data): array
	{
		return [
			$data->company_name,
			'£'.number_format($data->sales, 2),
			'£'.number_format($data->revenue, 2),
			'£'.number_format($data->booking_fee, 2),
			'£'.number_format($data->sms_fee, 2),
			'£'.number_format($data->cancallation_waiver, 2),
		];
	}

	public function headings(): array
	{
		return [
			'Vendor',
			'Sales',
			'Revenue',
			'Booking Fee',
			'SMS Confirmation Fee',
			'Cancellation Waiver'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
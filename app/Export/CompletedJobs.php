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
			$data->booking_id,
			$data->products[0]->vendors[0]->company_name,
			$data->order_title,
			'£'.number_format($data->price_value, 2),
			$data->return_at->format('F j, Y')
		];
	}

	public function headings(): array
	{
		return [
			'Booking ID',
			'Vendor',
			'Order',
			'Booking Fee',
			'Expected Date of Completion'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
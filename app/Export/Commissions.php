<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;



class Commissions implements FromCollection, WithMapping, WithHeadings
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
			$data->products[0]->revenue_share.'%',
			'£'.$data->revenue_value
		];
	}

	public function headings(): array
	{
		return [
			'Booking ID',
			'Vendor',
			'Order',
			'Revenue Share',
			'Revenue Value'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
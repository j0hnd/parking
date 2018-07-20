<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;



class CompanyRevenues implements FromCollection, WithMapping, WithHeadings
{
	protected $data;


	public function __construct($data)
	{
		$this->data = $data;
	}

	public function map($data): array
	{
		list($airport_name, $parking_type) = explode('-', $data->order_title);
		$carpark_amount = $data->price_value - $data->price_value * round(($data->products[0]->revenue_share/100), 2);

		return [
			$data->booking_id,
			$data->products[0]->carpark->name,
			$data->products[0]->airport[0]->airport_name,
			$parking_type,
			"£".$carpark_amount
		];
	}

	public function headings(): array
	{
		return [
			'Order Number',
			'Vendor Name',
			'Airport',
			'Parking Type',
			'Carpark Amount'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
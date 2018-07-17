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
			$data->products[0]->carpark->name,
			$data->order_title,
			$data->customers->first_name." ".$data->customers->last_name,
			$data->created_at->format('F j, Y'),
			$data->drop_off_at->format('F j, Y')."/".$data->return_at->format('F j, Y'),
			($data->price_value + $data->booking_fee + $data->sms_confirmation_fee + $data->cancellation_waiver) - $data->revenue_value
		];
	}

	public function headings(): array
	{
		return [
			'Booking ID',
			'Vendor',
			'Order',
			'Customer Name',
			'Book Date',
			'Drop Off At/Return At',
			'Cost'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
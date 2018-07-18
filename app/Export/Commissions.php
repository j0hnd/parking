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
		if (isset($data->affiliate_bookings[0])) {
			$affiliate_percent = round($data->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
			$affiliate_cost = round($data->products[0]->revenue_share * $affiliate_percent, 2);
		} else {
			$affiliate_cost = '0';
		}

		$sms_confirmation_fee = empty($data->sms_confirmation_fee) ? '0' : $data->sms_confirmation_fee;
		$cancellation_waiver = empty($data->cancellation_waiver) ? '0' : $data->cancellation_waiver;

		return [
			$data->booking_id,
			$data->products[0]->carpark->name,
			$data->products[0]->revenue_share.'%',
			$data->price_value + $data->booking_fees + $data->sms_confirmation_fee + $data->cancellation_wavier,
			$data->price_value,
			number_format($data->price_value * ($data->products[0]->revenue_share/100), 2),
			$data->booking_fees,
			$sms_confirmation_fee,
			$cancellation_waiver,
			$affiliate_cost
		];
	}

	public function headings(): array
	{
		return [
			'Order Number',
			'Vendor\'s Name',
			'Commission %',
			'Total Order Value',
			'Car Parking Product Value',
			'Revenue Share',
			'Booking Fee',
			'SMS Confirmation Fee',
			'Cancellation Waiver',
			'Affiliate Cost'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
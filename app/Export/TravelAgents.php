<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;



class TravelAgents implements FromCollection, WithMapping, WithHeadings
{
	protected $data;


	public function __construct($data)
	{
		$this->data = $data;
	}

	public function map($data): array
	{
		$total_commission = 0;
		$commission = 0;

		$revenue_share = number_format($data->price_value * ($data->products[0]->revenue_share/100), 2);

		if (isset($data->affiliate_bookings[0])) {
			$affiliate_percent = round($data->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
			$commission = round($revenue_share * $affiliate_percent, 2);
			$total_commission += $commission;
		}
		
		return [
			$data->booking_id,
			$data->customers->first_name." ".$data->customers->last_name,
			$data->products[0]->airport[0]->airport_name,
			$data->price_value,
			$data->affiliate_bookings[0]->affiliates[0]->travel_agent->members->company->company_name,
			'£'.number_format($commission, 2),
		];
	}

	public function headings(): array
	{
		return [
			'Order Number',
			'Customer Name',
			'Airport',
			'Carpark Product Value',
			'Travel Agent',
			'Commissions'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
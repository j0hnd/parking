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
		return [
			$data->company_name,
			"£".number_format($data->revenue, 2)
		];
	}

	public function headings(): array
	{
		return [
			'Vendor',
			'Revenue'
		];
	}

	public function collection()
	{
		return $this->data;
	}
}
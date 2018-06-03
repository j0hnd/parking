<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Companies;
use Illuminate\Http\Request;
use DB;

class ReportsController extends Controller
{
	private $vendors;

	public function __construct()
	{
		parent::__construct();
		$this->vendors = Companies::active()->orderBy('company_name', 'asc');
	}


	public function companies(Request $request)
	{
		$page_title = "List of Companies";
		$companies = Companies::active()->orderBy('company_name', 'asc')->paginate(config('app.item_per_page'));
		return view('app.reports.companies', compact('page_title', 'companies'));
	}

	public function completed_jobs(Request $request)
	{
		return view('app.reports.companies');
	}

	public function commissions(Request $request)
	{
		$page_title = "Commissions";
		$vendors = $this->vendors->get();

		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date']);
			list($start, $end) = explode(':', $form['date']);
			$bookings = Bookings::active()
				->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
				->get();

			dd($bookings);
		}

		return view('app.reports.commissions', [
			'page_title' => $page_title,
			'vendors'    => $vendors
		]);
	}
}

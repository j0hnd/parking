<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class ReportsController extends Controller
{
	private $vendors;

	public function __construct()
	{
		$vendors_id  = null;
		$vendor_list = [];

		parent::__construct();
		$vendors = User::active()->whereHas('roles', function ($query) {
			$query->where('slug', 'vendor');
		});

		if ($vendors->count()) {
			foreach ($vendors->get() as $vendor) {
				$vendors_id[] = $vendor->members->company_id;
			}

			$vendor_list = Companies::active()->whereIn('id', $vendors_id)->orderBy('company_name', 'asc');
		}

		$this->vendors = $vendor_list;
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

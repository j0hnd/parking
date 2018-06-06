<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;


class ReportsController extends Controller implements FromCollection
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

	public function collection()
	{
		// TODO: Implement collection() method.
	}

	public function completed_jobs(Request $request)
	{
		return view('app.Reports.completed_jobs');
	}

	public function commissions(Request $request)
	{
		$page_title = "Commissions";
		$vendors = $this->vendors->get();
		$bookings = null;

		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date', 'export']);
			list($start, $end) = explode(':', $form['date']);
			if (is_null($form['vendor'])) {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
					->paginate(config('app.item_per_page'));
			} else {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('vendor_id', $form['vendor']);
					})
					->paginate(config('app.item_per_page'));
			}

			if (isset($form['export'])) {
				dd($form);
			}
		}

		return view('app.Reports.commissions', [
			'page_title' => $page_title,
			'vendors'    => $vendors,
			'bookings'   => $bookings
		]);
	}
}

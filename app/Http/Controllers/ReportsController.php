<?php

namespace App\Http\Controllers;

use App\Export\Commissions;
use App\Export\CompanyRevenues;
use App\Export\CompletedJobs;
use App\Export\TravelAgents;
use App\Models\Bookings;
use App\Models\Carpark;
use App\Models\Companies;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Excel;
use Psy\Input\CodeArgument;


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

		// if ($vendors->count()) {
		// 	foreach ($vendors->get() as $vendor) {
		// 		$vendors_id[] = $vendor->members->company_id;
		// 	}
		//
		// 	$vendor_list = Carpark::select('id', 'name')->active()->whereIn('id', $vendors_id)->orderBy('name', 'asc');
		// }

		$vendor_list = Carpark::select('id', 'name')->active()->orderBy('name', 'asc');
		$this->vendors = $vendor_list;
	}

	public function completed_jobs(Request $request)
	{
		$page_title = "Completed Jobs";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;
		$selected_date = "";

		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date', 'export']);
			list($start, $end) = explode(':', $form['date']);
			$selected_date = date('F j, Y', strtotime($start))."-".date('F j, Y', strtotime($end));
			if (is_null($form['vendor'])) {
				$bookings = Bookings::selectRaw("carparks.id AS company_id, carparks.name AS company_name, SUM(price_value) AS sales, SUM(revenue_value) AS revenue, SUM(booking_fees) AS booking_fee, SUM(CASE WHEN sms_confirmation_fee THEN sms_confirmation_fee ELSE 0 END) AS sms_fee, SUM(CASE WHEN cancellation_waiver != null THEN cancellation_waiver ELSE 0 END) AS cancellation")
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereNull('bookings.deleted_at')
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->groupBy('products.carpark_id')
					->orderBy('carparks.name', 'ASC')
					->paginate(config('app.item_per_page'));
			} else {
				$bookings = Bookings::selectRaw("carparks.id AS company_id, carparks.name AS company_name, SUM(price_value) AS sales, SUM(revenue_value) AS revenue, SUM(booking_fees) AS booking_fee, SUM(CASE WHEN sms_confirmation_fee THEN sms_confirmation_fee ELSE 0 END) AS sms_fee, SUM(CASE WHEN cancellation_waiver != null THEN cancellation_waiver ELSE 0 END) AS cancellation")
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->whereNull('bookings.deleted_at')
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->groupBy('products.carpark_id')
					->orderBy('carparks.name', 'ASC')
					->paginate(config('app.item_per_page'));

				$selected_vendor = $form['vendor'];
			}
		}

		return view('app.Reports.completed_jobs', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor,
			'selected_date'   => $selected_date
		]);
	}

	public function commissions(Request $request)
	{
		$page_title = "Commissions";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;
		$selected_date = "";
		$start = "";
		$end = "";

		$form = $request->only(['vendor', 'date', 'export', 'per_page']);

		if (!empty($form)) {
			if (!is_null($form['date'])) {
				list($start, $end) = explode(':', $form['date']);
				$selected_date = date('F j, Y', strtotime($start))."-".date('F j, Y', strtotime($end));
			}

			if (!isset($form['vendor'])) {
				$form['vendor'] = null;
			}

			$per_page = isset($form['per_page']) ? $form['per_page'] : config('app.item_per_page');
		} else {
			$form['vendor'] = null;
			$per_page = config('app.item_per_page');
		}

		if (is_null($form['vendor'])) {
			if ($per_page == 'all') {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}
		} else {
			if ($per_page == 'all') {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}

			$selected_vendor = $form['vendor'];
		}

		return view('app.Reports.commissions', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor,
			'selected_date'   => $selected_date,
			'start'           => $start,
			'end'             => $end,
			'per_page'        => $per_page
		]);
	}

	public function company_revenues(Request $request)
	{
		$page_title = "Vendor Revenues";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;
		$selected_date = "";
		$start = "";
		$end = "";

		$form = $request->only(['vendor', 'date', 'export', 'per_page']);

		if (!empty($form)) {
			if (!is_null($form['date'])) {
				list($start, $end) = explode(':', $form['date']);
				$selected_date = date('F j, Y', strtotime($start))."-".date('F j, Y', strtotime($end));
			}

			if (!isset($form['vendor'])) {
				$form['vendor'] = null;
			}

			$per_page = isset($form['per_page']) ? $form['per_page'] : config('app.item_per_page');
		} else {
			$form['vendor'] = null;
			$per_page = config('app.item_per_page');
		}

		if (is_null($form['vendor'])) {
			if ($per_page == 'all') {
				$bookings = Bookings::whereNull('bookings.deleted_at')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {

				$bookings = Bookings::whereNull('bookings.deleted_at')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}
		} else {
			if ($per_page == 'all') {
				$bookings = Bookings::whereNull('bookings.deleted_at')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {
				$bookings = Bookings::whereNull('bookings.deleted_at')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}


			$selected_vendor = $form['vendor'];
		}

		return view('app.Reports.company-revenue', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor,
			'selected_date'   => $selected_date,
			'start'           => $start,
			'end'             => $end,
			'per_page'        => $per_page
		]);
	}

	public function travel_agents(Request $request)
	{
		$page_title = "Travel Agents";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;
		$selected_date = "";
		$start = "";
		$end = "";

		$form = $request->only(['vendor', 'date', 'export', 'per_page']);

		if (!empty($form)) {
			if (!is_null($form['date'])) {
				list($start, $end) = explode(':', $form['date']);
				$selected_date = date('F j, Y', strtotime($start))."-".date('F j, Y', strtotime($end));
			}

			if (!isset($form['vendor'])) {
				$form['vendor'] = null;
			}

			$per_page = isset($form['per_page']) ? $form['per_page'] : config('app.item_per_page');
		} else {
			$form['vendor'] = null;
			$per_page = config('app.item_per_page');
		}

		if (is_null($form['vendor'])) {
			if ($per_page == 'all') {
				$bookings = Bookings::active()
					->has('affiliate_bookings')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {
				$bookings = Bookings::active()
					->has('affiliate_bookings')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}
		} else {
			if ($per_page == 'all') {
				$bookings = Bookings::active()
					->has('affiliate_bookings')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->orderBy('bookings.created_at', 'desc')
					->get();
			} else {
				$bookings = Bookings::active()
					->has('affiliate_bookings')
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('carpark_id', $form['vendor']);
					})
					->orderBy('bookings.created_at', 'desc')
					->paginate($per_page);
			}

			$selected_vendor = $form['vendor'];
		}

		return view('app.Reports.travel-agents', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor,
			'selected_date'   => $selected_date,
			'start'           => $start,
			'end'             => $end,
			'per_page'        => $per_page
		]);
	}

	public function export(Request $request, Excel $excel)
	{
		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date', 'export', 'is_pdf']);
			list($start, $end) = explode(':', $form['date']);
			$ext = isset($form['is_pdf']) ? "pdf" : "xlsx";

			switch ($form['export']) {
				case "commissions";
					$filename = "Commissions-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::active()
						->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
						->orderBy('bookings.created_at', 'desc')
						->get();

					if (isset($form['vendor'])) {
						$company = Carpark::findOrFail($form['vendor']);
						$filename = "Commissions-".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::active()
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('carpark_id', $form['vendor']);
							})
							->orderBy('bookings.created_at', 'desc')
							->get();
					}

					return $excel->download(new Commissions($bookings), $filename);
					break;

				case "completed_jobs":
					$filename = "CompletedJobs-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::selectRaw("carparks.id AS company_id, carparks.name AS company_name, SUM(price_value) AS sales, SUM(revenue_value) AS revenue, SUM(booking_fees) AS booking_fee, SUM(CASE WHEN sms_confirmation_fee THEN sms_confirmation_fee ELSE 0 END) AS sms_fee, SUM(CASE WHEN cancellation_waiver != null THEN cancellation_waiver ELSE 0 END) AS cancellation")
						->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
						->whereNull('bookings.deleted_at')
						->join('products', 'products.id', '=', 'bookings.product_id')
						->join('carparks', 'carparks.id', '=', 'products.carpark_id')
						->groupBy('products.carpark_id')
						->orderBy('carparks.name', 'ASC')
						->get();

					if (isset($form['vendor'])) {
						$company = Carpark::findOrFail($form['vendor']);
						$filename = "CompletedJobs-".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::selectRaw("carparks.id AS company_id, carparks.name AS company_name, SUM(revenue_value) AS revenue, SUM(booking_fees) AS booking_fee, SUM(CASE WHEN sms_confirmation_fee THEN sms_confirmation_fee ELSE 0 END) AS sms_fee, SUM(CASE WHEN cancellation_waiver != null THEN cancellation_waiver ELSE 0 END) AS cancellation")
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('carpark_id', $form['vendor']);
							})
							->whereNull('bookings.deleted_at')
							->join('products', 'products.id', '=', 'bookings.product_id')
							->join('carparks', 'carparks.id', '=', 'products.carpark_id')
							->groupBy('products.carpark_id')
							->orderBy('carparks.name', 'ASC')
							->get();
					}

					return $excel->download(new CompletedJobs($bookings), $filename);
					break;

				case "company_revenues":
					$filename = "CompanyRevenues-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::whereNull('bookings.deleted_at')
						->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
						->join('products', 'products.id', '=', 'bookings.product_id')
						->join('carparks', 'carparks.id', '=', 'products.carpark_id')
						->orderBy('bookings.created_at', 'desc')
						->get();

					if (isset($form['vendor'])) {
						$company = Carpark::findOrFail($form['vendor']);
						$filename = "Revenue Report for ".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::whereNull('bookings.deleted_at')
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('carpark_id', $form['vendor']);
							})
							->join('products', 'products.id', '=', 'bookings.product_id')
							->join('carparks', 'carparks.id', '=', 'products.carpark_id')
							->orderBy('bookings.created_at', 'desc')
							->get();
					}

					return $excel->download(new CompanyRevenues($bookings), $filename);
					break;

				case "travel_agents":
					$filename = "TravelAgents-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::active()
						->has('affiliate_bookings')
						->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
						->orderBy('bookings.created_at', 'desc')
						->get();

					if (isset($form['vendor'])) {
						$bookings = Bookings::active()
							->has('affiliate_bookings')
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('carpark_id', $form['vendor']);
							})
							->orderBy('bookings.created_at', 'desc')
							->get();
					}

					return $excel->download(new TravelAgents($bookings), $filename);
					break;
			}
		}
	}

	public function get_booking_details(Request $request)
	{
		$response = ['success' => false];

		try {

			if ($request->ajax() and $request->isMethod('post')) {

				$date = $request->get('date');

				$id = $request->id;

				list($start, $end) = explode('-', $date);
				$start = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($start)));
				$end = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($end)));

				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') BETWEEN ? AND ?", [$start, $end])
					->whereHas('products', function ($query) use ($id) {
						$query->where('carpark_id', $id);
					})
					->orderBy('return_at', 'desc')
					->get();

				$html = view('app.Reports.partials._booking-details', ['bookings' => $bookings])->render();

				$response['success'] = true;
				$response['data'] = $html;
			}

		} catch (Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}
}

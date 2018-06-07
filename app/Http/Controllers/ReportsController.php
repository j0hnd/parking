<?php

namespace App\Http\Controllers;

use App\Export\Commissions;
use App\Export\CompanyRevenues;
use App\Export\CompletedJobs;
use App\Models\Bookings;
use App\Models\Companies;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Excel;


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
		$page_title = "Completed Jobs";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;

		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date', 'export']);
			list($start, $end) = explode(':', $form['date']);
			if (is_null($form['vendor'])) {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') > ? AND DATE_FORMAT(return_at, '%Y-%m-%d') < ?", [$start, $end])
					->orderBy('return_at', 'desc')
					->paginate(config('app.item_per_page'));
			} else {
				$bookings = Bookings::active()
					->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') > ? AND DATE_FORMAT(return_at, '%Y-%m-%d') < ?", [$start, $end])
					->whereHas('products', function ($query) use ($form) {
						$query->where('vendor_id', $form['vendor']);
					})
					->orderBy('return_at', 'desc')
					->paginate(config('app.item_per_page'));

				$selected_vendor = $form['vendor'];
			}
		}

		return view('app.Reports.completed_jobs', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor
		]);
	}

	public function commissions(Request $request)
	{
		$page_title = "Commissions";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;

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

				$selected_vendor = $form['vendor'];
			}
		}

		return view('app.Reports.commissions', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor
		]);
	}

	public function company_revenues(Request $request)
	{
		$page_title = "Company Revenues";
		$vendors = $this->vendors->get();
		$bookings = null;
		$selected_vendor = null;

		if ($request->isMethod('post')) {
			$form = $request->only(['vendor', 'date', 'export']);
			list($start, $end) = explode(':', $form['date']);
			if (is_null($form['vendor'])) {
				$bookings = Bookings::selectRaw("companies.id, companies.company_name, SUM(price_value - revenue_value) AS revenue")
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
					->whereNull('bookings.deleted_at')
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('companies', 'companies.id', '=', 'products.vendor_id')
					->groupBy('products.vendor_id')
					->paginate(config('app.item_per_page'));
			} else {
				$bookings = Bookings::selectRaw("companies.id, companies.company_name, SUM(price_value - revenue_value) AS revenue")
					->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
					->whereNull('bookings.deleted_at')
					->whereHas('products', function ($query) use ($form) {
						$query->where('vendor_id', $form['vendor']);
					})
					->join('products', 'products.id', '=', 'bookings.product_id')
					->join('companies', 'companies.id', '=', 'products.vendor_id')
					->groupBy('products.vendor_id')
					->paginate(config('app.item_per_page'));

				$selected_vendor = $form['vendor'];
			}
		}

		return view('app.Reports.company-revenue', [
			'page_title'      => $page_title,
			'vendors'         => $vendors,
			'bookings'        => $bookings,
			'selected_vendor' => $selected_vendor
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
						->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
						->get();

					if (isset($form['vendor'])) {
						$company = Companies::findOrFail($form['vendor']);
						$filename = "Commissions-".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::active()
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('vendor_id', $form['vendor']);
							})
							->get();
					}

					return $excel->download(new Commissions($bookings), $filename);
					break;

				case "completed_jobs":
					$filename = "CompletedJobs-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::active()
						->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') > ? AND DATE_FORMAT(return_at, '%Y-%m-%d') < ?", [$start, $end])
						->orderBy('return_at', 'desc')
						->get();

					if (isset($form['vendor'])) {
						$company = Companies::findOrFail($form['vendor']);
						$filename = "CompletedJobs-".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::active()
							->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') > ? AND DATE_FORMAT(return_at, '%Y-%m-%d') < ?", [$start, $end])
							->whereHas('products', function ($query) use ($form) {
								$query->where('vendor_id', $form['vendor']);
							})
							->orderBy('return_at', 'desc')
							->get();
					}

					return $excel->download(new CompletedJobs(				$bookings), $filename);
					break;

				case "company_revenues":
					$filename = "CompanyRevenues-".Carbon::now()->format('Ymd').".{$ext}";
					$bookings = Bookings::selectRaw("companies.id, companies.company_name, SUM(price_value - revenue_value) AS revenue")
						->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
						->whereNull('bookings.deleted_at')
						->join('products', 'products.id', '=', 'bookings.product_id')
						->join('companies', 'companies.id', '=', 'products.vendor_id')
						->groupBy('products.vendor_id')
						->get();

					if (isset($form['vendor'])) {
						$company = Companies::findOrFail($form['vendor']);
						$filename = "Revenue Report for ".ucwords($company->company_name)."-".Carbon::now()->format('Ymd').".{$ext}";
						$bookings = Bookings::selectRaw("companies.id, companies.company_name, SUM(price_value - revenue_value) AS revenue")
							->whereRaw("DATE_FORMAT(drop_off_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?", [$start, $end])
							->whereNull('bookings.deleted_at')
							->whereHas('products', function ($query) use ($form) {
								$query->where('vendor_id', $form['vendor']);
							})
							->join('products', 'products.id', '=', 'bookings.product_id')
							->join('companies', 'companies.id', '=', 'products.vendor_id')
							->groupBy('products.vendor_id')
							->get();
					}

					return $excel->download(new CompanyRevenues(				$bookings), $filename);
					break;
			}
		}
	}
}

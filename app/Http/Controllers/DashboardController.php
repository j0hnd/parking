<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = "Dashboard";
        $start = Carbon::now()->startOfMonth();
        $now = Carbon::now();
        $area_label_months = [
        	'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July',
			'August',
			'September',
			'October',
			'November',
			'December'
		];

        $area_data = [
			0  => 0,
			1  => 0,
			2  => 0,
			3  => 0,
			4  => 0,
			5  => 0,
			6  => 0,
			7  => 0,
			8  => 0,
			9  => 0,
			10 => 0,
			11 => 0
		];


        $new_bookings = Bookings::active()
			->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(created_at, '%Y-%m-%d') <= ?",
				[$start->format('Y-m-d'), $now->format('Y-m-d')])
			->count();

        $total_bookings = Bookings::active()->count();

        $revenue = Bookings::active()
			->selectRaw("(SUM(revenue_value) + SUM(booking_fees) + SUM(CASE WHEN sms_confirmation_fee THEN sms_confirmation_fee ELSE 0 END) + SUM(CASE WHEN cancellation_waiver THEN cancellation_waiver ELSE 0 END)) AS revenue")
			->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(created_at, '%Y-%m-%d') <= ?",
				[$start->format('Y-m-d'), $now->format('Y-m-d')])
			->first();

        $completed_jobs = Bookings::active()
			->whereRaw("DATE_FORMAT(return_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(return_at, '%Y-%m-%d') <= ?",
				[$start->format('Y-m-d'), $now->format('Y-m-d')])
			->count();

		$monthly_revenue = Bookings::selectRaw("DATE_FORMAT(bookings.created_at, '%Y-%m') AS month, SUM(bookings.price_value - bookings.revenue_value) AS revenue")
			->whereRaw("DATE_FORMAT(bookings.created_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(bookings.created_at, '%Y-%m-%d') <= ?",
				[$start->format('Y-m-d'), $now->format('Y-m-d')])
			->whereNull('bookings.deleted_at')
			->join('products', 'products.id', '=', 'bookings.product_id')
			->join('companies', 'companies.id', '=', 'products.vendor_id')
			->groupBy(DB::raw("DATE_FORMAT(bookings.created_at, '%Y-%m')"))
			->get();

		$summary = Bookings::active()
			->selectRaw("DATE_FORMAT(created_at, '%M') AS MONTH, SUM(price_value) AS sales, (SUM(revenue_value) + SUM(CASE WHEN (booking_fees AND booking_fees IS NOT NULL) THEN booking_fees ELSE 0 END) + SUM(CASE WHEN sms_confirmation_fee AND sms_confirmation_fee IS NOT NULL THEN sms_confirmation_fee ELSE 0 END) + SUM(CASE WHEN (cancellation_waiver AND cancellation_waiver IS NOT NULL)  THEN cancellation_waiver ELSE 0 END)) AS revenue")
			->whereRaw("YEAR(created_at) = ?", [date('Y')])
			->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
			->get();

		if ($summary) {
			foreach ($summary as $_summary) {
				$key = array_search($_summary->MONTH, $area_label_months);
				$area_data[$key] = number_format($_summary->revenue, 2);
			}

			$area_label_months = json_encode($area_label_months);
			$area_data = json_encode($area_data);
		}


        return view('app.Dashboard.index', [
        	'page_title'       => $page_title,
			'new_bookings'     => $new_bookings,
			'total_bookings'   => $total_bookings,
			'revenue' 		   => $revenue,
			'completed_jobs'   => $completed_jobs,
			'monthly_revenues' => $monthly_revenue,
			'summary'          => $summary,
			'area_months'      => $area_label_months,
			'area_data'        => $area_data
		]);
    }
}

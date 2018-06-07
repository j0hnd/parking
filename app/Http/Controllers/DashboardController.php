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

        $new_bookings = Bookings::active()
			->whereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') >= ? AND DATE_FORMAT(created_at, '%Y-%m-%d') <= ?",
				[$start->format('Y-m-d'), $now->format('Y-m-d')])
			->count();

        $total_bookings = Bookings::active()->count();

        $revenue = Bookings::active()
			->selectRaw("SUM(revenue_value) AS revenue")
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

        return view('app.Dashboard.index', [
        	'page_title'       => $page_title,
			'new_bookings'     => $new_bookings,
			'total_bookings'   => $total_bookings,
			'revenue' 		   => $revenue,
			'completed_jobs'   => $completed_jobs,
			'monthly_revenues' => $monthly_revenue
		]);
    }
}

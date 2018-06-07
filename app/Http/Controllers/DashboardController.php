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

        return view('app.Dashboard.index', [
        	'page_title' => $page_title,
			'new_bookings' => $new_bookings,
			'total_bookings' => $total_bookings,
			'revenue' => $revenue,
			'completed_jobs' => $completed_jobs
		]);
    }
}

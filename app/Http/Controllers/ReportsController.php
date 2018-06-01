<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Companies;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
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
		$bookings = Bookings::active()->orderBy('created_at', 'desc')->first();

		return view('app.reports.companies');
	}
}

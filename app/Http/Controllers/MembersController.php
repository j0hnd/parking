<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\Request;

class MembersController extends Controller
{
	public function dashboard(Request $request)
	{
		return view('member-portal.dashboard');
	}
}

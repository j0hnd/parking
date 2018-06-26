<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliatesController extends Controller
{
    public function index()
	{
		$page_title = 'Affiliates';
		return view('app.Affiliates.index', ['page_title' => $page_title]);
	}

	public function create()
	{
		$page_title = 'Create Affiliates';
		return view('app.Affiliates.create', ['page_title' => $page_title]);
	}
}

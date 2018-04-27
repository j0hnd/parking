<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = "Dashboard";
        return view('app.Dashboard.index', compact('page_title'));
    }
}

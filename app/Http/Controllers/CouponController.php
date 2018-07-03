<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $page_title = "List of Coupons";
        $generated_coupons = Promocode::paginate(config('app.item_per_page'));
        return view('app.Coupon.index', compact('page_title', 'generated_coupons'));
    }

    public function generate()
    {
        return view('app.Coupon.generate');
    }
}

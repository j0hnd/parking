<?php

namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;
use Trexology\Promocodes\Model\Promocodes;


class CouponController extends Controller
{
    public function index()
    {
        $page_title = "List of Coupons";
        $promocodes = Promocode::whereRaw("expiry_date > ?", date('Y-m-d'))->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
        return view('app.Coupon.index', compact('page_title', 'promocodes'));
    }

    public function generate()
    {
		$page_title = "Generate Coupons";
		return view('app.Coupon.generate', ['page_title' => $page_title]);
    }

    public function store(Promocodes $promocodes, Request $request)
	{
		if ($request->isMethod('post')) {
			$form = $request->except(['token']);
			$form['reward'] = round($form['reward'] / 100, 2);

			if ($data = $promocodes->generateAndSave($form['no_coupons'], $form['reward'])) {
				if (count($data)) {
					$expiry_date = str_replace('/', '-', $form['expiry_date']);

					foreach ($data as $dt) {
						Promocodes::findOrFail($dt->id)->update(['expiry_date' => date('Y-m-d', strtotime($expiry_date))]);
					}
				}
				return back()->with('success', 'Promo codes generated!');
			}
		}

		return back()->withErrors(['error', 'Unable to generate promo codes']);
	}
}

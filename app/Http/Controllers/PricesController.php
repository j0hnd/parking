<?php

namespace App\Http\Controllers;

use App\Models\PriceHistory;
use App\Models\Products;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Http\Request;
use DB;


class PricesController extends Controller
{
    public function get_price(Request $request)
    {
        $product = Products::findOrFail($request->product_id);
        $price = Prices::findOrFail($request->price_id);

        return response()->json(['id' => $price->id, 'price_value' => $price->price_value, 'revenue_share' => $product->revenue_share]);
    }

    public function get_price_requests(Request $request)
	{
		$page_title = "Price Changes Requests";
		$requests = PriceHistory::get_requests();

		return view('app.Prices.requests', ['page_title' => $page_title, 'requests' => $requests]);
	}

	public function approved(Request $request)
	{
		$response = ['success' => false, 'message' => 'Unable to approved request'];

		try {

			if ($request->ajax() and $request->isMethod('post')) {
				$request = PriceHistory::where('price_id', $request->price)->first();
				$price = Prices::findOrFail($request->price_id);
				$user = Sentinel::getUser();

				DB::beginTransaction();

				$form = [
					'no_of_days'  => $request->no_of_days,
					'price_month' => $request->price_month,
					'price_year'  => $request->price_year,
					'price_value' => $request->price_value
				];

				if ($price->update($form)) {
					if ($request->update(['approved_at' => Carbon::now(), 'approved_by' => $user->id])) {
						DB::commit();

						$requests = PriceHistory::get_requests();

						$html = view('app.Prices.partials.list', ['requests' => $requests]);

						$response = ['success' => true, 'message' => 'Price changed has been approved', 'html' => $html];
					} else {
						DB::rollback();
					}
				} else {
					DB::rollback();
				}
			}

		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function declined(Request $request)
	{
		$response = ['success' => false, 'message' => 'Unable to decline request'];

		try {

			if ($request->ajax() and $request->isMethod('post')) {
				$request = PriceHistory::where('price_id', $request->price)->first();

				if ($request->update(['deleted_at' => Carbon::now()])) {
					$requests = PriceHistory::get_requests();

					$html = view('app.Prices.partials.list', ['requests' => $requests]);

					$response = ['success' => true, 'message' => 'Price changed has been declined', 'html' => $html];
				}
			}

		} catch (\Exception $e) {
			dd($e);
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}
}

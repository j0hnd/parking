<?php

namespace App\Http\Controllers;

use App\Models\Members;
use App\Models\Messages;
use App\Models\PriceHistory;
use App\Models\Products;
use App\Models\Airports;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use Sentinel;
use Illuminate\Http\Request;
use DB;


class PricesController extends Controller
{
    public function get_price(Request $request)
    {
        $product          = Products::findOrFail($request->product_id);
        $price            = Prices::findOrFail($request->price_id);
		$airport          = Airports::findOrFail($request->airport_id);
		$terminal_options = null;

		if (isset($airport->subcategories)) {
			foreach ($airport->subcategories as $terminal) {
				$terminal_options .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
			}
		}

        return response()->json([
            'id'            => $price->id,
            'price_value'   => $price->price_value,
            'revenue_share' => $product->revenue_share,
			'terminals'     => $terminal_options
        ]);
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
			$user = Sentinel::getUser();

			if ($request->ajax() and $request->isMethod('post')) {
				$price_request = PriceHistory::findOrFail($request->price);
				$price = Prices::findOrFail($price_request->price_id);
				$changed_by = Members::where('user_id', $price_request->changed_by)->first();

				$form = [
					'no_of_days'  => $price_request->no_of_days,
					'price_month' => $price_request->price_month,
					'price_year'  => $price_request->price_year,
					'price_value' => $price_request->price_value
				];

				DB::beginTransaction();

				if ($price->update($form)) {
					if ($price_request->update(['approved_at' => Carbon::now(), 'approved_by' => $user->id])) {
						Messages::create([
							'user_id' => $changed_by->user_id,
							'subject' => 'Price Change Approved',
							'message' => 'Your price change request last ' . date('d/m/Y', strtotime($price_request->created_at)) . ' has been approved.',
							'name'    => $changed_by->first_name,
							'status'  => 'unread'
						]);

						DB::commit();

						$requests = PriceHistory::get_requests();

						$html = view('app.Prices.partials.list', ['requests' => $requests])->render();

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
				$price_request = PriceHistory::findOrFail($request->price);

				if ($price_request->update(['deleted_at' => Carbon::now()])) {
					$requests = PriceHistory::get_requests();

					$changed_by = Members::where('user_id', $price_request->changed_by)->first();

					Messages::create([
						'user_id' => $changed_by->user_id,
						'subject' => 'Price Change Declined',
						'message' => 'Your price change request last ' . date('d/m/Y', strtotime($price_request->created_at)) . ' has been declined.',
						'name'    => $changed_by->first_name,
						'status'  => 'unread'
					]);

					$html = view('app.Prices.partials.list', ['requests' => $requests])->render();

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

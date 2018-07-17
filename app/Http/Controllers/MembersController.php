<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembersFormRequest;
use App\Http\Requests\PriceHistoryFormRequest;
use App\Models\Affiliates;
use App\Models\Bookings;
use App\Models\Carpark;
use App\Models\Companies;
use App\Models\Members;
use App\Models\Messages;
use App\Models\PriceHistory;
use App\Models\Products;
use App\Models\Tools\Prices;
use App\Models\User;
use Sentinel;
use Illuminate\Http\Request;
use Hash;

class MembersController extends Controller
{
	public function dashboard(Request $request)
	{
		$user = Sentinel::getUser();
		$inbox = null;
		$affiliate = null;

		if ($user->roles[0]->slug == 'member') {
			$bookings = Bookings::where('user_id', $user->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));

			$total_bookings = Bookings::whereNull('bookings.deleted_at')
				->where('user_id', $user->id)
				->get();

			$ongoing_bookings = Bookings::active()
				->whereRaw('DATE_FORMAT(return_at, "%Y-%m-%d") > CURDATE()')
				->where('user_id', $user->id)
				->get();
		} else {
			if ($user->roles[0]->slug == 'travel_agent') {
				$bookings = Bookings::where('user_id', $user->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));

				$total_bookings = Bookings::whereNull('bookings.deleted_at')
					->where('user_id', $user->id)
					->get();

				$ongoing_bookings = Bookings::active()
					->whereRaw('DATE_FORMAT(return_at, "%Y-%m-%d") > CURDATE()')
					->where('user_id', $user->id)
					->get();

				$affiliate = Affiliates::active()->where('travel_agent_id', $user->id)->first();
			} else {
				if (is_null($user->members->carpark)) {
					$total_bookings = null;
					$ongoing_bookings = null;
					$bookings = null;
				} else {
					$carpark_id = $user->members->carpark->id;

					$total_bookings = Bookings::whereNull('bookings.deleted_at')
						->whereHas('products', function ($query) use ($carpark_id) {
							$query->where('carpark_id', $carpark_id);
						})
						->join('products', 'products.id', '=', 'bookings.product_id')
						->join('companies', 'companies.id', '=', 'products.vendor_id')
						->get();

					$ongoing_bookings = Bookings::active()
						->whereRaw('DATE_FORMAT(return_at, "%Y-%m-%d") > CURDATE()')
						->whereHas('products', function ($query) use ($carpark_id) {
							$query->where('carpark_id', $carpark_id);
						})
						->get();

					$bookings = Bookings::selectRaw("bookings.booking_id, bookings.order_title, bookings.created_at, bookings.drop_off_at, bookings.return_at, bookings.price_value,
			                                 bookings.revenue_value, bookings.sms_confirmation_fee, bookings.cancellation_waiver, bookings.booking_fees, bookings.is_paid")
						->whereNull('bookings.deleted_at')
						->whereHas('products', function ($query) use ($carpark_id) {
							$query->where('carpark_id', $carpark_id);
						})
						->join('products', 'products.id', '=', 'bookings.product_id')
						->paginate(config('app.item_per_page'));
				}

			}
		}

//		if (is_null($user->members->company)) {
//			$count = 0;
//			$inbox = null;
//		} else {
//			$new_messages = Messages::where('status', 'unread')
//				->whereIn('booking_id', Bookings::get_user_bookings($user->members->company->id));
//
//			$new_messages = Messages::where('user_id', $user->id);
//
//			$count = $new_messages->count();
//			$inbox = $new_messages->get()->toArray();
//		}

		$new_messages = Messages::where(['user_id' => $user->id, 'status' => 'unread']);

		$count = $new_messages->count();
		$inbox = $new_messages->get()->toArray();

		return view('member-portal.dashboard', compact('bookings', 'total_bookings', 'ongoing_bookings', 'count', 'inbox', 'affiliate'));
	}

	public function display_profile()
	{
		$user = Sentinel::getUser();
		$new_messages = Messages::where(['user_id' => $user->id, 'status' => 'unread']);

		$count = $new_messages->count();
		$inbox = $new_messages->get()->toArray();

		return view('member-portal.profile', compact('count', 'inbox'));
	}

	public function update_profile(MembersFormRequest $request)
	{
		if ($request->isMethod('post')) {
			try {
				$form = $request->except(['_token']);

				$user = User::findOrFail(Sentinel::getUser()->id);
				if (!empty($form['new_password']) and !empty($form['confirm_password'])) {
					$user->update(['password' => Hash::make($form['new_password'])]);
				}

				$member_data = [
					'first_name' => $form['first_name'],
					'last_name' => $form['last_name']
				];

				if (isset($form['company'])) {
					$company_data = [
						'company_name' => $form['company']['company_name'],
						'phone_no' => $form['company']['phone_no'],
						'mobile_no' => $form['company']['mobile_no'],
						'email' => $form['company']['email'],
					];

					if (Companies::where('id', $form['cid'])->count()) {
						$user->members->company->update($company_data);
					} else {
						$company = Companies::create($company_data);
						$member_data['company_id'] = $company->id;
					}
				}

				if ($user->members->update($member_data)) {
					return redirect('/members/profile')->with('success', 'Profile has been updated!');
				} else {
					return redirect('/members/profile')->withErrors(['errors' => 'Unable to update profile']);
				}
			} catch (\Exception $e) {
				abort(502, $e->getMessage());
			}
		}
	}

	public function display_inbox()
	{
		$user = Sentinel::getUser();

		$date = date("l, M d, Y");

		if (is_null($user->members->company)) {
			$count = 0;
			$inbox = null;
			$messages = null;
		} else {
			$new_messages = Messages::where(['user_id' => $user->id, 'status' => 'unread']);

			$count = $new_messages->count();
			$inbox = $new_messages->get()->toArray();

			$messages = Messages::where('user_id', $user->id)->paginate(config('app.item_per_page'));
		}


		return view ('/member-portal.inbox', compact('count', 'inbox', 'messages'))->with('date',$date);
	}

	public function display_email($id)
	{
		$user = Sentinel::getUser();
		$message = Messages::findOrFail($id);
		$message->update(['status' => 'read']);

		$messages = Messages::where(['user_id' => $user->id, 'status' => 'unread']);

		$count = $messages->count();
		$inbox = $messages->get()->toArray();

		return view ('/member-portal.email', compact('count', 'inbox', 'message'));
	}

	public function products(Request $request)
	{
		$user = Sentinel::getUser();
		$new_messages = Messages::where(['user_id' => $user->id, 'status' => 'unread']);

		$count = $new_messages->count();
		$inbox = $new_messages->get()->toArray();

		$products = Products::selectRaw("products.id as product_id, airports.airport_name, price_categories.category_name, carparks.name as carpark_name")
			->join('product_airports', 'product_airports.product_id', '=', 'products.id')
			->join('airports', 'airports.id', '=', 'product_airports.airport_id')
			->join('carparks', 'carparks.id', '=', 'products.carpark_id')
			->join('prices', 'prices.product_id', '=', 'products.id')
			->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
			->whereNull('products.deleted_at')
			->where('products.carpark_id', $user->members->carpark->id)
//			->where('products.vendor_id', $user->members->company->id)
			->groupBy('prices.product_id')
			->get();

		return view('member-portal.products', compact('inbox', 'count', 'products'));
	}

	public function get_product_details(Request $request)
	{
		$response = ['success' => true];

		try {
			$user = Sentinel::getUser();

			if ($request->ajax() and $request->isMethod('post')) {
				$prices = Products::selectRaw("products.id as product_id, prices.id as price_id, airports.airport_name, price_categories.category_name, carparks.name as carpark_name, prices.no_of_days, prices.price_month, prices.price_year, prices.price_value")
					->join('product_airports', 'product_airports.product_id', '=', 'products.id')
					->join('airports', 'airports.id', '=', 'product_airports.airport_id')
					->join('carparks', 'carparks.id', '=', 'products.carpark_id')
					->join('prices', 'prices.product_id', '=', 'products.id')
					->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
					->whereNull('products.deleted_at')
					->where([
						'products.carpark_id' => $user->members->carpark->id,
//						'products.vendor_id' => $user->members->company->id,
						'prices.product_id' => $request->id
					])
					->get();

				$html = view('member-portal.partials.price-list', ['prices' => $prices])->render();

				$response = ['success' => true, 'html' => $html];
			}

		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function get_price(Request $request)
	{
		$user = Sentinel::getUser();
		$price = Prices::findOrFail($request->price);
		$form = view('member-portal.partials.product-update', compact('price', 'user'))->render();
		$response = ['success' => true, 'form' => $form];

		return response()->json($response);
	}

	public function price(PriceHistoryFormRequest $request)
	{
		$response = ['success' => false];

		try {
			if ($request->ajax() and $request->isMethod('post')) {
				$user = Sentinel::getUser();
				$price = Prices::findOrFail($request->price);
				$form = $request->except(['_token']);
				$form['price_id'] = $price->id;
				$form['changed_by'] = $user->id;

				if (PriceHistory::create($form)) {
					$response = ['success' => true, 'message' => 'Your price updates are subject for approval'];
				} else {
					$response['message'] = "Unable to update price";
				}
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function get_product(Request $request)
	{
		$user = Sentinel::getUser();
		$product = Products::findOrFail($request->id);
		$form = view('member-portal.partials.product-details', compact('product', 'user'))->render();
		$response = ['success' => true, 'form' => $form];

		return response()->json($response);
	}

	public function update_product(Request $request)
	{
		$response = ['success' => false, 'message' => 'Invalid request'];

		try {
			if ($request->ajax() and $request->isMethod('post')) {
				$product = Products::findOrFail($request->id);
				$form = $request->only(['description', 'on_arrival', 'on_return']);

				if ($product->update($form)) {
					$response = ['success' => true, 'message' => 'Product has been updated'];
				}
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}
}

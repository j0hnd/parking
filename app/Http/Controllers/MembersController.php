<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembersFormRequest;
use App\Models\Bookings;
use App\Models\Companies;
use App\Models\Members;
use App\Models\User;
use Sentinel;
use Illuminate\Http\Request;
use Hash;

class MembersController extends Controller
{
	public function dashboard(Request $request)
	{
		$user = Sentinel::getUser();
		if ($user->roles[0]->slug == 'member') {
			$bookings = Bookings::where('customer_id', $user->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
		} else {
			$company_id = $user->members->company->id;

			$total_bookings = Bookings::whereNull('bookings.deleted_at')
				->whereHas('products', function ($query) use ($company_id) {
					$query->where('vendor_id', $company_id);
				})
				->join('products', 'products.id', '=', 'bookings.product_id')
				->join('companies', 'companies.id', '=', 'products.vendor_id')
				->groupBy('products.vendor_id')
				->get();

			$ongoing_bookings = Bookings::active()
				->whereRaw('DATE_FORMAT(return_at, "%Y-%m-%d") > CURDATE()')
				->whereHas('products', function ($query) use ($company_id) {
					$query->where('vendor_id', $company_id);
				})
				->get();

			$bookings = Bookings::selectRaw("bookings.booking_id, bookings.order_title, bookings.created_at, bookings.drop_off_at, bookings.return_at, bookings.price_value,
			                                 bookings.revenue_value, bookings.sms_confirmation_fee, bookings.cancellation_waiver, bookings.booking_fees")
				->whereNull('bookings.deleted_at')
				->whereHas('products', function ($query) use ($company_id) {
					$query->where('vendor_id', $company_id);
				})
				->join('products', 'products.id', '=', 'bookings.product_id')
				->join('companies', 'companies.id', '=', 'products.vendor_id')
				->groupBy('products.vendor_id')
				->paginate(config('app.item_per_page'));
		}

		return view('member-portal.dashboard', compact('bookings', 'total_bookings', 'ongoing_bookings'));
	}

	public function display_profile()
	{
		return view('member-portal.profile');
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

	public function display_inbox(){

		$date = date("l, M d, Y");

		return view ('/member-portal.inbox')->with('date',$date);
	}
	public function display_email(){
		return view ('/member-portal.email');
	}
}

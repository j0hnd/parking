<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembersFormRequest;
use App\Models\Bookings;
use App\Models\Companies;
use App\Models\Members;
use App\Models\Messages;
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

		if ($user->roles[0]->slug == 'member') {
			$bookings = Bookings::where('customer_id', $user->id)->whereNull('deleted_at')->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
		} else {
			$company_id = $user->members->company->id;
			$bookings = Bookings::selectRaw("companies.id, companies.company_name, SUM(price_value) AS revenue")
				->whereNull('bookings.deleted_at')
				->whereHas('products', function ($query) use ($company_id) {
					$query->where('vendor_id', $company_id);
				})
				->join('products', 'products.id', '=', 'bookings.product_id')
				->join('companies', 'companies.id', '=', 'products.vendor_id')
				->groupBy('products.vendor_id')
				->paginate(config('app.item_per_page'));
			$new_messages = Messages::where('status', 'unread');
			$count = $new_messages->count();
			$inbox = $new_messages->get()->toArray();
		}

		return view('member-portal.dashboard', compact('bookings', 'count', 'inbox'));
	}

	public function display_profile()
	{
		$new_messages = Messages::where('status', 'unread');
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

	public function display_inbox(){
		$user = Sentinel::getUser();
// var_dump($this->get_user_bookings($user->members->company->id));exit;
		$date = date("l, M d, Y");
		$new_messages = Messages::where('status', 'unread')
								->whereIn('booking_id', $this->get_user_bookings($user->members->company->id));

		$count = $new_messages->count();
		$inbox = $new_messages->get()->toArray();

		$messages = Messages::whereIn('booking_id', $this->get_user_bookings($user->members->company->id))
							->paginate(config('app.item_per_page'));

		return view ('/member-portal.inbox', compact('count', 'inbox', 'messages'))->with('date',$date);
	}

	public function display_email($id){
		$user = Sentinel::getUser();
		$message = Messages::where('id', $id)->first();
		$message->update(['status' => 'read']);

		$messages = Messages::where('status', 'unread')
							->whereIn('booking_id', $this->get_user_bookings($user->members->company->id));

		$count = $messages->count();
		$inbox = $messages->get()->toArray();
		return view ('/member-portal.email', compact('count', 'inbox', 'message'));
	}

	private function get_user_bookings($company_id) {
		$bookings = Bookings::join('products', 'bookings.product_id', 'products.id')
							->join('carparks', 'products.carpark_id', 'carparks.id')
							->where('carparks.company_id', $company_id);

		return $bookings->pluck('booking_id')->toArray();
	}
}
